<?php

namespace App\Controller;

use App\Entity\fil_messages;
use App\Entity\messages;
use App\Entity\User;
use App\Service\notificationMailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Message controller.
 *
 * @Route("conversation")
 */
class FilMessagesController extends Controller
{
	/**
	 * Lists all message entities.
	 *
	 * @Route("/", name="conversation_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$conv = $this->getDoctrine()->getRepository(fil_messages::class)->selectConversation($user->getId());
		return $this->render('filMessages/index.html.twig', array(
			'conversations' => $conv,
		));
	}

	/**
	 * Finds and displays a message entity.
	 *
	 * @Route("/{id}", name="conversation_show")
	 * @Method({"GET","POST"})
	 */
	public function showAction(Request $request, fil_messages $conversation)
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$message = new messages();
		$user = $this->getUser();
		$form = $this->createForm('App\Form\messagesType', $message);
		$form->handleRequest($request);
		if($this->getDoctrine()->getRepository(fil_messages::class)->authorisation($user->getId(), $conversation->getId()) == null){
			$conv = $this->getDoctrine()->getRepository(fil_messages::class)->selectConversation($user->getId());
			return $this->render('filMessages/index.html.twig', array(
				'conversations' => $conv,
			));
		}
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$userId = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
			$message->setAuthor($userId);
			$message->setfilMessages($conversation);
			$em->persist($message);
			$em->flush();
			$conversations = $this->getDoctrine()->getRepository(messages::class)->findBy(array('filMessages' => $conversation->getId()));
			return $this->render('messages/show.html.twig', array(
				'messages' => $conversations,
				'message' => $message,
				'form' => $form->createView(),
			));
		}
		$conversations = $this->getDoctrine()->getRepository(messages::class)->findBy(array('filMessages' => $conversation->getId()));
		return $this->render('messages/show.html.twig', array(
			'messages' => $conversations,
			'message' => $message,
			'form' => $form->createView(),
		));
	}

}

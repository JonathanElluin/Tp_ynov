<?php

namespace App\Controller;


use App\Entity\messages;
use App\Entity\fil_messages;
use App\Service\notificationMailer;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Message controller.
 *
 * @Route("messages")
 */
class messagesController extends Controller
{
    /**
     * Lists all message entities.
     *
     * @Route("/", name="messages_index")
     * @Method("GET")
     */
    public function indexAction()
    {
	    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('App:messages')->findAll();

        return $this->render('messages/index.html.twig', array(
            'messages' => $messages,
        ));
    }

    /**
     * Creates a new message entity.
     *
     * @Route("/fil/{id}", name="messages_response")
     * @Method({"GET", "POST"})
     */
    public function newResponse(Request $request, messages $messages)
    {
	    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
	    $message = new messages();
        $fils = new fil_messages();
        //recuperer le parametre
	    if(!$messages){
	    	$messages = 0;
	    }
        $form = $this->createForm('App\Form\messagesType', $message);
	    $formFil = $this->createForm('App\Form\filMessageType', $fils);
        $form->handleRequest($request);
	    $formFil->handleRequest($request);
	    if ($form->isSubmitted() && $form->isValid()) {
		    /*$mail = new notificationMailer();
		    $mailer = \Swift_Message::class;*/
            $em = $this->getDoctrine()->getManager();
            if($fil = 0){
	            $em->persist($fils);
	            $em->flush();
	            $message->setfilMessages($fils->getId());
            }else{
	            $exist = $this->getDoctrine()->getRepository(messages::class)->find($messages);
	            $filMessage = $exist->getfilMessages();
	            if (!$exist) {
		            $em->persist($fils);
		            $em->flush();
		            $message->setfilMessages($fils);
	            }else{
		            $message->setfilMessages($filMessage);
	            }
            }
		    $message->setAuthor($this->getUser());
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('messages_response', array('id' => $message->getId()));
        }
	    //$this->addFlash('success', $message);
        return $this->render('messages/response.html.twig', array(
            'messages' => $message,
            'fil' => $messages,
            'form' => $form->createView(),
	        'formFil' => $formFil->createView(),
        ));
    }

	/**
	 * Creates a new message entity.
	 *
	 * @Route("/new", name="messages_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$em = $this->getDoctrine()->getManager();
		$message = new messages();
		$fils = new fil_messages();
		$form = $this->createForm('App\Form\messagesType', $message);
		$formFil = $this->createForm('App\Form\filMessageType', $fils, ['me' => $this->getUser()->getId()]);
		$form->handleRequest($request);
		$formFil->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$fils->addDestinataire($this->getUser());
			$em->persist($fils);
			$em->flush();
			$notification = new notificationMailer($this->get('mailer'));
			//$notification->indexAction("nouvelle conversation", "", );
			$message->setfilMessages($fils);
			$message->setAuthor($this->getUser());
			$em->persist($message);
			$em->flush();
			return $this->redirectToRoute('conversation_show', array('id' => $fils->getId()));
		}
		//$this->addFlash('success', $message);
		return $this->render('messages/new.html.twig', array(
			'messages' => $message,
			'form' => $form->createView(),
			'formFil' => $formFil->createView(),
			'roles' => $this->getUser()->getRoles(),
		));
	}

    /**
     * Displays a form to edit an existing message entity.
     *
     * @Route("/{id}/edit", name="messages_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, messages $message)
    {
	    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm('App\Form\messagesType', $message);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('messages_edit', array('id' => $message->getId()));
        }

        return $this->render('messages/edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a message entity.
     *
     * @Route("/{id}", name="messages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, messages $message)
    {
	    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('messages_index');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param messages $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(messages $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('messages_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

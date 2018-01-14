<?php

namespace App\Controller;

use App\Entity\fil_messages;
use App\Entity\projects;
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
 * @Route("projects")
 */
class projectController extends Controller
{
	/**
	 * Lists all message entities.
	 *
	 * @Route("/", name="project_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$projet = $this->getDoctrine()->getRepository(projects::class)->selectProjects($user->getId());
		return $this->render('projects/index.html.twig', array(
			'conversations' => $projet,
		));
	}

	/**
	 * Creates a new message entity.
	 *
	 * @Route("/new", name="project_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$em = $this->getDoctrine()->getManager();
		$project = new projects();
		$discussion = new fil_messages();
		$form = $this->createForm('App\Form\projectsType', $project, ['me' => $this->getUser()->getId()]);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$project->setfilDiscussion($discussion);
			$em = $this->getDoctrine()->getManager();
			$em->persist($project);
			$em->flush();
			return $this->render('projects/new.html.twig', array(
				'messages' => $project,
				'form' => $form->createView(),
			));
		}
		//$this->addFlash('success', $message);
		return $this->render('projects/new.html.twig', array(
			'messages' => $project,
			'form' => $form->createView(),
		));
	}
}

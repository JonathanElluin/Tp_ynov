<?php

namespace App\Controller;

use App\Entity\charge;
use App\Entity\versement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Charge controller.
 *
 * @Route("versement")
 */
class VersementController extends Controller
{
	/**
	 * Lists all charge entities.
	 *
	 * @Route("/", name="versement_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$em = $this->getDoctrine()->getManager();

		$versement = $em->getRepository('App:versement')->findAll();

		return $this->render('versements/index.html.twig', array(
			'versements' => $versement,
		));
	}

	/**
	 * Creates a new charge entity.
	 *
	 * @Route("/new", name="versement_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$versement = new versement();
		$form = $this->createForm('App\Form\VersementType', $versement);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($versement);
			$em->flush();

			return $this->redirectToRoute('charge_show', array('id' => $versement->getId()));
		}

		return $this->render('versements/new.html.twig', array(
			'charge' => $versement,
			'form' => $form->createView(),
		));
	}

}

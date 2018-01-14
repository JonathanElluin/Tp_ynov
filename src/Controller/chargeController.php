<?php

namespace App\Controller;

use App\Entity\charge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Charge controller.
 *
 * @Route("charge")
 */
class chargeController extends Controller
{
    /**
     * Lists all charge entities.
     *
     * @Route("/", name="charge_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
	    $user = $this->getUser();
	    //$test = $this->getDoctrine()->getRepository(charge::class)->selectCharge($user->getId());
	    $conv = $this->getDoctrine()->getRepository(charge::class)->findAll();
        return $this->render('charges/index.html.twig', array(
            'charges' => $conv,
        ));
    }

    /**
     * Creates a new charge entity.
     *
     * @Route("/new", name="charge_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $charge = new Charge();
        $form = $this->createForm('App\Form\chargeType', $charge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
	        $file = $charge->getJoinFile();
	        $fileName = md5(uniqid()).'.'.$file->guessExtension();
	        $file->move(
		        $this->getParameter('file_directory'),
		        $fileName
	        );
	        $charge->setJoinFile($this->getParameter('file_directory')."/".$fileName);
            $em->persist($charge);
            $em->flush();

            return $this->redirectToRoute('charge_show', array('id' => $charge->getId()));
        }

        return $this->render('charges/new.html.twig', array(
            'charge' => $charge,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a charge entity.
     *
     * @Route("/{id}", name="charge_show")
     * @Method("GET")
     */
    public function showAction(charge $charge)
    {
        $deleteForm = $this->createDeleteForm($charge);

        return $this->render('charges/show.html.twig', array(
            'charge' => $charge,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing charge entity.
     *
     * @Route("/{id}/edit", name="charge_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, charge $charge)
    {
        $deleteForm = $this->createDeleteForm($charge);
        $editForm = $this->createForm('AppBundle\Form\chargeType', $charge);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('charge_edit', array('id' => $charge->getId()));
        }

        return $this->render('charge/edit.html.twig', array(
            'charge' => $charge,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a charge entity.
     *
     * @Route("/{id}", name="charge_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, charge $charge)
    {
        $form = $this->createDeleteForm($charge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($charge);
            $em->flush();
        }

        return $this->redirectToRoute('charge_index');
    }

    /**
     * Creates a form to delete a charge entity.
     *
     * @param charge $charge The charge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(charge $charge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('charge_delete', array('id' => $charge->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

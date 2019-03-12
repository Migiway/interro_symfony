<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    /**
     * @Route("/candidature", name="candidature")
     */
    public function index()
    {
        $candidatures = $this->getDoctrine()->getRepository(Candidature::class)->findAll();
        return $this->render('candidature/index.html.twig', [
            'controller_name' => 'CandidatureController',
            'candids' => $candidatures,
        ]);
    }



    /**
     * @Route("/candidature/create", name="create_candidature")
     */
    public function create(Request $request)
    {
        $candidature = new Candidature();

        $form = $this->createForm(CandidatureFormType::class, $candidature);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();
            return $this->redirectToRoute('candidature');
        }

        return $this->render('candidature/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/candidature/edit/{candidature}", name="edit_candidature")
     */
    public function edit (Request $request, Candidature $candidature){

        $form = $this->createForm(CandidatureFormType::class, $candidature);

        $form->add('submit', SubmitType::class, [
            'label' => 'Modifier',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();
            return $this->redirectToRoute('candidature');
        }

        return $this->render('candidature/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/candidature/delete/{candidature}", name="delete_candidature")
     */
    public function delete (Request $request, Candidature $candidature)
    {
        $candidature = $this->getDoctrine()->getRepository(Candidature::class)->find($candidature);
        $em = $this->getDoctrine()->getManager();
        $em->remove($candidature);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', 'candidature supprimé');
        return $this->redirectToRoute('candidature');
    }
}

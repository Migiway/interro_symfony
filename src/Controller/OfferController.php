<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Offer;
use App\Entity\Skill;
use App\Form\OfferFormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    /**
     * @Route("/offer", name="offer")
     */
    public function index()
    {
        $offers = $this->getDoctrine()->getRepository(Offer::class)->findAll();
        return $this->render('offer/index.html.twig', [
            'controller_name' => 'OfferController',
            'offers' => $offers,
        ]);
    }



    /**
     * @Route("/offer/create", name="create_offer")
     */
    public function create(Request $request)
    {
        $offer = new Offer();

        $form = $this->createForm(OfferFormType::class, $offer);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $skills = $this->getDoctrine()->getRepository(Skill::class)->findAll();
            foreach ($skills as $skill)
            {
                $offer->addSkillId($skill);
            }
            $em->persist($offer);
            $em->flush();
            return $this->redirectToRoute('offer');
        }

        return $this->render('offer/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/offer/edit/{offer}", name="edit_offer")
     */
    public function edit (Request $request, Offer $offer){

        $form = $this->createForm(OfferFormType::class, $offer);

        $form->add('submit', SubmitType::class, [
            'label' => 'Modifier',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();
            return $this->redirectToRoute('offer');
        }

        return $this->render('offer/edit.html.twig', array('form' => $form->createView()));
    }



    /**
     * @Route("/offer/delete/{offer}", name="delete_offer")
     */
    public function delete (Request $request, Offer $offer)
    {
        $offer = $this->getDoctrine()->getRepository(Offer::class)->find($offer);
        $em = $this->getDoctrine()->getManager();
        $em->remove($offer);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', 'Offre supprimée');
        return $this->redirectToRoute('offer');
    }
}

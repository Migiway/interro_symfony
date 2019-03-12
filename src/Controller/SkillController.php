<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    /**
     * @Route("/skill", name="skill")
     */
    public function index()
    {
        $skills = $this->getDoctrine()->getRepository(Skill::class)->findAll();
        return $this->render('skill/index.html.twig', [
            'controller_name' => 'SkillController',
            'skills' => $skills
        ]);
    }


    /**
     * @Route("/skill/create", name="create_skill")
     */
    public function create(Request $request)
    {
        $skill = new Skill();

        $form = $this->createForm(SkillFormType::class, $skill);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($skill);
            $em->flush();
            return $this->redirectToRoute('skill');
        }

        return $this->render('skill/create.html.twig', array('form' => $form->createView()));
    }



    /**
     * @Route("/skill/edit/{skill}", name="edit_skill")
     */
    public function edit (Request $request, Skill $skill){

        $form = $this->createForm(SkillFormType::class, $skill);

        $form->add('submit', SubmitType::class, [
            'label' => 'Modifier',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($skill);
            $em->flush();
            return $this->redirectToRoute('skill');
        }

        return $this->render('skill/edit.html.twig', array('form' => $form->createView()));
    }



    /**
     * @Route("/skill/delete/{skill}", name="delete_skill")
     */
    public function delete (Request $request, Skill $skill)
    {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->find($skill);
        $em = $this->getDoctrine()->getManager();
        $em->remove($skill);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', 'skill supprimé');
        return $this->redirectToRoute('skill');
    }
}

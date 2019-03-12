<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function index()
    {
        $jobs = $this->getDoctrine()->getRepository(Job::class)->findAll();
        return $this->render('job/index.html.twig', [
            'controller_name' => 'JobController',
            'jobs' => $jobs,
        ]);
    }


    /**
     * @Route("/job/create", name="create_job")
     */
    public function createJob(Request $request)
    {
        $job = new Job();

        $form = $this->createForm(JobFormType::class, $job);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
            return $this->redirectToRoute('job');
        }

        return $this->render('job/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/job/edit/{job}", name="edit_job")
     */
    public function edit (Request $request, Job $job){

        $form = $this->createForm(JobFormType::class, $job);

        $form->add('submit', SubmitType::class, [
            'label' => 'Modifier',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
            return $this->redirectToRoute('job');
        }

        return $this->render('job/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/job/delete/{job}", name="delete_job")
     */
    public function delete (Request $request, Job $job)
    {
        $job = $this->getDoctrine()->getRepository(Job::class)->find($job);
        $em = $this->getDoctrine()->getManager();
        $em->remove($job);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', 'Job supprimé');
        return $this->redirectToRoute('job');
    }
}

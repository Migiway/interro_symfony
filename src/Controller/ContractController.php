<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\ContractFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContractController extends AbstractController
{
    /**
     * @Route("/contract", name="contract")
     */
    public function index()
    {
        $contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();
        return $this->render('contract/index.html.twig', [
            'controller_name' => 'ContractController',
            'contracts' => $contracts
        ]);
    }


    /**
     * @Route("/contract/create", name="create_contract")
     */
    public function create(Request $request)
    {
        $contract = new Contract();

        $form = $this->createForm(ContractFormType::class, $contract);
        $form->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();
            return $this->redirectToRoute('contract');
        }

        return $this->render('contract/create.html.twig', array('form' => $form->createView()));
    }



    /**
     * @Route("/contract/edit/{contract}", name="edit_contract")
     */
    public function edit (Request $request, Contract $contract){

        $form = $this->createForm(ContractFormType::class, $contract);

        $form->add('submit', SubmitType::class, [
            'label' => 'Modifier',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();
            return $this->redirectToRoute('contract');
        }

        return $this->render('contract/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/contract/delete/{contract}", name="delete_contract")
     */
    public function delete (Request $request, Contract $contract)
    {
        $contract = $this->getDoctrine()->getRepository(Contract::class)->find($contract);
        $em = $this->getDoctrine()->getManager();
        $em->remove($contract);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', 'Job supprimé');
        return $this->redirectToRoute('contract');
    }
}

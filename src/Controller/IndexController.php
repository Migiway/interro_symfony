<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="acceuil")
     */
    public function acceuilAction()
    {
        return $this->render('base.html.twig');
    }
}

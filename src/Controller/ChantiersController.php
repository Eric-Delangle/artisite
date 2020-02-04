<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChantiersController extends AbstractController
{
    /**
     * @Route("/chantiers", name="chantiers")
     */
    public function index()
    {
        return $this->render('chantiers/index.html.twig', [
            'controller_name' => 'ChantiersController',
        ]);
    }
}

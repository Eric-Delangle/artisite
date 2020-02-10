<?php

namespace App\Controller;

use App\Repository\TravauxRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChantiersController extends AbstractController
{
    /**
     * @Route("/chantiers", name="chantiers")
     */
    public function index(TravauxRepository $travo)
    {
        $travaux = $travo->findAll();
        return $this->render('chantiers/index.html.twig', [
            'travaux' => $travaux
        ]);
    }
}

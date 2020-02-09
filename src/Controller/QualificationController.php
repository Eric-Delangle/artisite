<?php

namespace App\Controller;

use App\Repository\QualifsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QualificationController extends AbstractController
{
    /**
     * @Route("/qualification", name="qualification")
     */
    public function index(QualifsRepository $qualifs)
    {
       $qual= $qualifs->findAll();
        return $this->render('qualification/index.html.twig', [
            'qual' => $qual,
        ]);
    }
}

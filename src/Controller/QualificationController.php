<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QualificationController extends AbstractController
{
    /**
     * @Route("/qualification", name="qualification")
     */
    public function index()
    {
        return $this->render('qualification/index.html.twig');
    }
}

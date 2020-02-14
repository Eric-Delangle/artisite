<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {
         $message = new Message();
         $form = $this->createForm(MessageType::class, $message);
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             
             $manager->persist($message);
             $manager->flush();
             
             return $this->redirectToRoute('account_admin');
         }
         return $this->render('message/index.html.twig', [
             'form' => $form->createView()
         ]);
       
    }
}

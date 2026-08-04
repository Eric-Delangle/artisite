<?php

namespace App\Controller;

use App\Entity\Users;
use Cocur\Slugify\Slugify;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{

    #[Route('/registration', name: 'account_registration')]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new Users();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        
        /* captcha */
        /*
        $recaptcha = new ReCaptcha('');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
  
        if (!$resp->isSuccess()) {
         // $this->addFlash('N\'oubliez pas de cocher la case "Je ne suis pas un robot"');
        } else {
       */
        if($form->isSubmitted() && $form->isValid()) {

            $slugify = new Slugify();
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $slug = $slugify->slugify($user->getFirstName().''.$user->getLastName());
            $user->setSlug($slug);
            $user->setRegisteredAt(new \DateTime());
            $user->setNiveau(1);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre compte a bien été créé');
            return $this->redirectToRoute('account_login');
           
        }
        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
   
    #[Route('/login', name: 'account_login')]
    public function login()
    {
        return $this->render('account/login.html.twig');
    }

    #[Route('/logout', name: 'account_logout')]
    public function logout()
    {
        
    }

     #[Route('/admin', name: 'account_admin')]
     public function admin()
     {
         return $this->render('admin/index.html.twig');
     }
}
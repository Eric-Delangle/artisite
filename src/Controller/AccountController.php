<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\AccountType;
use Cocur\Slugify\Slugify;
use App\Entity\PassworUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use App\Repository\EstimationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AccountController extends AbstractController
{

   /**
     * Permet d'afficher le formulaire de création de compte
     * @Route("/registration", name="account_registration")
     * @return Response
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
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
            $hash = $encoder->encodePassword($user, $user->getPassword());
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
   
    /**
     * Permet d'afficher le formulaire de connexion
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login()
    {
        return $this->render('account/login.html.twig');
    }

    /**
     * Permet de se déconnecter
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {
        
    }

    /**
     * Permet de se connecter a l'interface d'administration
     * @Route("/admin", name="account_admin")
     * @return Response
     */
     public function admin(EstimationRepository $repo)
     {
         $devis = $repo->findAll();
         return $this->render('admin/index.html.twig', [
             'estimations' => $devis
         ]
        );
     }

    /**
     * Permet de se connecter a l'interface de modification du profil
     * @Route("/admin/profil", name="account_profil")
     * @return Response
     */
    public function profil(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
       // $user->getPassword();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $slugify = new Slugify();
            $slug = $slugify->slugify($user->getFirstName().''.$user->getLastName());
            $user->setSlug($slug);
           // $user->setPassword($session);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Vos informations ont bien été modifiées.');
            return $this->redirectToRoute('account_admin');
        }
        return $this->render('account/profil.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de changer le mot de passe utilisateur
     * @Route("/admin/password-update", name="account_password")
     * @return Response
     */
    public function updatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PassworUpdate();
        $user = $this->getUser();
        
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
           if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
            $this->addFlash('danger', 'Veuillez entrer le bon mot de passe.');
           } else {
               $newPassword = $passwordUpdate->getNewPassword();
               $hash = $encoder->encodePassword($user, $newPassword);
               $user->setPassword($hash);
               $manager->persist($user);
               $manager->flush();
               $this->addFlash('success', 'Votre mot de passe a bien été modifié.');
               return $this->redirectToRoute('account_admin');
           }
            
           
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}


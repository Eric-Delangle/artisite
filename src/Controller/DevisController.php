<?php

namespace App\Controller;

use App\Entity\Estimation;
use App\Form\EstimationType;
use App\Repository\EstimationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevisController extends AbstractController
{
    /**
     * @Route("/devis", name="devis")
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {
        $devis = new Estimation();
        $form = $this->createForm(EstimationType::class, $devis);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($devis);
            $manager->flush();
            $this->addFlash('success', 'Votre demande de devis a bien été envoyée, nous vous répondrons au plus vite.');
            return $this->redirectToRoute('home');
           
        }
        
        return $this->render('devis/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/devis/{id}", name="devis_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Estimation $estimation)
    {
        if ($this->isCsrfTokenValid('delete'.$estimation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($estimation);
            $entityManager->flush();
            $this->addFlash('success', 'Le devis a bien été supprimé.');
        }

        return $this->redirectToRoute('home');
    }
}

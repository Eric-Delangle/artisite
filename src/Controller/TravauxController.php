<?php

namespace App\Controller;

use App\Entity\Travaux;
use App\Form\TravauxType;
use App\Repository\TravauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/travaux")
 */
class TravauxController extends AbstractController
{
    /**
     * @Route("/admin", name="travaux_index", methods={"GET"})
     */
    public function index(TravauxRepository $travauxRepository): Response
    {
        return $this->render('admin/travaux/index.html.twig', [
            'travaux' => $travauxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="travaux_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $travaux = new Travaux();
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($travaux);
            $entityManager->flush();

            return $this->redirectToRoute('travaux_index');
        }

        return $this->render('travaux/new.html.twig', [
            'travaux' => $travaux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="travaux_show", methods={"GET"})
     */
    public function show(Travaux $travaux): Response
    {
        return $this->render('travaux/show.html.twig', [
            'travaux' => $travaux,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="travaux_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Travaux $travaux): Response
    {
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('travaux_index');
        }

        return $this->render('travaux/edit.html.twig', [
            'travaux' => $travaux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="travaux_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Travaux $travaux): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travaux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($travaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('travaux_index');
    }
}

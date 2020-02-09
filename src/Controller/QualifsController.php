<?php

namespace App\Controller;

use App\Entity\Qualifs;
use App\Form\QualifsType;
use App\Repository\QualifsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/qualifs")
 */
class QualifsController extends AbstractController
{
    /**
     * @Route("/admin", name="qualifs_index", methods={"GET"})
     */
    public function index(QualifsRepository $qualifsRepository): Response
    {
        return $this->render('admin/qualifs/index.html.twig', [
            'qualifs' => $qualifsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="qualifs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $qualif = new Qualifs();
        $form = $this->createForm(QualifsType::class, $qualif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($qualif);
            $entityManager->flush();

            return $this->redirectToRoute('qualifs_index');
        }

        return $this->render('admin/qualifs/new.html.twig', [
            'qualif' => $qualif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="qualifs_show", methods={"GET"})
     */
    public function show(Qualifs $qualif): Response
    {
        return $this->render('qualifs/show.html.twig', [
            'qualif' => $qualif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="qualifs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Qualifs $qualif): Response
    {
        $form = $this->createForm(QualifsType::class, $qualif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('qualifs_index');
        }

        return $this->render('qualifs/edit.html.twig', [
            'qualif' => $qualif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="qualifs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Qualifs $qualif): Response
    {
        if ($this->isCsrfTokenValid('delete'.$qualif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($qualif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('qualifs_index');
    }
}

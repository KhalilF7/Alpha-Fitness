<?php

namespace App\Controller;

use App\Entity\Produit1;
use App\Form\Produit1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit1")
 */
class Produit1Controller extends AbstractController
{
    /**
     * @Route("/", name="produit1_index", methods={"GET"})
     */
    public function index(): Response
    {
        $produit1s = $this->getDoctrine()
            ->getRepository(Produit1::class)
            ->findAll();

        return $this->render('produit1/index.html.twig', [
            'produit1s' => $produit1s,
        ]);
    }

    /**
     * @Route("/new", name="produit1_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit1 = new Produit1();
        $form = $this->createForm(Produit1Type::class, $produit1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit1);
            $entityManager->flush();

            return $this->redirectToRoute('produit1_index');
        }

        return $this->render('produit1/new.html.twig', [
            'produit1' => $produit1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit1_show", methods={"GET"})
     */
    public function show(Produit1 $produit1): Response
    {
        return $this->render('produit1/show.html.twig', [
            'produit1' => $produit1,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit1_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit1 $produit1): Response
    {
        $form = $this->createForm(Produit1Type::class, $produit1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit1_index');
        }

        return $this->render('produit1/edit.html.twig', [
            'produit1' => $produit1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit1_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit1 $produit1): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit1->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit1_index');
    }
}

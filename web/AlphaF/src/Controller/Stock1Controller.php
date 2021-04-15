<?php

namespace App\Controller;

use App\Entity\Stock1;
use App\Form\Stock1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stock1")
 */
class Stock1Controller extends AbstractController
{
    /**
     * @Route("/", name="stock1_index", methods={"GET"})
     */
    public function index(): Response
    {
        $stock1s = $this->getDoctrine()
            ->getRepository(Stock1::class)
            ->findAll();

        return $this->render('stock1/index.html.twig', [
            'stock1s' => $stock1s,
        ]);
    }

    /**
     * @Route("/new", name="stock1_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stock1 = new Stock1();
        $form = $this->createForm(Stock1Type::class, $stock1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stock1);
            $entityManager->flush();

            return $this->redirectToRoute('stock1_index');
        }

        return $this->render('stock1/new.html.twig', [
            'stock1' => $stock1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock1_show", methods={"GET"})
     */
    public function show(Stock1 $stock1): Response
    {
        return $this->render('stock1/show.html.twig', [
            'stock1' => $stock1,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stock1_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Stock1 $stock1): Response
    {
        $form = $this->createForm(Stock1Type::class, $stock1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock1_index');
        }

        return $this->render('stock1/edit.html.twig', [
            'stock1' => $stock1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock1_delete", methods={"POST"})
     */
    public function delete(Request $request, Stock1 $stock1): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stock1->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stock1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock1_index');
    }
}

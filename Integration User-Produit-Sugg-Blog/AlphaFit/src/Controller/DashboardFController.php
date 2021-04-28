<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardFController extends AbstractController
{
    /**
     * @Route("/dashboard/f", name="dashboard_f")
     */
    public function index(): Response
    {

        $produits = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findAll();
        $stocks = $this->getDoctrine()
            ->getRepository(Stock::class)
            ->findAll();
        return $this->render('dashboard_f/index.html.twig', [
            'produits' => $produits,
            'stocks' => $stocks,
        ]);
    }
    /**
     * @Route("/produitf", name="produitf")
     */
    public function produit(): Response
    {

        $produits = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findAll();
        $stocks = $this->getDoctrine()
            ->getRepository(Stock::class)
            ->findAll();
        return $this->render('dashboard_f/produitf.html.twig', [
            'produits' => $produits,
            'stocks' => $stocks,
        ]);
    }
    /**
     * @Route("/produitf/{id}", name="details", methods={"GET"})
     */
    public function show(Stock $stock): Response
    {
        $stocks = $this->getDoctrine()
            ->getRepository(Stock::class)
            ->findAll();
        return $this->render('dashboard_f/detailsproduit.html.twig', [
            'stock' => $stock,
            'stocks' => $stocks,
        ]);
    }
}

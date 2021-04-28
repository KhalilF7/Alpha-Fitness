<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findAll();
        $stocks = $this->getDoctrine()
            ->getRepository(Stock::class)
            ->findAll();
        return $this->render('dashboard/index.html.twig', [
            'produits' => $produits,
            'stocks' => $stocks,
        ]);
    }
    /**
     * @Route("/categorie", name="categorie")
     */
    public function categorie(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    /**
     * @Route("/produit", name="produit")
     */
    public function produit(): Response
    {
        $produit1s = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produit1s,
        ]);
    }
    /**
     * @Route("/stock", name="stock")
     */
    public function stock(): Response
    {
        $stocks = $this->getDoctrine()
            ->getRepository(Stock::class)
            ->findAll();

        return $this->render('stock/index.html.twig', [
            'stocks' => $stocks,
        ]);
    }

    /**
     * @Route("/stat", name="stat")
     */
    public function stat(): Response
    {
        return $this->render('stat/index.html.twig', [
            'controller_name' => 'StatController',
        ]);
    }


    /**
     * @Route("/listp", name="listp", methods={"GET"})
     */
    public function listp(): Response
    {
        $stocks = $this->getDoctrine()
            ->getRepository(Stock::class)
            ->findAll();

        return $this->render('stock/listproduits.html.twig', [
            'stocks' => $stocks,
        ]);
    }
}

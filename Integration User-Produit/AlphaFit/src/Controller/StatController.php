<?php

namespace App\Controller;

use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    /**
     * @Route("/stat", name="stat")
     */
    public function index(): Response
    {

        $stocks = $this->getDoctrine()
            ->getRepository(Stock::class)
            ->findAll();
        return $this->render('stat/index.html.twig', [
            'stocks' => $stocks,
        ]);
    }
}

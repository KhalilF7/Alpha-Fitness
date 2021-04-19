<?php

namespace App\Controller;

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
        return $this->render('dashboard_f/index.html.twig', [
            'controller_name' => 'DashboardFController',
        ]);
    }
}

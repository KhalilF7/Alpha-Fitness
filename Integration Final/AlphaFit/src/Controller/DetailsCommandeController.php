<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailsCommande;
use App\Form\DetailsCommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/details/commande")
 */
class DetailsCommandeController extends AbstractController
{
    /**
     * @Route("/", name="details_commande_index", methods={"GET"})
     */
    public function index(): Response
    {
        $detailsCommandes = $this->getDoctrine()
            ->getRepository(DetailsCommande::class)
            ->findAll();
        $commandes = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('details_commande/index.html.twig', [
            'details_commandes' => $detailsCommandes,
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new", name="details_commande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailsCommande = new DetailsCommande();
        $form = $this->createForm(DetailsCommandeType::class, $detailsCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailsCommande);
            $entityManager->flush();

            return $this->redirectToRoute('details_commande_index');
        }

        return $this->render('details_commande/new.html.twig', [
            'details_commande' => $detailsCommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcommande}", name="details_commande_show", methods={"GET"})
     */
    public function show(DetailsCommande $detailsCommande): Response
    {
        return $this->render('details_commande/show.html.twig', [
            'details_commande' => $detailsCommande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="details_commande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailsCommande $detailsCommande): Response
    {
        $form = $this->createForm(DetailsCommandeType::class, $detailsCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('details_commande_index');
        }

        return $this->render('details_commande/edit.html.twig', [
            'details_commande' => $detailsCommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="details_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, DetailsCommande $detailsCommande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailsCommande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailsCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('details_commande_index');
    }
}

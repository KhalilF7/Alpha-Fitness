<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Stock;
use App\Form\CommandeType;
use App\Entity\DetailsCommande;
use App\Form\DetailsCommandeType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     */
    public function index(): Response
    {
        $commandes = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/listec", name="commande_listec", requirements={"idcommande":"\d+"} , methods={"GET"})
     */
    public function listp(): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $commandes = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commande/listec.html.twig', [
            'commandes' => $commandes,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("My.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/new", name="commande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commande = new Commande();
        $detailscommande = new DetailsCommande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        $f = $this->createForm(DetailsCommandeType::class, $detailscommande);
        $f->handleRequest($request);

        if ($form->isSubmitted() || $f->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
            'detailscommande' => $detailscommande,
            'f' => $f->createView(),
        ]);
    }



    /**
     * @Route("/{idcommande}/edit", name="commande_edit", methods={"GET","POST"})
     * ParamConverter("idcommande", class="Commande", options={"idcommande": "idcommande"})
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/termine/{idcommande}",name="terminée")
     */
    public function valider(int $idcommande)
    {
        $commande = new Commande();
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($idcommande);
        $commande->setEtatcom("Terminée");

        $em->flush();
        $this->addFlash('success', "Etat modifié!");
        return $this->redirectToRoute('commande_index');
    }
    /**
     * @Route("/encours/{idcommande}",name="enCours")
     */
    public function valider1(int $idcommande)
    {
        $commande = new Commande();
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($idcommande);
        $commande->setEtatcom("En cours");

        $em->flush();
        $this->addFlash('success', "Etat modifié!");
        return $this->redirectToRoute('commande_index');
    }
    /**
     * @Route("/annule/{idcommande}",name="annulée")
     */
    public function valider2(int $idcommande)
    {
        $commande = new Commande();
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($idcommande);
        $commande->setEtatcom("Annulée");

        $em->flush();
        $this->addFlash('success', "Etat modifié!");
        return $this->redirectToRoute('commande_index');
    }
    /**
     * @Route("/ajout",name="ajoutcf", methods={"GET","POST"})
     */
    public function Ajoutcf(Request $request, Security $security)
    {
        $commande = new Commande();
        $entityManager = $this->getDoctrine()->getManager();
        $commande->setEtatcom("En cours");
        $commande->setDatecom(\DateTime::createFromFormat('Y-m-d H:i:s','2021-04-29 12:12:12'));

        $montant = $request->request->get('montantcom');
        $user=$security->getUser();
        $commande->setMontantcom($montant);
        $commande->setIdclient($user);

        $entityManager->persist($commande);
        $entityManager->flush();
        $this->addFlash('success', "Commande effectuée!");

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
     * @Route("/{idcommande}", name="commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdcommande(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index');
    }



}

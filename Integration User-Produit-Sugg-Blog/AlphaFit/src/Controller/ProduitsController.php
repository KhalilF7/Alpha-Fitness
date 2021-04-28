<?php

namespace App\Controller;

use App\Entity\Produits;

use App\Entity\Suggestions;
use App\Entity\User;
use App\Form\ProduitsType;
use App\Repository\SuggestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produits")
 */
class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits_index", methods={"GET"})
     */
    public function index(): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();

        return $this->render('produits/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/new", name="produits_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produits();
        $produit->setParticipantId(52);
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['imgproduit']->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);

            $produit->setImgproduit('upload/'.$fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('suggestion');
        }

        return $this->render('produits/new.html.twig', [
            'produits' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produits_show", methods={"GET"})
     */
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produits' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edits", name="produits_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produits $produit): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['imgproduit']->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);

            $produit->setImgproduit('upload/'.$fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suggestion');
        }

        return $this->render('produits/edit.html.twig', [
            'produits' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/produits_delete", name="produits_delete", methods={"POST"})
     */
    public function delete(Request $request, Produits $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggestion');
    }
    /**
     * @Route("/{id}/produit_deleteb", name="produit_deleteb", methods={"POST"})
     */
    public function deletep(Request $request, Produits $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggestionBack');
    }
    /**
     * @Route("/add", name="add_likep", methods={"GET","POST"})
     */
    public function like(Request $request): Response
    {       $o=52;
        $user= $this->getDoctrine()->getRepository(User::class)->find($o);


        $id = $request->request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $blog = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->find($id);

        $blog->addLike($user);




        $entityManager->persist($blog);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('suggestion'
        );
    }
    /**
     * @Route("/remove", name="remove_likep", methods={"GET","POST"})
     */
    public function remove(Request $request,SuggestionsRepository $SuggestionsRepository): Response
    {

        $o=52;
        $user= $this->getDoctrine()->getRepository(User::class)->find($o);

        $id = $request->request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $blog = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->find($id);
        $blog->removeLike($user);

        $entityManager->persist($blog);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('suggestion');

    }
}

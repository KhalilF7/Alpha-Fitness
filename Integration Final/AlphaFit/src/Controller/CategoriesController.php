<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index(): Response
    {
        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
        ]);
    }
    /**
     * @Route("/categories/add_categorie", name="add_categorie")
     */
    public function addCategorie (Request $request): Response
    {
        $categorie = new Categories();
        $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($categorie);

            $entityManager->flush();

            return $this->redirectToRoute('list_categorie');

        }

        return $this->render("categories/addcategorie.html.twig", [
            "form_title" => "Ajouter une categories",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/categories/listCategorie", name="list_categorie")
     */
    public function listCategorie(Request $request)
    {
        $categorie = $this->getDoctrine()->getRepository(Categories::class)->findAll();

        return $this->render('categories/showcategorie.html.twig', [
            "categorie" => $categorie ,
        ]);

    }
    /**
     * @Route("/categories/edit_categorie/{idCategorie}", name="edit_categorie")
     */
    public function editcategorie(Request $request, $idCategorie): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $categorie = $entityManager->getRepository(Categories::class)->find($idCategorie);
        $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('list_categorie');
        }

        return $this->render("categories/editcategorie.html.twig", [
            "form_title" => "Modifier categories",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/categories/delete_categorie/{idCategorie}", name="delete_categorie")
     */
    public function deletecategorie(int $idCategorie): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categorie = $entityManager->getRepository(Categories::class)->find($idCategorie);
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('list_categorie');
    }
}

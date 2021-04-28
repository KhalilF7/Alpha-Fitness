<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\User;
use App\Form\Carte1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/carte")
 */
class CarteController extends AbstractController
{
    /**
     * @Route("/", name="carte_index", methods={"GET"})
     */
    public function index(): Response
    {
        $cartes = $this->getDoctrine()
            ->getRepository(Carte::class)
            ->findAll();

        return $this->render('carte/index.html.twig', [
            'cartes' => $cartes,
        ]);
    }

    /**
     * @Route("/new", name="carte_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carte = new Carte();
        $form = $this->createForm(Carte1Type::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imagecard')->getData();


            if ($image)
            {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $originalFilename;
                $fileName = $safeFilename.'.'.$image->guessExtension();
                try{
                    $image->move(
                        $this->getParameter('imageuser_directory'),$fileName);
                } catch (FileException $e)
                {
                }
                $carte->setImagecard($fileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carte);
            $entityManager->flush();

            return $this->redirectToRoute('carte_index');
        }

        return $this->render('carte/new.html.twig', [
            'carte' => $carte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcard}", name="carte_show", methods={"GET"})
     */
    public function show(Carte $carte): Response
    {
        return $this->render('carte/show.html.twig', [
            'carte' => $carte,
        ]);
    }

    /**
     * @Route("/{idcard}/edit", name="carte_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Carte $carte): Response
    {
        $form = $this->createForm(Carte1Type::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imagecard')->getData();


            if ($image)
            {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $originalFilename;
                $fileName = $safeFilename.'.'.$image->guessExtension();
                try{
                    $image->move(
                        $this->getParameter('imageuser_directory'),$fileName);
                } catch (FileException $e)
                {
                }
                $carte->setImagecard($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('carte_index');
        }

        return $this->render('carte/edit.html.twig', [
            'carte' => $carte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcard}", name="carte_delete", methods={"POST"})
     */
    public function delete(Request $request, Carte $carte): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carte->getIdcard(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('carte_index');
    }
}

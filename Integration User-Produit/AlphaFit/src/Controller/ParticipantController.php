<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\User;
use App\Form\UserType;
use App\Form\participantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/participant", name="participant")
     */
    public function index(): Response
    {
        $cartes = $this->getDoctrine()
            ->getRepository(Carte::class)
            ->findAll();
        return $this->render('participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
            'carte'=>$cartes
        ]);
    }

    /**
     * @Route("/{iduser}/edit", name="participant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imageuser')->getData();


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
                $user->setImageuser($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('participant/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/signup", name="user_signup", methods={"GET","POST"})
     */
    public function signUp(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(participantType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imageuser')->getData();


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
                $user->setImageuser($fileName);
                //testtt
            }

            $user->setOnline(0);
            $user->setRole("Participant");
            $user->setPasswordoublie(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('Security/signup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}

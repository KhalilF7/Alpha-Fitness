<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Posts;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/comments")
 */
class CommentsController extends AbstractController
{
    /**
     * @Route("/", name="comments_index", methods={"GET"})
     */
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/comments_new/{idp}", name="comments_new", methods={"GET","POST"})
     */
    public function new(Request $request,$idp,Security $security): Response
    {
        $comment = new Comments();


        $contenu = $request->request->get('contenu');
        $comment->setContenuc($contenu);


            $entityManager = $this->getDoctrine()->getManager();
            $repository=$this->getDoctrine()->getRepository(Posts::class);
            $user=$security->getUser();
            $post=$repository->find($idp);
       #Incrementation
        $comment->setIdCommenter($user);
            $post->setNbcmt($post->getNbcmt()+1);
            $comment->setDatec(new \DateTime());
            $comment->setPost($post);
             $entityManager->persist($post);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('posts_indexf');

    }

    /**
     * @Route("/{idc}", name="comments_show", methods={"GET"})
     */
    public function show(Comments $comment): Response
    {
        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{idc}/edit", name="comments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_index');
        }

        return $this->render('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idc}", name="comments_delete", methods={"POST"})
     */
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getIdc(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comments_index');
    }
}

<?php

namespace App\Controller;




use App\Entity\Blog;
use App\Entity\Produits;
use App\Entity\ProduitSearch;
use App\Entity\PropertySearch;
use App\Entity\Suggestions;
use App\Entity\User;
use App\Form\ProduitSearchType;
use App\Form\ProduitsType;
use App\Form\PropertySearchType;
use App\Form\SuggestionFormType;
use App\Repository\ReclamationRepository;
use App\Repository\SuggestionsRepository;
use App\Repository\ProduitsRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email ;
use Symfony\Component\Security\Core\Security;

class SuggestionController extends AbstractController
{
    /**
     * @Route("/suggestion", name="suggestion")
     */
    public function index(SuggestionsRepository $SuggestionsRepository, ProduitsRepository $ProduitRepository, Request $request): Response
    {

        $ProduitSearch = new ProduitSearch();
        $PropertySearch = new PropertySearch();
        $forms = $this->createForm(PropertySearchType ::class, $PropertySearch);
        $forms->handleRequest($request);
        $formp = $this->createForm(ProduitSearchType ::class, $ProduitSearch);
        $formp->handleRequest($request);
        $articles= [];
        $produits= [];
        if($forms->isSubmitted() && $forms->isValid()) {
            //on récupère le type de suggestion tapé dans le formulaire
            $des = $PropertySearch->getDes();
            $timestamp = $date1 = DateTime::createFromFormat('m-d-y', $des);
            if ($des!="")
                //si on a fourni un type on affiche tous les suggestions ayant ce nom
                $articles= $this->getDoctrine()->getRepository(Suggestions::class)->findBy(array('type' => $des),array('date' => 'ASC') );


        return $this->render('suggestions/indexAll.html.twig', [
            'sug' => $articles,
            'pr' => $ProduitRepository->findAll(),
            'forms' => $forms->createView(),
            'formp' => $formp->createView(),
        ]);}
        elseif ($formp->isSubmitted() && $formp->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $des = $ProduitSearch->getNom();

            if ($des!="")
                //si on a fourni un nom on affiche tous les produits ayant ce nom
                $articles= $this->getDoctrine()->getRepository(Produits::class)->findBy(['nom' => $des] );


            return $this->render('suggestions/indexAll.html.twig', [
                'sug' => $SuggestionsRepository->findAll(),
                'pr' => $articles,
                'forms' => $forms->createView(),
                'formp' => $formp->createView(),
            ]);}
    else
        return $this->render('suggestions/indexAll.html.twig', [
            'sug' => $SuggestionsRepository->findAll(),
            'pr' => $ProduitRepository->findAll(),
            'forms' => $forms->createView(),
            'formp' => $formp->createView(),
        ]);

    }

    /**
     * @Route("/Mysuggestion", name="Mysuggestion")
     */
    public function indexMy(SuggestionsRepository $SuggestionsRepository, ProduitsRepository $ProduitRepository, Request $request, Security $security): Response
    {
        $user=$security->getUser();

        $Suggestion= $SuggestionsRepository->findBy(['participantId' => $user]);
        $ProduitSearch = new ProduitSearch();
        $PropertySearch = new PropertySearch();
        $forms = $this->createForm(PropertySearchType ::class, $PropertySearch);
        $forms->handleRequest($request);
        $formp = $this->createForm(ProduitSearchType ::class, $ProduitSearch);
        $formp->handleRequest($request);
        $articles= [];
        $produits= [];
        if($forms->isSubmitted() && $forms->isValid()) {
            //on récupère le type de suggestion tapé dans le formulaire
            $des = $PropertySearch->getDes();

            if ($des!="")
                //si on a fourni un type on affiche tous les suggestions ayant ce nom
               $articles= $this->getDoctrine()->getRepository(Suggestions::class)->findBy(['participantId' => $user , 'type'=>$des]);


            return $this->render('suggestions/index.html.twig', [
                'sug' => $articles,
                'pr' => $ProduitRepository->findBy(['participantId' => $user]),
                'forms' => $forms->createView(),
                'formp' => $formp->createView(),

            ]);}
        elseif ($formp->isSubmitted() && $formp->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $des = $ProduitSearch->getNom();

            if ($des!="")
                //si on a fourni un nom on affiche tous les produits ayant ce nom
                $articles= $this->getDoctrine()->getRepository(Produits::class)->findBy(['participantId' => $user , 'nom'=>$des]);


            return $this->render('suggestions/index.html.twig', [
                'sug' => $SuggestionsRepository->findBy(['participantId' => $user]),
                'pr' => $articles,
                'forms' => $forms->createView(),
                'formp' => $formp->createView(),

            ]);}
        else
            return $this->render('suggestions/index.html.twig', [
                'sug' => $SuggestionsRepository->findBy(['participantId' => $user]),
                'pr' => $ProduitRepository->findBy(['participantId' => $user]),
                'forms' => $forms->createView(),
                'formp' => $formp->createView(),

            ]);

    }
    /**
     * @Route("/suggestionBack", name="suggestionBack")
     */
    public function indexb(ReclamationRepository $ReclamationRepository , SuggestionsRepository $SuggestionsRepository, ProduitsRepository $ProduitRepository): Response
    {
        return $this->render('suggestionsB/index.html.twig', [
            'sug' => $SuggestionsRepository->findAll(),
            'pr' => $ProduitRepository->findAll(),
            're' => $ReclamationRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}/edits", name="sugesstion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Suggestions $s): Response
    {

        $form = $this->createForm(SuggestionFormType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);

            $s->setImage('upload/'.$fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($s);
            $entityManager->flush();
            return $this->redirectToRoute('suggestion');
        }

        return $this->render('suggestions/edit.html.twig', [
            's' => $s,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/news", name="suggestion_new", methods={"GET","POST"})
     * @throws \Exception
     */
    public function new(Request $request,MailerInterface $mailer, Security $security): Response
    {
        $Suggestions = new Suggestions();
        $user=$security->getUser();
        $Suggestions->setParticipantId($user);
        $form = $this->createForm(SuggestionFormType::class, $Suggestions);
        $form->handleRequest($request);
        $date1 = $Suggestions->getDate() ;
        $date   = new DateTime();
        if ($form->isSubmitted() && $form->isValid() ) {

             $file = $form['image']->getData();

            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);

            $Suggestions->setImage('upload/'.$fileName );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Suggestions);
            $entityManager->flush();
            //send mail
            $email = (new Email())
                ->from('para.diseesprit@gmail.com')
                //->to((String)$user->getEmail())
                ->to('khalifa.sahli@esprit.tn')
                ->priority(Email::PRIORITY_HIGH)
                ->subject('[Paradise] Traitement d inscription !')
                //->text('Sending emails is fun again!')
                ->html('<p>Bonjour cher(e) Mr/Mme </p><br>
                   <p>il y a un nouveau suggestion ajouter sur notre site '.'</p><br>');
            $mailer->send($email);

            return $this->redirectToRoute('suggestion');
        }

        return $this->render('suggestions/new.html.twig', [
            'Suggestion' => $Suggestions,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/suggestion_delete", name="suggestion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Suggestions $s): Response
    {
        if ($this->isCsrfTokenValid('delete' . $s->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($s);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggestion');

    }
    /**
     * @Route("/{id}/suggestion_deleteb", name="suggestion_deleteb", methods={"DELETE"})
     */
    public function deleteb(Request $request, Suggestions $s): Response
    {
        if ($this->isCsrfTokenValid('delete' . $s->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($s);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggestionBack');

    }

    /**
     * @Route("/add", name="add_like", methods={"GET","POST"})
     */
    public function like(Request $request): Response
    {       $o=52;
        $user= $this->getDoctrine()->getRepository(User::class)->find($o);


        $id = $request->request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $blog = $this->getDoctrine()
            ->getRepository(Suggestions::class)
            ->find($id);

        $blog->addLike($user);
        $user->addLike($blog);



        $entityManager->persist($blog);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('suggestion'
        );
    }
    /**
     * @Route("/remove", name="remove_like", methods={"GET","POST"})
     */
    public function remove(Request $request,SuggestionsRepository $SuggestionsRepository): Response
    {

        $o=52;
        $user= $this->getDoctrine()->getRepository(User::class)->find($o);

        $id = $request->request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $blog = $this->getDoctrine()
            ->getRepository(Suggestions::class)
            ->find($id);
        $blog->removeLike($user);
        $user->removeLike($blog);
        $entityManager->persist($blog);
        $entityManager->persist($user);
        $entityManager->flush();
            return $this->redirectToRoute('suggestion');

    }
    /**
     * @Route("/triNomDesc_suggestions}", name="trinomdesc")
     */
    public function triNomDESC()
    {
        $sug = $this->getDoctrine()->getRepository(Suggestions::class)->findBy(array(),array('date' => 'DESC'));

        return $this->render('suggestions/tri.html.twig', [
            'sug' => $sug,

        ]);
    }
}


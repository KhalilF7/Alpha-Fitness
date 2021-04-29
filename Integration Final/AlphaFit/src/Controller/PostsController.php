<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\PostRating;
use App\Entity\Posts;
use App\Form\PostRatingType;
use App\Form\Posts1Type;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#/**
 #* @Route("/postsB")
 #*/
class PostsController extends AbstractController
{
    /**
     * @Route("/postsB", name="posts_index", methods={"GET"})
     */
    public function index(PostsRepository $postsRepository,Request $request, PaginatorInterface $paginator ): Response
    {
        $search =$request->query->get('recherche');
        $en = $this->getDoctrine()->getManager();
        $posts=$en->getRepository(Posts::class)->findMulti($search);
        $post=$paginator->paginate($posts, $request->query->getInt('page', 1),1);
        return $this->render('posts/index.html.twig',array(
            'posts' => $post
        ));
    }
    /**
     * @Route("/postsF", name="posts_indexf", methods={"GET"})
     */
    public function indexf(PostsRepository $postsRepository): Response
    {
        return $this->render('postsF/index.html.twig', [
            'posts' => $postsRepository->findAll(),
        ]);
    }
    //*****************Trending***************************//
    /**
     * @Route("/postsFdescending", name="posts_indexfdescending", methods={"GET"})
     */
    public function indexfdescending(PostsRepository $postsRepository): Response
    {
        return $this->render('postsF/index.html.twig', [
            'posts' => $postsRepository->findBy(
                array(),
                array('views' => 'DESC')
            ),
        ]);
    }

//*****************RechercheAvancé***************************//
    /**
     * @Route("/postsBsearching", name="posts_indexbsearching", methods={"GET"})
     */
    public function AfficherAction(Request $request) : Response
    {
        $search =$request->query->get('recherche');
        $en = $this->getDoctrine()->getManager();
        $post=$en->getRepository(Posts::class)->findMulti($search);
        return $this->render('posts/index.html.twig',array(
            'posts' => $post
        ));
    }





    /**
     * @Route("/newp", name="posts_new")
     */
    public function new(Request $request,Security $security): Response
    {
        $post = new Posts();
        $form = $this->createForm(Posts1Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['imgpost']->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);

            $post->setImgpost('Images/'.$fileName);
            $user=$security->getUser();
            $post->setIdPoster($user);

            $date= new \DateTime();
            $post->setDateP($date);
            $post->setReport(0);
            $post->setNbcmt(0);
            $post->setViews(0);
            $post->setLikes(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('posts_indexf');
        }

        return $this->render('postsF/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{idp}", name="posts_show")
     */
    public function show(PostsRepository $repository,Posts $post,$idp): Response
    {
        $repository=$this->getDoctrine()->getRepository(Posts::class);

        $post=$repository->find($idp);
        return $this->render('posts/show.html.twig', [
            'post' => $post,
        ]);
    }


    /**
     * @Route("/show1/{id}", name="posts_show1")
     */
    public function show1(PostsRepository $repository,Posts $post,$id,Security $security,Request $request): Response
    {
        $em= $this->getDoctrine()->getManager();


        $repository=$this->getDoctrine()->getRepository(Posts::class);

        $post=$repository->find($id);
        $rates = $em->getRepository(PostRating::class)->findBy(array('post'=>$post));
        $avis = 0;
        if(count($rates) > 0){
            foreach ($rates as $r){
                $avis += $r->getRating();
            }
            $avis = $avis/ count($rates);
        }
        if( $security->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $security->getUser();
            $PostRating = $em->getRepository(PostRating::class)->findOneBy(array('user'=>$user,'post'=>$post));
            if(empty($PostRating)){
                $PostRating = new PostRating();
            }
            $form = $this->createForm(PostRatingType::class, $PostRating);
            $form->handleRequest($request);
            if($request->isMethod('POST')){
                $PostRating->setUser($user);
                $PostRating->setPost($post);
                $em->persist($PostRating);
                $em->flush();

            }
        }else{
            $PostRating = new PostRating();
            $form = $this->createForm(PostRatingType::class, $PostRating);
            $form->handleRequest($request);
            if($request->isMethod('POST')){
                return $this->redirectToRoute('app_login');
            }
        }
#Incrémantation
        $post->setViews($post->getViews()+1);
        $repository1=$this->getDoctrine()->getRepository(Comments::class);
        $comments= $repository1->findBy(['post'=>$post]);
        $this->getDoctrine()->getManager()->persist($post);
        $this->getDoctrine()->getManager()->flush();
        return $this->render('postsF/show.html.twig', [
            'post' => $post,
            'comments'=>$comments,
            'form' => $form->createView(),
            'avis'=>$avis,
        ]);
    }




    /**
     * @Route("/{id}/edit", name="posts_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_indexf');
        }

        return $this->render('postsF/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="posts_delete")
     */
    public function delete(Request $request, Posts $post,$id): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $post=$entityManager->getRepository(Posts::class)->find($id);
            $entityManager->remove($post);
            $entityManager->flush();


        return $this->redirectToRoute('posts_index');
    }
    /**
     * @Route("/delete1/{id}", name="posts_delete1")
     */
    public function delete1(Request $request, Posts $post,$id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $post=$entityManager->getRepository(Posts::class)->find($id);
        $entityManager->remove($post);
        $entityManager->flush();


        return $this->redirectToRoute('posts_indexf');
    }






    // *****************************      LIKES      ****************************************

    public  function like (Request $rq,$id){
        $like =new Likes();

        $posts = $this->getDoctrine()->getRepository(Posts::class)->find($id);
        $checkk = $this->getDoctrine()->getRepository(Likes::class)->check($id->getId());
        $em=$this->getDoctrine()->getManager();
        //    $likes=$em->getRepository(Likes::class)->find($id);

        if (empty($checkk)) {
            $like->setIdp($id);

            $posts->setLikes($posts->getLikes() + 1);
            $em->persist($like);
            $em->flush();

        } else {
            // $this->deleteLikespAction($rq, $like->setIdp());


            $like = $this->getDoctrine()->getRepository(Likes::class)->findOneBy(['idl'=>$checkk[0]]);
            $em->remove($like);

            $posts->setLikes($posts->getLikes() - 1);
            $em->flush();
        }


        return $this->redirectToRoute('posts_index');

    }
    public function deletelike (Request $rq,$id)
    {
        $ref = $rq->headers->get('referer');

        $em = $this->getDoctrine()->getManager();
        $like = $this->getDoctrine()->getRepository(Likes::class)->find($id);
        $em->remove($like);
        $em->flush();
        return $this->redirect($ref);

    }









    /**
     * @Route("/forum", name="forum_index_front_Search")
     */

    public function rechercheByniveauAction( Request $request,PostsRepository $repo){
        $em=$this->getDoctrine()->getManager();
        $forum=$em->getRepository(Posts::class)->findAll();
        if($request->isMethod("POST")) {
            $user=$request->get('user');
            $forum=$em->getRepository(Posts::class)->findBy(array('user'=>user),array('user'=>'ASC'));
        }

        return $this->render('postsF/index.html.twig',
            array('forum'=>$forum) );
        ;}







    /**
     * @return Response
     * @Route ("/stat", name="stat")
     */

    public function statistiques(){

        $pieChart= new PieChart();
        $posts= $this->getDoctrine()->getManager()->getRepository(Posts::class)->findAll();
        $p1=[];
        $p2=[];
        foreach ($posts as $p)
        {
            if($p->getViews()>10 || $p->getViews()==10) {
                $p1 [] = $p;
            }
        }
        foreach ($posts as $p)
        {
            if($p->getViews()<10) {
                $p2 [] = $p;
            }
        }

        $count1= count($p1);
        $count2=count($p2);

        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['posts >10',     $count1],
                ['posts <10',      $count2]

            ]
        );
        $pieChart->getOptions()->setTitle('My stats');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('posts/stat.html.twig', array('piechart' => $pieChart));
    }







}

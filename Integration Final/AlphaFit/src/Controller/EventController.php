<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EventType;
use App\Form\CategoriesType;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/event/add_event", name="add_event")
     */
    public function addEvent(Request $request ): Response
    {
        $Event = new Event();
        $form = $this->createForm(EventType::class,$Event);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Event);

            $basic  = new \Vonage\Client\Credentials\Basic("cf8ff5a8", "Mz7HeLP4aBhqJOH8");
            $client = new \Vonage\Client($basic);

            $message = $client->message()->send([
                'to' => '21625602056',
                'from' => 'Vonage APIs',
                'text' => 'un nouvel evenementt vient d etre ajouter  effectué avec success'
            ]);

            $entityManager->flush();

            return $this->redirectToRoute('list_event');

        }

        return $this->render("event/addevent.html.twig", [
            "form_title" => "Ajouter un event",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/event/listevent", name="list_event")
     */
    public function listEvent(Request $request, PaginatorInterface $paginator)
    {
        $event= $this->getDoctrine()->getRepository(Event::class)->findAll();

        $pagination = $paginator->paginate(
            $event,
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('event/showevent.html.twig', [
            "event" => $pagination,
        ]);

    }
    /**
     * @Route("/event/delete_event/{idEvent}", name="delete_event")
     */
    public function deleteEvent(int $idEvent): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)->find($idEvent);
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('list_event');
    }
    /**
     * @Route("/event/edit_event/{idEvent}", name="edit_event")
     */
    public function editEvent(Request $request, int $idEvent): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $event = $entityManager->getRepository(Event::class)->find($idEvent);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('list_event');
        }

        return $this->render("event/editevent.html.twig", [
            "form_title" => "Modifier un event",
            "form" => $form->createView(),
        ]);
    }

    /**
     *@Route("/searchajax", name="ajaxsearch")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $event = $em->getRepository(Event::class)->findEntitiesByString($requestString);

        if(!$event)
        {
            $result['event']['error']="event introuvable 😞 ";

        }else{
            $result['event']=$this->getRealEntities($event);
        }
        return new Response(json_encode($result));

    }
    public function getRealEntities($event){
        foreach ($event as $event){
            $realEntities[$event->getIdEvent()] = [$event->getNomevenement()];

        }
        return $realEntities;
    }

    /**
     * @Route("/event/listeventf", name="list_eventf")
     */
    public function listEventf(Request $request, PaginatorInterface $paginator)
    {
        $event= $this->getDoctrine()->getRepository(Event::class)->findAll();

        $pagination = $paginator->paginate(
            $event,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('event/showeventfront.html.twig', [
            "event" => $pagination,
        ]);

    }
}

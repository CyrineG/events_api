<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractFOSRestController
{
    private $eventRepository;
    private $em;

    public function __construct(EventRepository $eventRepository, EntityManagerInterface $entityManagerInterface){
        $this->eventRepository = $eventRepository;
        $this->em = $entityManagerInterface;
    }

    /**
     * @RequestParam(name="event_name", nullable=false, strict=true)
     * @RequestParam(name="start_date", nullable=false, strict=true)
     * @RequestParam(name="end_date", nullable=false, strict=true)
     * @RequestParam(name="heure_deb", nullable=false, strict=true)
     * @RequestParam(name="heure_fin", nullable=false, strict=true)
     * @RequestParam(name="place", nullable=false, strict=true)
     * @RequestParam(name="description", nullable=false, strict=true)
     *@param ParamFetcher $paramFetcher
     */
    public function postEventsAction(ParamFetcher $paramFetcher){
        
        $data = $paramFetcher->all();
        
        if($data){
            $event = new Event();
            $event->setEventName($data['event_name']);

        $start = $data['start_date'];
            $end = $data['end_date'];
            $heure_deb = $data['heure_deb'];
            $heure_fin = $data['heure_fin'];
        

            $event->setStartDate(new DateTime($start.' '.$heure_deb) );
            $event->setEndDate(new DateTime($end.' '.$heure_fin) );

            $event->setPlace($data['place']);
            $event->setDescription($data['description']);

            //instantiate the entity manager
            $em = $this->getDoctrine()->getManager();
            //save post to database
            $em->persist($event);
            $em->flush();
            return $this->json($data,Response::HTTP_CREATED);
        }

        return $this->json($data,Response::HTTP_BAD_REQUEST);
    }

    public function getEventsAction(){
        $data= $this->eventRepository->findAll();
        return $this->json(Response::HTTP_OK);
    }

 
    public function getEventAction(int $id){
        $data = $this->eventRepository->findOneBy(["id"=> $id]);
        return $this->json($data);
        //$data= $this->eventRepository->find($id);
        //return $this->json($data,Response::HTTP_OK);
    }

    /**
     * @RequestParam(name="event_name", nullable=false, strict=true)
     * @RequestParam(name="start_date", nullable=false, strict=true)
     * @RequestParam(name="end_date", nullable=false, strict=true)
     * @RequestParam(name="heure_deb", nullable=false, strict=true)
     * @RequestParam(name="heure_fin", nullable=false, strict=true)
     * @RequestParam(name="place", nullable=false, strict=true)
     * @RequestParam(name="description", nullable=false, strict=true)
     *@param ParamFetcher $paramFetcher
     */
    public function putEventAction(int $id, ParamFetcher $paramFetcher){
        $event = $this->eventRepository->findOneBy(["id"=> $id]);
        
        if (!$event) {
            throw $this->createNotFoundException(
                'No event found for id '.$id
            );
        }

        $data = $paramFetcher->all();
        $event->setEventName($data['event_name']);

       $start = $data['start_date'];
        $end = $data['end_date'];
        $heure_deb = $data['heure_deb'];
        $heure_fin = $data['heure_fin'];

        $event->setStartDate(new DateTime($start.' '.$heure_deb) );
        $event->setEndDate(new DateTime($end.' '.$heure_fin) );

        $event->setPlace($data['place']);
        $event->setDescription($data['description']);

        $this->em->flush();
        return $this->json([
            'hello'=> 'it worked'
        ]);
    }

    public function deleteEventAction(int $id){
        $event = $this->eventRepository->findOneBy(["id"=> $id]);    
        if (!$event) {
            throw $this->createNotFoundException(
                'No event found for id '.$id
            );
        }
        $this->em->remove($event);
        $this->em->flush();
        return $this->json([
            'hello'=> 'it worked'
        ]);
    }
}

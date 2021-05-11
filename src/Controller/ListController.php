<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\Response;


class ListController extends AbstractFOSRestController
{
    public function getListsAction($id){
        return $this->json([
            'hello'=> 'it worked'
        ]);
    }

    public function getListsTasksAction($id){
        return $this->json([
            'hello'=> 'it worked'
        ]);
    }

    public function putListsAction(){
        return $this->json([
            'hello'=> 'it worked'
        ]);
    }

    public function stateListsAction($id){
        return $this->json([
            'hello'=> 'it worked'
        ]);
    }
}

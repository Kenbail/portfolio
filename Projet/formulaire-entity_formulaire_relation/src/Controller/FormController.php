<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\QuestionsRepository;
use App\Repository\ReponsesRepository;
use App\Entity\Questions;
use App\Entity\Reponses;
use Doctrine\ORM\EntityManagerInterface;

class FormController extends AbstractController
{
    #[Route('/form', name: 'app_form',methods: ['GET','POST'])]
    public function index(QuestionsRepository $questionsRepository,ReponsesRepository $reponsesRepository,Request $request): Response
    {    
        
        //chercher la page dans l'url
        $page = $request->query->getInt('page',1);
        $pages = $request->query->getInt('pages',6);
        $questions = $questionsRepository->findquestionsPaginer($page,4);
        // console.log('toto');
        //dd($questions);
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
            'questions' => $questionsRepository -> findAll(),
            'reponses' => $reponsesRepository -> findAll(),
            "questions"=> $questions,
            "pageact" => $page,
            "pages" => $pages
            //'reponses' => $reponsesRepository -> findBy(),
        ]);
    }
}

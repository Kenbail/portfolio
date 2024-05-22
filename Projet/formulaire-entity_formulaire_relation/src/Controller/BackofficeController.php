<?php

namespace App\Controller;

use App\Repository\QuestionsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Questions;


class BackofficeController extends AbstractController
{
    #[Route('/backoffice', name: 'app_backoffice', /*methods: ['GET']*/)]
    public function index(UsersRepository $usersRepository): Response {
   
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
            'users'=> $usersRepository -> findAll(),
        ]);
    }



    #[Route('/backoffice/projet', name: 'app_backoffice_project', methods: ['GET'])]
    public function showQuestions(QuestionsRepository $questionsRepository): Response{

        //dd($questionsRepository);

        return $this->render('backoffice/backproject.html.twig', [
            'controller_name' => 'BackofficeController',
            'questions' => $questionsRepository -> findAll(),
        ]);
    }
}

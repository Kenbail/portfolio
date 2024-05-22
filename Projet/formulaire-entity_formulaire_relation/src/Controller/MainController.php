<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserReponse;
use App\Form\BesoinType;
use App\Repository\ReponsesRepository;
use App\Repository\QuestionsRepository;
use App\Entity\Reponses;
use App\Form\QuestionsType;



class MainController extends AbstractController
{
    #[Route('/questionlist', name: 'app_questionlist',methods: ['GET','POST'])]
    public function addReponses(Reponses $reponses, EntityManagerInterface $entityManager, Request $request, ReponsesRepository $reponsesRepository, QuestionsRepository $questionsRepository):Response
    {

        
       // $session ->get('reponse') ;

        $userReponse = new UserReponse();
        $form = $this->createForm(QuestionsType::class, $userReponse);
        $form -> handleRequest($request);
        

        

        if ($form->isSubmitted() && $form->isValid()) {

            $reponseValue = $form->get('reponse_user')->getData();
            //dump($reponseValue);
            $userReponse->setReponseUser($reponseValue); 

            //$userReponse -> setReponseUser('TOutou'); 

            //$entityManager = $this->getDoctrine()->getManager();


            $session = $request -> getSession();
            //$session ->get('reponse') ;
            $session -> set('reponse', );
            dump($session);

            $entityManager -> persist($userReponse);
            $entityManager -> flush();
            
            return new Response ('reponse ajoutée redirect route à faire');
        } 

    
            
        //session v v v v v v v v v v
        
        //$session = $request -> getSession();
        //$session ->get('reponse') ;


        return $this->render('questionlist.html.twig', [ 
            'controller_name'=> 'MainController',
            'form' => $form->createView(),
            'reponses' => $reponsesRepository -> findAll(),
            'questions' => $questionsRepository -> findAll(),
            //array('form'=>$formView)

        ]);
        }
    }    
//}

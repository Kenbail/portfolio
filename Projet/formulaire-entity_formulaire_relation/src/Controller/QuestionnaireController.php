<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnaireController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_questionnaire')]
    public function index(): Response
    {
        // Affiche la page index.html.twig par défaut
        return $this->render('questionnaire/index.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'prevIndex' => null,  // Il n'y a pas de page précédente pour la première page
            'nextIndex' => 2,     // La page suivante est la page 2
        ]);
    }

    #[Route('/questionnaire/page_{index}', name: 'app_page')]
    public function showPage(Request $request, $index): Response
    {
        // Déterminer le nombre total de pages (6 dans cet exemple)
        $totalPages = 6;

        // Vérifier si l'index est valide
        if ($index < 1 || $index > $totalPages) {
            throw $this->createNotFoundException('Page not found');
        }

        // Préparer les index pour les boutons Suivant et Précédent
        $prevIndex = ($index > 1) ? $index - 1 : null;
        $nextIndex = ($index < $totalPages) ? $index + 1 : null;

        // Générer le nom du template à afficher
        $page = "page_".$index;

        return $this->render('questionnaire/' . $page . '.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'prevIndex' => $prevIndex,
            'nextIndex' => $nextIndex,
        ]);
    }   

    #[Route('/questionnaire_test/ajax', name: 'post_question', methods: ['POST'])]
    public function post(Request $request): Response
    {
        if ($request->isXmlHttpRequest() ) {
            $name = $request->request->get('name');
            $test = $request->request->get('test');
            $arrayAjax = array("name" => $name, 'test' => $test);
            //$reponse = new Reponses('');
            // $reponse->set
            return new JsonResponse($arrayAjax);
        }

    } 
}   
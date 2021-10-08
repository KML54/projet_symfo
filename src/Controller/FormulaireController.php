<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\FormulaireFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FormulaireController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $article = new Article();
        
        $form = $this->createForm(FormulaireFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($article);
            $entityManager->persist($article);
             $entityManager->flush();
        }

        return $this->render("formulaire/index.html.twig", array(
            'form'=>$form->createView(),
        ));
    }
 
    /**
    * @Route("/formulaire/{id}")
    */
    public function viewAction($id) {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $article = $article->find($id);
        $form = $this->createForm(FormulaireFormType::class, $article);

        if (!$article) {
            throw $this->createNotFoundException(
                    'Aucun article pour l\'id: ' . $id
                );
        }

        return $this->render(
            'formulaire/index.html.twig',
            array('form' => $form->createView(), 'article' => $article)
            );

        }

    /**
    * @Route("/list")
    */
    public function list(Request $request) {
        $articles = $this->getDoctrine()->getRepository(Article::class)->listAllArticle();

        return $this->render(
            'formulaire/list.html.twig',
            array('article' => $articles)
            );


    }
    /**
    * @Route("/delete/{id}")
    */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Article::class);
        $article = $article->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'There are no articles with the following id: ' . $id
            );
        }
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('article_all'));
    }
}
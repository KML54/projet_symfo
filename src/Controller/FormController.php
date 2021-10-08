<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function list(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->listAllArticles();
        return $this->render('index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * @Route("/form")
     */
    public function new(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->render('form/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/form/{id}")
     */
    public function editArticle(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->getById($id);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }

        return $this->render('form/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

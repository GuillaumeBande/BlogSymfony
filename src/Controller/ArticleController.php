<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleController extends AbstractController
{
    /**
     * @Route("/insert", name="insert")
     */
    public function insertArticle(EntityManagerInterface $entityManager)
    {
        $article = new Article();
        $article->setTitle('Titre depuis le controlleur');
        $article->setContent('un content');
        $article->setIsPublished('1');
        $article->setCreatedAt(new \DateTime('NOW'));



        $entityManager->persist($article);
        $entityManager->flush();

        dump(die('OK'));
    }

    /**
     * @Route("/articles/update/title/{id}", name="articleUpdateTitle")
     */
    public function updateTitle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
        if ($article)
        {
            $article->setTitle('TEst du nouveau titre');
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articleList');
    }

    /**
     * @Route("/articles/update/content/{id}", name="articleUpdateContent")
     */
    public function updateContent($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
        if ($article)
        {
            $article->setContent('Nouveau contenue de l article');
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articleList');
    }



    /**
     * @Route("/articles", name="articleList")
     */

    public function articleList(ArticleRepository $articleRepository)
    {
        // je dois faire une requête SQL SELECT en bdd
        // sur la table article
        // La classe qui me permet de faire des requêtes SELECT est ArticleRepository.php
        // donc je dois instancier cette classe
        // pour ça, j'utilise l'autowire (je place la classe en argument du controleur,
        // suivi de la variable dans laquelle je veux que sf m'instancie la classe
        $articles = $articleRepository->findAll();

        return $this->render('article_list.html.twig', [
            'articles' => $articles
        ]);



    }


    /**
     * @Route("/articles/{id}", name="articleShow")
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // afficher un article en fonction de l'id renseigné dans l'url (en wildcard)
        $article = $articleRepository->find($id);

        return $this->render('article_show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/search", name="search")
     */

    public function search(ArticleRepository $articleRepository, Request $request)
    {
        //declaration de la variable qui stocke le mot rechercher en dur
        $term = $request->query->get('q');

        //declaration variable : stocker les éléments retournés via repository en fonction de $term
        $articles = $articleRepository->searchByTerm($term);

        //Methode pour renvoi de la reponse de la requete repository
        return $this->render('articleSearch.html.twig' , [
            'articles' => $articles,
            'term' => $term
        ]);

    }

}

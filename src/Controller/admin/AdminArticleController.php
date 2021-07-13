<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class AdminArticleController extends AbstractController
{
    //Je défini la route (le lien http) pour aller sur la page
    /**
     * @Route("/admin/insert", name="AdminInsert")
     */
    //Je crée une nouvelle fonction avec en parametre "EntityManagerInterface" pour pouvoir modifier des données dans la BDD
    public function insertArticle()
    {
        $article = new Article();

        $articleForm = $this->createForm(ArticleType::class, $article);

        return $this->render('admin/admin_insert.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/update/content/{id}", name="AdminArticleUpdateContent")
     */
    public function updateContent($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

            $article->setContent('Nouveau contenue de l article');
            $entityManager->persist($article);
            $entityManager->flush();

        return $this->redirectToRoute('AdminArticleList');
    }

    /**
     * @Route("admin/articles/delete/{id}" , name="adminArticleDelete")
     */
public function deleteArticle($id, ArticleRepository  $articleRepository, EntityManagerInterface $entityManager)
{
    $article=$articleRepository->find($id);

    $entityManager->remove($article);
    $entityManager->flush();

    return $this->redirectToRoute('AdminArticleList');
}

    /**
     * @Route("/admin/articles", name="AdminArticleList")
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

        return $this->render('admin/admin_article_list.html.twig', [
            'articles' => $articles
        ]);



    }


    /**
     * @Route("/admin/articles/{id}", name="admin_articleShow")
     */
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // afficher un article en fonction de l'id renseigné dans l'url (en wildcard)
        $article = $articleRepository->find($id);

        return $this->render('admin/admin_article_show.html.twig', [
            'article' => $article
        ]);
    }


}

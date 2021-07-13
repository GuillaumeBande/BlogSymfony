<?php

namespace App\Controller\admin;

use App\Entity\Article;
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
    public function insertArticle(EntityManagerInterface $entityManager)
    {
        $article = new Article();
        //J'ajoute dans le champs title un nouveau titre
        $article->setTitle('Titre depuis le controlleur');
        //J'ajoute dans le champs content un nouveau contenu
        $article->setContent('un content');
        //Je lui dis s'il est publier ou nous (ici, oui il est publié car 1=oui, 0=non)
        $article->setIsPublished('1');
        //Je défini une nouvelle date (ici, l'heure actuel)
        $article->setCreatedAt(new \DateTime('NOW'));



        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('AdminArticleList');
    }

    /**
     * @Route("/admin/articles/update/title/{id}", name="admin_articleUpdateTitle")
     */
    public function updateTitle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
        if ($article=$article)
        {
            $article->setTitle('TEst du nouveau titre');
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('AdminArticleList');
    }


    /**
     * @Route ("/admin/articles/update/published0/{id}", name="admin_articleUpdatePublished0")
     */
    public function udpdatePublished0($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
            $article->setIsPublished('0');
            $entityManager->persist($article);
            $entityManager->flush();

        return $this->redirectToRoute('AdminArticleList');
    }

    /**
     * @Route ("/admin/articles/update/published1/{id}", name="admin_articleUpdatePublished1")
     */
    public function udpdatePublished1($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

            $article->setIsPublished('1');
            $entityManager->persist($article);
            $entityManager->flush();

        return $this->redirectToRoute('AdminArticleList');
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

        return $this->render('admin\admin_article_list.html.twig', [
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

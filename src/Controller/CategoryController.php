<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
/**
* @Route("/category", name="categoryList")
*/
    public function categoryList(CategoryRepository $categoryRepository): Response //l'autowire
    {
        $category = $categoryRepository->findAll();
        return $this->render('categorie_list.html.twig', [
            'category' => $category
        ]);

    }

/**
* @Route("/category/{id}", name="categoryShow")//utilisation de la wildcard
*/
    public function categoryShow($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        //Si le tag n'existe pas => renvoie une error exception en affichant erreur 404
        if (is_null($category)) {
            throw new NotFoundHttpException();
        };

        return $this->render('categorie_show.html.twig', [
            'category' => $category
        ]);

    }
}
<?php



namespace App\Controller\admin;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

//
//  Pour tag c'est OneToMany
//
class AdminTagController extends AbstractController
{
/**
* @Route("/admin/tags", name="admin_tags")
*/
    public function TagsBlog(TagRepository $tagRepository): \Symfony\Component\HttpFoundation\Response
    {
        // récupérer tous les tags depuis la bdd
        $tags = $tagRepository->findAll();

        //dump('test'); die; => ici je test la function et Route
        return $this->render('admin/admin_tag_list.html.twig', [
            'tags' => $tags
        ]);
    }


/**
* @Route("/admin/tags/{id}", name="admin_tagShow")
*/
    public function Tagid($id, TagRepository $tagRepository): \Symfony\Component\HttpFoundation\Response
        //l'autowire permet d'instancier (tipier = va recuperer l'intancier)
    {
        // récupérwwer tous les id dns la table tags depuis la bdd
        $tag = $tagRepository->find($id);

        //Si le tag n'existe pas => renvoie une error exception en affichant erreur 404
        if (is_null($tag)) {
            throw new NotFoundHttpException();
        };

        //dump('test'); die; => ici je test la function et Route
        return $this->render('admin/admin_tag_show.html.twig', [
            'tag' => $tag
        ]);
    }
}
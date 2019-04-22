<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\TacheRdv;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

//    public function index()
//    {
//        // On récupère par doctrine les données des articles
//        $repo = $this->getDoctrine()->getRepository(Article::class);
//
//        $articles = $repo->findAll();
//
//        return $this->render('blog/home.html.twig', [
//            'controller_name' => 'BlogController',
//            'articles' => $articles
//        ]);
//    }


//    /**
//     * @Route("/", name="home")
//     */
//    public function home()
//    {
//        return $this->render('blog/home.html.twig', [
//            'title' => "Bienvenue ici les amis!",
//            'age' => 31
//        ]);
//    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}

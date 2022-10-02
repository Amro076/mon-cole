<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonecoleController extends AbstractController
{
    #[Route('/monecole', name: 'app_monecole')]
    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();
        return $this->render('monecole/index.html.twig', [
            'controller_name' => 'MonecoleController', 'articles' => $articles
        ]);
    }
    #[Route('/', name: 'controller_home') ]
    public function home()
    {
        
        return $this->render('monecole/home.html.twig');
    }


    #[Route('monecole/show/{id}', name:'monecole_show')]
    public function show(Article $article)
    {
        return $this->render('monecole/show.html.twig', [
            'article' => $article
        ]);
        }
        


    #[Route("/monecole/new", name:'monecole_new')]
    #[Route("/monecole/edit/{id}", name:'monecole_edit')]
    public function form(Request $request, EntityManagerInterface $manager, Article $article = null)
    {
        if(!$article)
        {
            $article = new Article;
            $article->setCreatedAt(new \DateTime());
        }
       
        $form = $this->createForm(ArticleType::class, $article);
        //dump($request);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('monecole_show',[
                'id' => $article->getId()
            ]);
        }
        return $this->render("monecole/form.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== NULL
        ]);
    }
    #[Route("/delete/{id}", name:"monecole_delete")]
    public function delete($id, EntityManagerInterface $manager, ArticleRepository $repo)
    {   
        $article = $repo->find($id);

        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute("app_monecole");
    }
}

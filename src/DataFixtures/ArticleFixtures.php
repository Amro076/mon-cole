<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
  
        
    
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 10; $i++) 
        { 
        $article = new Article;

        $article->setTitle("titre $i")
                ->setContent("<p> contenu $i </p>")
                ->setImage("https://picsum.photos/200/300")
                ->setCreatedAt(new \DateTime());
        
      
        $manager->persist($article);
        
        }
    $manager->flush();
    }
}

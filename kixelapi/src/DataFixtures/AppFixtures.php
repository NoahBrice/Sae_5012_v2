<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Site;
use App\Entity\Bloc;
use App\Entity\Article;
use App\Repository\SiteRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher, private SiteRepository $repo){
        
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //////////////////////////
        // Site
        //////////////////////////
        $site = new Site;
       
        $site->setNom("test");
        $site->setPath("paht_test");


        $manager->persist($site);
        $manager->flush();

        //////////////////////////
        // Article
        //////////////////////////
        $article = new Article;
        $article->setTitre("Article Test");        
        $article->setResume("Ceci est un article de test"); // 
        $article->setPosition(1);
        
        // $article->addSite($this->repo->findByName("pages")[0]);
        // $article->addSite($this->repo->findByName("blocs")[0]);
        
        $manager->persist($article);
        $manager->flush();

        //////////////////////////
        // Article
        //////////////////////////
        $bloc = new Bloc;
        $bloc->setTitre("Bloc de test"); // 
        $bloc->setContenu("Ceci est un Bloc de test"); // 
        $bloc->setNotable(1); // 
        
        // $bloc->addSite($this->repo->findByName("TypeBloc")[0]);
        // $bloc->addSite($this->repo->findByName("Article")[0]);
        // $bloc->addSite($this->repo->findByName("Comentaires")[0]);
        // $bloc->addSite($this->repo->findByName("Reactions")[0]);
        
        $manager->persist($article);
        $manager->flush();

        //////////////////////////
        // User
        //////////////////////////
        $admin = new User;
        $admin->setEmail("admin@a.com");        
        $admin->setPassword($this->hasher->hashPassword($admin, '1234')); // 
        $admin->setRoles(["ROLE_ADMIN", "ROLE_USER"]);
        $admin->setNom("admin");
        $admin->setPrenom("admin");
        $admin->addSite($this->repo->findByName("test")[0]);
        $manager->persist($admin);
        $manager->flush();

    }
}

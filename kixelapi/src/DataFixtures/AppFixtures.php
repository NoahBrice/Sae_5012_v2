<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Site;
use App\Entity\Bloc;
use App\Entity\Article;
use App\Entity\DataSet;
use App\Entity\Commentaire;
use App\Entity\Page;
use App\Entity\Reaction;
use App\Entity\Theme;
use App\Entity\TypeBloc;
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
        
        // $article->addPages($this->repo->findByName("pages")[0]);
        // $article->addBlocs($this->repo->findByName("blocs")[0]);
        
        $manager->persist($article);
        $manager->flush();

        //////////////////////////
        // Bloc
        //////////////////////////

        $bloc = new Bloc;
        $bloc->setTitre("Bloc de test"); // 
        $bloc->setContenu("Ceci est un Bloc de test"); // 
        $bloc->setNotable(1); // 
        
        // $bloc->addArticle($this->repo->findByName("TypeBloc")[0]);
        // $bloc->addCommentaire($this->repo->findByName("Article")[0]);
        // $bloc->addReaction($this->repo->findByName("Comentaires")[0]);
        // $bloc->addTypeBloc($this->repo->findByName("Reactions")[0]);

        $manager->persist($bloc);
        $manager->flush();

        //////////////////////////
        // Type Bloc
        //////////////////////////

        $typeBloc = new TypeBloc;
        $typeBloc->setNom("typeBloc de test"); // 
        $typeBloc->setInfoBlocPath("/"); // 
        
        // $typeBloc->addBlocs($this->repo->findByName("TypeTypeBloc")[0]);

        $manager->persist($typeBloc);
        $manager->flush();

        //////////////////////////
        // Thèmes
        //////////////////////////

        $theme = new Theme;
        $theme->setNom("theme de test"); // 
        $theme->setPath("/"); // 
        
        // $theme->addSites($this->repo->findByName("Site")[0]);
        
        $manager->persist($theme);
        $manager->flush();

        //////////////////////////
        // Réactions
        //////////////////////////
        $reaction = new Reaction;
        $reaction->setNote(1); // 
        
        // $reaction->addUser($this->repo->findByName("Site")[0]);
        // $reaction->addBloc($this->repo->findByName("Site")[0]);
        
        $manager->persist($reaction);
        $manager->flush();

        //////////////////////////
        // Pages
        //////////////////////////
        $page = new Page;
        $page->setNom("test"); // 
        
        // $page->addBloc($this->repo->findByName("Site")[0]);
        // $page->addArticle($this->repo->findByName("Site")[0]);
        // $page->addSite($this->repo->findByName("Site")[0]);
        
        $manager->persist($page);
        $manager->flush();

        //////////////////////////
        // Data Sets
        //////////////////////////
        $dataSet = new DataSet;
        $dataSet->setNom("test"); // 
        
        // $dataSet->addBloc($this->repo->findByName("Site")[0]);
        // $dataSet->addArticle($this->repo->findByName("Site")[0]);
        // $dataSet->addSite($this->repo->findByName("Site")[0]);
        
        $manager->persist($dataSet);
        $manager->flush();

        //////////////////////////
        // Commentaires
        //////////////////////////
        $commentaire = new Commentaire;
        $commentaire->setContenu("test"); // 
        $commentaire->setPath("/"); // 
        
        // $commentaire->addUser($this->repo->findByName("Site")[0]);
        // $commentaire->addBloc($this->repo->findByName("Site")[0]);
        
        $manager->persist($commentaire);
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

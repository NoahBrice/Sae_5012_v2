<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Site;
use App\Entity\User;
use App\Entity\Bloc;
use App\Entity\Article;
use App\Entity\DataSet;
use App\Entity\Commentaire;
use App\Entity\Page;
use App\Entity\Reaction;
use App\Entity\Theme;
use App\Entity\TypeBloc;
use App\Repository\SiteRepository;
use App\Repository\UserRepository;
use App\Repository\BlocRepository;
use App\Repository\ArticleRepository;
use App\Repository\DataSetRepository;
use App\Repository\CommentaireRepository;
use App\Repository\PageRepository;
use App\Repository\ReactionRepository;
use App\Repository\ThemeRepository;
use App\Repository\TypeBlocRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher, private SiteRepository $siteRepo, private UserRepository $userRepo,private BlocRepository $blocRepo,private ArticleRepository $articleRepo,private DataSetRepository $dataSetRepo,private CommentaireRepository $commentaireRepo,private PageRepository $pageRepo,private ReactionRepository $reactionRepo,private ThemeRepository $themeRepo,private TypeBlocRepository $typeBlocRepo){
        
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
        

        
        $manager->persist($article);
        $manager->flush();

        //////////////////////////
        // Bloc
        //////////////////////////

        $bloc = new Bloc;
        $bloc->setTitre("Bloc de test"); // 
        $bloc->setContenu("Ceci est un Bloc de test"); // 
        $bloc->setNotable(1); // 
        


        $manager->persist($bloc);
        $manager->flush();

        //////////////////////////
        // Type Bloc
        //////////////////////////

        $typeBloc = new TypeBloc;
        $typeBloc->setNom("typeBloc de test"); // 
        $typeBloc->setInfoBlocPath("/"); // 
        

        $manager->persist($typeBloc);
        $manager->flush();

        //////////////////////////
        // Thèmes
        //////////////////////////

        $theme = new Theme;
        $theme->setNom("theme de test"); // 
        $theme->setPath("/"); // 
        
        
        $manager->persist($theme);
        $manager->flush();

        //////////////////////////
        // Réactions
        //////////////////////////
        $reaction = new Reaction;
        $reaction->setNote(1); // 
        

        
        $manager->persist($reaction);
        $manager->flush();

        //////////////////////////
        // Pages
        //////////////////////////
        $page = new Page;
        $page->setNom("test"); // 
        

        
        $manager->persist($page);
        $manager->flush();

        //////////////////////////
        // Data Sets
        //////////////////////////
        $dataSet = new DataSet;
        $dataSet->setNom("test"); // 
        

        
        $manager->persist($dataSet);
        $manager->flush();

        //////////////////////////
        // Commentaires
        //////////////////////////
        $commentaire = new Commentaire;
        $commentaire->setContenu("test"); // 
        $commentaire->setPath("/"); // 
        
        
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



        $manager->persist($admin);
        $manager->flush();

        //////////////////////////
        // Relation
        //////////////////////////

                    //////////////////////////
                    // Relation Commentaire
                    //////////////////////////

                    // Reçois de relation uniquement
                    
                    //////////////////////////
                    // Relation User
                    //////////////////////////

                    $admin->addSite($this->siteRepo->findByName("test")[0]);
                    $admin->addCommentaire($this->siteRepo->findByName("test")[0]);
                    $admin->addCommentaire($this->siteRepo->findByName(1)[0]);
                    $manager->persist($admin);

                    //////////////////////////
                    // Relation Article
                    //////////////////////////

                    // Reçois de relation uniquement
                    
                    //////////////////////////
                    // Relation Bloc
                    //////////////////////////

                    $bloc->addArticle($this->articleRepo->findByName("Article Test")[0]);
                    $bloc->addCommentaire($this->commentaireRepo->findByName("test")[0]);
                    $bloc->addReaction($this->reactionRepo->findByName(1)[0]);
                    $manager->persist($bloc);


                    //////////////////////////
                    // Relation DataSet
                    //////////////////////////

                    // Reçois de relation uniquement

                    //////////////////////////
                    // Relation Page
                    //////////////////////////
                    $page->addBloc($this->blocRepo->findByName("Bloc de test")[0]);
                    $page->addArticle($this->articleRepo->findByName("Article de test")[0]); // no indice 0
                    // $page->addSite($this->siteRepo->findByName("test")[0]);
                    $manager->persist($page);


                    //////////////////////////
                    // Relation Réaction
                    //////////////////////////

                    // Reçois de relation uniquement                 

                    //////////////////////////
                    // Relation Site
                    //////////////////////////

                    $site->addPage($this->pageRepo->findByName("test")[0]);
                    // $site->addUser($this->userRepo->findByName("admin@a.com")[0]); bizzarre
                    $site->getDataSets($this->dataSetRepo->findByName("test")[0]);
                    $site->getThemes($this->themeRepo->findByName("theme de test")[0]);
                    $manager->persist($site);



                    //////////////////////////
                    // Relation Theme
                    //////////////////////////

                    // Reçois de relation uniquement

                    //////////////////////////
                    // Relation Type de bloc
                    //////////////////////////

                    $typeBloc->addBloc($this->blocRepo->findByName("Bloc de test")[0]);
                    $manager->persist($typeBloc);



        $manager->flush();





    }
}

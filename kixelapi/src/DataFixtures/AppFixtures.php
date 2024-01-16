<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Site;
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
                $site = new Site;
       
        $site->setNom("test");
        $site->setPath("paht_test");


        $manager->persist($site);
        $manager->flush();



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

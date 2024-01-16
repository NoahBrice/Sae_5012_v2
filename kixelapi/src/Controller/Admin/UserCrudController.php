<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // TextField::new('nom'),
            // TextField::new('prenom'),
            // TextField::new('password'),
            // "id",
            IdField::new('id')->onlyOnIndex(),
            "nom",
            "prenom",
            "email",
            "password",
            ArrayField::new('roles'),
            AssociationField::new('site')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getSite();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }),
        ];
    }
   
}

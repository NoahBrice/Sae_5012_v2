<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            "contenu",
            "path",
            AssociationField::new('user')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getPages();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }),            
            AssociationField::new('bloc')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getPages();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }),
        ];
    }
    
}

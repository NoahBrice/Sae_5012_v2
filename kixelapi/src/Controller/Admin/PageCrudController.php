<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            "nom",
            AssociationField::new('bloc')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getBlocs();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }),
            AssociationField::new('article')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getBlocs();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }),
            AssociationField::new('site')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getBlocs();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            })
        ];
    }
    
}

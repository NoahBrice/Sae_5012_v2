<?php

namespace App\Controller\Admin;

use App\Entity\Bloc;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlocCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bloc::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            "typeBloc",
            "titre",
            "contenu",
            "notable",
            AssociationField::new('article')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getBlocs();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }),
            AssociationField::new('commentaires')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getBlocs();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }), 
           AssociationField::new('reactions')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
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

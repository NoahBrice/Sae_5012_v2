<?php

namespace App\Controller\Admin;

use App\Entity\Reaction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reaction::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            "note",
            AssociationField::new('user')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getUser();
                $label = "";
                if($associatedEntitys != null){
                    if ($associatedEntitys instanceof Collection) {
                        foreach ($associatedEntitys as $associatedEntity) {
                            $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                        }
                    } else {
                        $label = $label . $associatedEntitys->getNom() . "(" . $associatedEntitys->getId() . ")" . ", ";
                    }
                }
                else{
                    return "empty";
                }
                return $label;
            }),
            AssociationField::new('bloc')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getBloc();
                $label = "";
                if($associatedEntitys != null){
                    if ($associatedEntitys instanceof Collection) {
                        foreach ($associatedEntitys as $associatedEntity) {
                            $label = $label . $associatedEntity->getContenu() . "(" . $associatedEntity->getId() . ")" . ", ";
                        }
                    } else {
                        $label = $label . $associatedEntitys->getContenu() . "(" . $associatedEntitys->getId() . ")" . ", ";
                    }
                }
                else{
                    return "empty";
                }
                return $label;
            }),
            
        ];
    }
    
}

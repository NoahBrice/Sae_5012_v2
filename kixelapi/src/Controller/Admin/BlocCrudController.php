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
            AssociationField::new('TypeBloc')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getTypeBloc();
                $label = "";
                // dd($entity);
                if($associatedEntitys != null){
                    foreach ($associatedEntitys as $associatedEntity) {
                        $label = $label . $associatedEntity->getNom() . "(" . $associatedEntity->getId() . ")" . ", ";
                    }
                    
                }
                else{
                    return "empty";
                }
                return $label;

            }),
            "titre",
            "contenu",
            "notable",
            AssociationField::new('article')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getArticle();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getTitre() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }),
            AssociationField::new('commentaires')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getCommentaires();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getContenu() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            }), 
           AssociationField::new('reactions')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getReactions();
                $label = "";
                foreach ($associatedEntitys as $associatedEntity) {
                    $label = $label . $associatedEntity->getNote() . "(" . $associatedEntity->getId() . ")" . ", ";
                }
                return $label;
            })
 
        ];
    }

}

<?php

namespace App\Controller\Admin;

use App\Entity\DataSet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class DataSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DataSet::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            "nom",
            "json_path",
            AssociationField::new('site')->setFormTypeOption('by_reference', false)->formatValue(function ($value, $entity) {
                $associatedEntitys = $entity->getSite();
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
        ];
    }
    
}

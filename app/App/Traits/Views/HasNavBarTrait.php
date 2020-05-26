<?php

namespace App\App\Traits\Views;

use App\Domain\Client\CheckPoint\Type\CheckPointType;

trait HasNavBarTrait
{
    public function makeNavBar($entity,$relations)
    {
        $models = array_keys($relations);
        $navBar = $this->getParentNest($entity,$models,$relations);
        return $navBar;
    }

    protected function getParentNest($entity,$models,$relations)
    {
        $parent = array();
        foreach ($entity as $item) {
            $prop = $relations[$models[0]]['name'];
            $field = $relations[$models[0]]['field'];
            $alter = $relations[$models[0]]['alter'];
            array_push($parent,[
                'name' => $item->$prop,
                'url' => $relations[$models[0]]['url'].$item->$field,
                'alter' => $alter,
                'childs' => (count($relations) > 1)?$this->getChilds($item,$models,$relations,1):false
            ]);
        }
        return $parent;
    }

    protected function getChilds($entity,$models,$relations,$cursor)
    {
        $child = array();
        if($cursor < count($relations)) {
            $model = $models[$cursor];
            $entity = $entity->$model;


            foreach($entity as $item) {

                $prop = $relations[$models[$cursor]]['name'] ?? false;
                $field = $relations[$models[$cursor]]['field'] ?? false;
                $alter = $relations[$models[$cursor]]['alter'] ?? false;
                $url = $relations[$models[$cursor]]['url'] ?? false;

                array_push($child, [
                    'name' => ($prop)?$item->$prop:false,
                    'alter' => ($alter)?$alter:false,
                    'url' => ($url && $field)?$url.$item->$field:false,
                    'childs' => ($cursor < count($relations))?$this->getChilds($item,$models,$relations,$cursor+1):false
                ]);
            }
            return $child;
        }
        return false;

    }
}

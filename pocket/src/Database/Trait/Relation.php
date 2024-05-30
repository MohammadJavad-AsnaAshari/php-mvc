<?php

namespace Mj\PocketCore\Database\Trait;

trait Relation
{
    public function hasMany($relatedModel, $foreignKey = null)
    {
        $relatedModel = new $relatedModel();
        $foreignKey = $foreignKey ?? (substr($this->table, 0, -1) . '_id');
        $relatedModel->where($foreignKey, $this->id)->get();

        return $relatedModel;
    }
}
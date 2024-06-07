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

    public function belongsTo($relatedModel, $foreignKey = null)
    {
        $relatedModel = new $relatedModel();
        $foreignKey = $foreignKey ?? 'id';
        $relatedModel->where($foreignKey, $this->id)->first();

        return $relatedModel;
    }

    public function belongsToMany($relatedModel, $pivotTable = null, $foreignKey = null, $relatedKey = null)
    {
        $relatedModel = new $relatedModel();

        $tableNames = [$this->table, $relatedModel->table];
        sort($tableNames);

        $pivotTable = $pivotTable ?? (substr($tableNames[0], 0, -1) . '_' . substr($tableNames[1], 0, -1));
        $foreignKey = $foreignKey ?? (substr($this->table, 0, -1) . '_id');
        $relatedKey = $relatedKey ?? (substr($relatedModel->table, 0, -1) . '_id');

        $pivotModel = new static();
        $pivotModel->from($pivotTable);
        $pivotModel->where($foreignKey, $this->id);
        $pivotResults = $pivotModel->get();

        $relatedIds = [];
        foreach ($pivotResults as $pivotResult) {
            $relatedIds[] = $pivotResult->$relatedKey;
        }

        if (count($relatedIds) !== 0) {
            $relatedModel->from($relatedModel->table);
            $relatedModel->whereIn('id', $relatedIds);
            $relatedResults = $relatedModel->get();

            return $relatedResults;
        }

        return null;
    }
}
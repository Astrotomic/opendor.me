<?php

namespace App\Backpack;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanel as BackpackCrudPanel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CrudPanel extends BackpackCrudPanel
{
    public function getEntry($id)
    {
        if (! $this->entry) {
            $this->entry = $this->query->findOrFail($id);
            $this->entry = $this->entry->withFakes();
        }

        return $this->entry;
    }

    public function update($id, $data): Model
    {
        $data = $this->decodeJsonCastedAttributes($data);
        $data = $this->compactFakeFields($data);
        $item = $this->query->findOrFail($id);

        $this->createRelations($item, $data);

        // omit the n-n relationships when updating the eloquent item
        $nn_relationships = Arr::pluck($this->getRelationFieldsWithPivot(), 'name');

        $data = Arr::except($data, $nn_relationships);

        $updated = $item->update($data);

        return $item;
    }
}

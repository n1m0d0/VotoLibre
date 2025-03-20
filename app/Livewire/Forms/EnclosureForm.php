<?php

namespace App\Livewire\Forms;

use App\Models\Enclosure;
use Livewire\Form;

class EnclosureForm extends Form
{
    public ?Enclosure $enclosure = null;

    public $name;
    public $zone;

    public function rules()
    {
        return [
            'zone' => 'required|exists:zones,id',
            'name' => 'required|string|max:150',
        ];
    }

    public function setEnclosure(Enclosure $enclosure)
    {
        $this->enclosure = $enclosure;
        $this->zone = $enclosure->zone_id;
        $this->name = $enclosure->name;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Enclosure::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->enclosure->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->enclosure->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'zone', 'enclosure']);
    }

    private function collectData()
    {
        return [
            'zone_id' => $this->zone,
            'name' => $this->name,
        ];
    }
}

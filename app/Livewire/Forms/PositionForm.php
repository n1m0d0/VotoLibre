<?php

namespace App\Livewire\Forms;

use App\Models\Position;
use Livewire\Form;

class PositionForm extends Form
{
    public ?Position $position = null;

    public $name;

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
        ];
    }

    public function setPosition(Position $position)
    {
        $this->position = $position;
        $this->name = $position->name;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Position::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->position->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->position->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'position']);
    }

    private function collectData()
    {
        return [
            'name' => $this->name,
        ];
    }
}

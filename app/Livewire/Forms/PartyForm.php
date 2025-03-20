<?php

namespace App\Livewire\Forms;

use App\Models\Party;
use Livewire\Form;

class PartyForm extends Form
{
    public ?Party $party = null;

    public $name;
    public $acronym;

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'acronym' => 'required|string|max:150',
        ];
    }

    public function setParty(Party $party)
    {
        $this->party = $party;
        $this->name = $party->name;
        $this->acronym = $party->acronym;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Party::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->party->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->party->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'acronym', 'party']);
    }

    private function collectData()
    {
        return [
            'name' => $this->name,
            'acronym' => $this->acronym,
        ];
    }
}

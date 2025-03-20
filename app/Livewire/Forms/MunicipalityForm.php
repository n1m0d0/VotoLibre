<?php

namespace App\Livewire\Forms;

use App\Models\Municipality;
use Livewire\Form;

class MunicipalityForm extends Form
{
    public ?Municipality $municipality = null;

    public $name;
    public $province;

    public function rules()
    {
        return [
            'province' => 'required|exists:provinces,id',
            'name' => 'required|string|max:150',
        ];
    }

    public function setMunicipality(Municipality $municipality)
    {
        $this->municipality = $municipality;
        $this->province = $municipality->province_id;
        $this->name = $municipality->name;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Municipality::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->municipality->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->municipality->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'province', 'municipality']);
    }

    private function collectData()
    {
        return [
            'province_id' => $this->province,
            'name' => $this->name,
        ];
    }
}

<?php

namespace App\Livewire\Forms;

use App\Models\District;
use Livewire\Form;

class DistrictForm extends Form
{
    public ?District $district = null;

    public $name;
    public $municipality;

    public function rules()
    {
        return [
            'municipality' => 'required|exists:municipalities,id',
            'name' => 'required|string|max:150',
        ];
    }

    public function setdistrict(District $district)
    {
        $this->district = $district;
        $this->municipality = $district->municipality_id;
        $this->name = $district->name;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        District::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->district->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->district->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'municipality', 'district']);
    }

    private function collectData()
    {
        return [
            'municipality_id' => $this->municipality,
            'name' => $this->name,
        ];
    }
}

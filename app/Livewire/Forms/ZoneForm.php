<?php

namespace App\Livewire\Forms;

use App\Models\Zone;
use Livewire\Form;

class ZoneForm extends Form
{
    public ?Zone $zone = null;

    public $name;
    public $district;

    public function rules()
    {
        return [
            'district' => 'required|exists:districts,id',
            'name' => 'required|string|max:150',
        ];
    }

    public function setZone(Zone $zone)
    {
        $this->zone = $zone;
        $this->district = $zone->district_id;
        $this->name = $zone->name;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Zone::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->zone->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->zone->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'district', 'zone']);
    }

    private function collectData()
    {
        return [
            'district_id' => $this->district,
            'name' => $this->name,
        ];
    }
}

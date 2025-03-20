<?php

namespace App\Livewire\Forms;

use App\Models\Station;
use Livewire\Form;

class StationForm extends Form
{
    public ?Station $station = null;

    public $name;
    public $enclosure;

    public function rules()
    {
        return [
            'enclosure' => 'required|exists:enclosures,id',
            'name' => 'required|string|max:150',
        ];
    }

    public function setStation(Station $station)
    {
        $this->station = $station;
        $this->enclosure = $station->enclosure_id;
        $this->name = $station->name;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Station::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->station->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->station->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'enclosure', 'station']);
    }

    private function collectData()
    {
        return [
            'enclosure_id' => $this->enclosure,
            'name' => $this->name,
        ];
    }
}

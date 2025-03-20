<?php

namespace App\Livewire\Forms;

use App\Models\Province;
use Livewire\Form;

class ProvinceForm extends Form
{
    public ?Province $province = null;

    public $name;
    public $department;

    public function rules()
    {
        return [
            'department' => 'required|exists:departments,id',
            'name' => 'required|string|max:150',
        ];
    }

    public function setProvince(Province $province)
    {
        $this->province = $province;
        $this->department = $province->department_id;
        $this->name = $province->name;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Province::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->province->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->province->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'department', 'province']);
    }

    private function collectData()
    {
        return [
            'department_id' => $this->department,
            'name' => $this->name,
        ];
    }
}

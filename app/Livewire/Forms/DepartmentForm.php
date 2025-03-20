<?php

namespace App\Livewire\Forms;

use App\Models\Department;
use Illuminate\Validation\Rule;
use Livewire\Form;

class DepartmentForm extends Form
{
    public ?Department $department = null;

    public $name;
    public $code;

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'code' => [
                'required',
                'string',
                'max:150',
                Rule::unique('departments')->ignore($this->department?->id)
            ],
        ];
    }

    public function setDepartment(Department $department)
    {
        $this->department = $department;
        $this->name = $department->name;
        $this->code = $department->code;
    }

    public function store()
    {
        $this->validate();

        $data = $this->collectData();
        Department::create($data);

        $this->resetForm();
    }

    public function update()
    {
        $this->validate();

        $data = $this->collectData();
        $this->department->update($data);

        $this->resetForm();
    }

    public function delete()
    {
        $this->department->delete();

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'code', 'department']);
    }

    private function collectData()
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
        ];
    }
}

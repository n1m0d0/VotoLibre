<?php

namespace App\Livewire;

use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentDepartment extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public DepartmentForm $form;

    public function render()
    {
        $departments = Department::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-department', compact('departments'));
    }

    public function save()
    {
        if ($this->activity == "create") {
            $this->form->store();

            toast()
                ->success('El registro se guardó correctamente.')
                ->push();
        }

        if ($this->activity == "edit") {
            $this->form->update();

            toast()
                ->info('Los cambios se guardaron con éxito.')
                ->push();
        }

        $this->activity = "create";

        Flux::modal('department-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $department = Department::findOrFail($id);
            $this->form->setDepartment($department);
            $this->activity = "edit";
        }

        Flux::modal('department-form')->show();
    }

    public function showDelete($id)
    {
        $department = Department::findOrFail($id);
        $this->form->setDepartment($department);

        Flux::modal('department-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('department-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('department-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

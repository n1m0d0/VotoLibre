<?php

namespace App\Livewire;

use App\Livewire\Forms\ProvinceForm;
use App\Models\Department;
use App\Models\Province;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentProvince extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public $departments;

    public ProvinceForm $form;

    public function mount()
    {
        $this->departments = Department::select('id', 'name')->get();
    }

    public function render()
    {
        $provinces = Province::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-province', compact('provinces'));
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

        Flux::modal('province-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $province = Province::findOrFail($id);
            $this->form->setProvince($province);
            $this->activity = "edit";
        } else {
            $this->activity = "create";
        }

        Flux::modal('province-form')->show();
    }

    public function showDelete($id)
    {
        $province = Province::findOrFail($id);
        $this->form->setProvince($province);

        Flux::modal('province-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('province-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('province-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

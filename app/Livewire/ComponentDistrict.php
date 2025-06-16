<?php

namespace App\Livewire;

use App\Livewire\Forms\DistrictForm;
use App\Models\District;
use App\Models\Municipality;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentDistrict extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public $municipalities;

    public DistrictForm $form;

    public function mount()
    {
        $this->municipalities = Municipality::select('id', 'name')->get();
    }
    
    public function render()
    {
        $districts = District::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-district', compact('districts'));
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

        Flux::modal('district-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $district = District::findOrFail($id);
            $this->form->setDistrict($district);
            $this->activity = "edit";
        } else {
            $this->activity = "create";
        }

        Flux::modal('district-form')->show();
    }

    public function showDelete($id)
    {
        $district = District::findOrFail($id);
        $this->form->setDistrict($district);

        Flux::modal('district-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('district-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('district-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

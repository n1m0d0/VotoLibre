<?php

namespace App\Livewire;

use App\Livewire\Forms\MunicipalityForm;
use App\Models\Municipality;
use App\Models\Province;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentMunicipality extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public $provinces;

    public MunicipalityForm $form;

    public function mount()
    {
        $this->provinces = Province::select('id', 'name')->get();
    }

    public function render()
    {
        $municipalities = Municipality::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-municipality', compact('municipalities'));
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

        Flux::modal('municipality-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $municipality = Municipality::findOrFail($id);
            $this->form->setMunicipality($municipality);
            $this->activity = "edit";
        } else {
            $this->activity = "create";
        }

        Flux::modal('municipality-form')->show();
    }

    public function showDelete($id)
    {
        $municipality = Municipality::findOrFail($id);
        $this->form->setMunicipality($municipality);

        Flux::modal('municipality-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('municipality-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('municipality-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

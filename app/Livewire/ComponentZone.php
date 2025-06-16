<?php

namespace App\Livewire;

use App\Livewire\Forms\ZoneForm;
use App\Models\District;
use App\Models\Zone;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentZone extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public $districts;

    public ZoneForm $form;

    public function mount()
    {
        $this->districts = District::select('id', 'name')->get();
    }

    public function render()
    {
        $zones = Zone::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-zone', compact('zones'));
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

        Flux::modal('zone-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $zone = Zone::findOrFail($id);
            $this->form->setZone($zone);
            $this->activity = "edit";
        } else {
            $this->activity = "create";
        }

        Flux::modal('zone-form')->show();
    }

    public function showDelete($id)
    {
        $zone = Zone::findOrFail($id);
        $this->form->setZone($zone);

        Flux::modal('zone-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('zone-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('zone-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

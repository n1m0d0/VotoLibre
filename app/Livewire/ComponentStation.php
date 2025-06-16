<?php

namespace App\Livewire;

use App\Livewire\Forms\StationForm;
use App\Models\Enclosure;
use App\Models\Station;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentStation extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public $enclosures;

    public StationForm $form;

    public function mount()
    {
        $this->enclosures = Enclosure::select('id', 'name')->get();
    }

    public function render()
    {
        $stations = Station::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-station', compact('stations'));
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

        Flux::modal('station-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $station = Station::findOrFail($id);
            $this->form->setStation($station);
            $this->activity = "edit";
        } else {
            $this->activity = "create";
        }

        Flux::modal('station-form')->show();
    }

    public function showDelete($id)
    {
        $station = Station::findOrFail($id);
        $this->form->setStation($station);

        Flux::modal('station-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('station-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('station-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

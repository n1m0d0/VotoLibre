<?php

namespace App\Livewire;

use App\Livewire\Forms\EnclosureForm;
use App\Models\Enclosure;
use App\Models\Zone;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentEnclosure extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public $zones;

    public EnclosureForm $form;

    public function mount()
    {
        $this->zones = Zone::select('id', 'name')->orderBy('name', 'ASC')->get();
    }

    public function render()
    {
        $enclosures = Enclosure::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-enclosure', compact('enclosures'));
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

        Flux::modal('enclosure-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $enclosure = Enclosure::findOrFail($id);
            $this->form->setEnclosure($enclosure);
            $this->activity = "edit";
        }

        Flux::modal('enclosure-form')->show();
    }

    public function showDelete($id)
    {
        $enclosure = Enclosure::findOrFail($id);
        $this->form->setEnclosure($enclosure);

        Flux::modal('enclosure-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('enclosure-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('enclosure-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

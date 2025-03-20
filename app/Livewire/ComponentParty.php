<?php

namespace App\Livewire;

use App\Livewire\Forms\PartyForm;
use App\Models\Party;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentParty extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public PartyForm $form;

    public function render()
    {
        $parties = Party::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-party', compact('parties'));
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

        Flux::modal('party-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $party = Party::findOrFail($id);
            $this->form->setParty($party);
            $this->activity = "edit";
        }

        Flux::modal('party-form')->show();
    }

    public function showDelete($id)
    {
        $party = Party::findOrFail($id);
        $this->form->setParty($party);

        Flux::modal('party-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('party-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('party-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

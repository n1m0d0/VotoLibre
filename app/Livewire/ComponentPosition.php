<?php

namespace App\Livewire;

use App\Livewire\Forms\PositionForm;
use App\Models\Position;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentPosition extends Component
{
    use WireToast;
    use WithPagination;

    public $activity = 'create';
    public $search = '';

    public PositionForm $form;

    public function render()
    {
        $positions = Position::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-position', compact('positions'));
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

        Flux::modal('position-form')->close();
    }

    public function showForm($id = null)
    {
        $this->form->resetForm();

        if ($id) {
            $position = Position::findOrFail($id);
            $this->form->setPosition($position);
            $this->activity = "edit";
        } else {
            $this->activity = "create";
        }

        Flux::modal('position-form')->show();
    }

    public function showDelete($id)
    {
        $position = Position::findOrFail($id);
        $this->form->setPosition($position);

        Flux::modal('position-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('position-delete')->close();
    }

    public function delete()
    {
        $this->form->delete();

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('position-delete')->close();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

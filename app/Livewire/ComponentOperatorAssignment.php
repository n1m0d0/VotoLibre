<?php

namespace App\Livewire;

use App\Models\Enclosure;
use App\Models\Station;
use App\Models\User;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentOperatorAssignment extends Component
{
    use WireToast;
    use WithPagination;

    public $search = '';

    public $user;
    public $enclosure;
    public $station;

    public $enclosures;
    public $stations;

    public function rules()
    {
        return [
            'station' => 'required|exists:stations,id',
        ];
    }

    public function mount()
    {
        $this->enclosures = Enclosure::select('id', 'name')->get();
        $this->stations = collect();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->role('operator')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-operator-assignment', compact('users'));
    }

    public function save()
    {
        $this->validate();

        if ($this->user->stations()->where('station_id', $this->station)->exists()) {
            toast()
                ->danger('El registro ya existe.')
                ->push();

            Flux::modal('assignment-form')->close();

            return;
        }

        $this->user->stations()->attach($this->station);

        toast()
            ->success('El registro se guardó correctamente.')
            ->push();

        Flux::modal('assignment-form')->close();
    }

    public function showForm(User $user)
    {
        $this->resetForm();

        $this->user = $user;

        Flux::modal('assignment-form')->show();
    }

    public function showDelete(User $user, $station)
    {
        $this->resetForm();

        $this->user = $user;
        $this->station = $station;

        Flux::modal('assignment-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('assignment-delete')->close();
    }

    public function delete()
    {
        $this->user->stations()->detach($this->station);

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('assignment-delete')->close();
    }

    public function resetForm()
    {
        $this->reset(['user', 'enclosure', 'station']);
        $this->stations = collect();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedEnclosure()
    {
        if ($this->enclosure) {
            $this->stations = Station::select('id', 'name')->where('enclosure_id', $this->enclosure)->get();
        } else {
            $this->stations = collect();
        }
    }
}

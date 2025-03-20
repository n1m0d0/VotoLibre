<?php

namespace App\Livewire;

use App\Models\Enclosure;
use App\Models\User;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentSupervisorAssignment extends Component
{
    use WireToast;
    use WithPagination;

    public $search = '';

    public $user;
    public $enclosure;

    public $enclosures;

    public function rules()
    {
        return [
            'enclosure' => 'required|exists:enclosures,id',
        ];
    }

    public function mount()
    {
        $this->enclosures = Enclosure::select('id', 'name')->get();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->role('supervisor')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.component-supervisor-assignment', compact('users'));
    }

    public function save()
    {
        $this->validate();

        $this->user->enclosures()->attach($this->enclosure);

        Flux::modal('assignment-form')->close();
    }

    public function showForm(User $user)
    {
        $this->resetForm();

        $this->user = $user;

        Flux::modal('assignment-form')->show();
    }

    public function showDelete(User $user, $enclosure)
    {
        $this->resetForm();

        $this->user = $user;
        $this->enclosure = $enclosure;
    
        Flux::modal('assignment-delete')->show();
    }

    public function closeDelete()
    {
        Flux::modal('assignment-delete')->close();
    }

    public function delete()
    {
        $this->user->enclosures()->detach($this->enclosure);

        toast()
            ->danger('El registro se eliminó correctamente.')
            ->push();

        Flux::modal('assignment-delete')->close();
    }

    public function resetForm()
    {
        $this->reset(['user', 'enclosure']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

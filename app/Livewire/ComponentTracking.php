<?php

namespace App\Livewire;

use App\Models\Record;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentTracking extends Component
{
    use WireToast;
    use WithPagination;

    public $search = '';

    public $id;

    public function render()
    {
        $records = Record::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.component-tracking', compact('records'));
    }

    public function showApproved($id)
    {
        $this->id = $id;

        Flux::modal('tracking-approved')->show();
    }

    public function closeApproved()
    {
        Flux::modal('tracking-approved')->close();
    }

    public function approved()
    {
        $record = Record::find($this->id);
        $record->is_approved = true;
        $record->save();

        toast()
            ->success('El registro se guardó correctamente.')
            ->push();

        Flux::modal('tracking-approved')->close();
    }
}

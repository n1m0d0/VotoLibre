<?php

namespace App\Livewire;

use App\Models\Record;
use Livewire\Component;

class ComponentStationVotes extends Component
{
    public Record $record;

    public function mount(Record $record)
    {
        $this->record = $record;
    }

    public function render()
    {
        return view('livewire.component-station-votes');
    }
}

<?php

namespace App\Livewire;

use App\Exports\EnclosuresExport;
use App\Models\District;
use App\Models\Enclosure;
use App\Models\User;
use App\Models\Zone;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ComponentReport extends Component
{
    public $districts;
    public $zones;
    public $enclosures;
    public $supervisors;
    public $operators;
    public $checkers;

    public function mount()
    {
        $this->districts = District::select('id', 'name')->get();
        $this->zones = Zone::select('id', 'name')->get();
        $this->enclosures = Enclosure::select('id', 'name')->get();
        $this->supervisors = User::select('id', 'name')->role('supervisor')->get();
        $this->operators = User::select('id', 'name')->role('operator')->get();
        $this->checkers = User::select('id', 'name')->role('checker')->get();
    }

    public function render()
    {
        return view('livewire.component-report');
    }

    public function enclosuresExport()
    {
        return Excel::download(new EnclosuresExport, 'recintos.xlsx');
    }
}

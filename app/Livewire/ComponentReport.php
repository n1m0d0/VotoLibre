<?php

namespace App\Livewire;

use App\Exports\EnclosuresExport;
use App\Models\District;
use App\Models\Enclosure;
use App\Models\Zone;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ComponentReport extends Component
{
    public $districts;
    public $zones;
    public $enclosures;

    public function mount()
    {
        $this->districts = District::select('id', 'name')->get();
        $this->zones = Zone::select('id', 'name')->get();
        $this->enclosures = Enclosure::select('id', 'name')->get();
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

<?php

namespace App\Livewire;

use App\Models\Vote;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentVoteEditor extends Component
{
    use WireToast;
    
    public Vote $vote;

    public $originalAmount;
    public $editing = false;

    public $amount;

    public function mount($vote)
    {
        $this->vote = $vote;
        $this->amount = $this->vote->amount;
        $this->originalAmount = $this->amount;
    }

    public function render()
    {
        return view('livewire.component-vote-editor');
    }

    public function startEditing()
    {
        $this->editing = true;
    }

    public function cancelEdit()
    {
        $this->amount = $this->originalAmount;
        $this->editing = false;
    }

    public function save()
    {
        $this->validate([
            'amount' => 'required|integer|min:0',
        ]);

        $this->vote->amount = $this->amount;
        $this->vote->save();

        $this->originalAmount = $this->amount;
        $this->editing = false;

        toast()
            ->success('El registro se guardó correctamente.')
            ->push();
    }
}

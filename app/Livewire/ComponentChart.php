<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ComponentChart extends Component
{
    public function render()
    {
        $votesData = DB::table('votes')
            ->join('parties', 'votes.party_id', '=', 'parties.id')
            ->select('parties.acronym', DB::raw('SUM(votes.amount) as total'))
            ->groupBy('parties.acronym')
            ->get();

        $labels = $votesData->pluck('acronym')->toArray();
        $votes = $votesData->pluck('total')->toArray();

        $totalVotes = DB::table('votes')->sum('amount');

        $backgroundColor = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(201, 203, 207, 0.7)',
            'rgba(255, 99, 255, 0.7)',
            'rgba(99, 255, 132, 0.7)',
            'rgba(132, 99, 255, 0.7)',
        ];

        return view('livewire.component-chart', [
            'labels' => $labels,
            'votes' => $votes,
            'totalVotes' => $totalVotes,
            'backgroundColor' => $backgroundColor,
        ]);
    }
}

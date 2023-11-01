<?php

namespace App\Http\Livewire;

use App\Models\Board;
use Carbon\Carbon;
use Livewire\Component;

class RecentBoards extends Component
{
    public $recentBoards;

    public function mount(){
        $this->recentBoards = collect();
    }

    public function render()
    {
        $boards = Board::orderBy('last_seen', 'desc')->limit(4)->get();
        $this->recentBoards = $boards->map(function ($b){
            $active = true;
            if(now()->diffInSeconds(Carbon::createFromTimeString($b->last_seen)) > 30)
                $active = false;
            return [
                'active' => $active,
                'name' => $b->name,
                'uuid' => $b->uuid,
                'ip' => $b->ip,
                'last_seen' => $b->last_seen
            ];
        });
        return view('livewire.recent-boards', [
            'recentBoards' => $this->recentBoards
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Board;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/** @property-read Collection<array> $recentBoards*/
class RecentBoards extends Component
{
    public Collection $recentBoards;

    public function updateRecentBoards(): void
    {
        $boards = Board::orderBy('last_seen', 'desc')->limit(4)->get();
        $this->recentBoards = $boards->map(function ($b) {
            $active = true;
            $last_seen = $b->last_seen ?? false;
            if ($last_seen and now()->diffInSeconds($last_seen) > 15) {
                $active = false;
            }

            return [
                'active' => $active,
                'name' => $b->name,
                'uuid' => $b->uuid,
                'ip' => $b->ip,
                'last_seen' => $b->last_seen,
            ];
        });
    }

    public function mount(): void
    {
        $this->recentBoards = collect();
    }

    public function render(): view
    {
        $this->updateRecentBoards();

        return view('livewire.recent-boards', [
            'recentBoards' => $this->recentBoards,
        ]);
    }
}

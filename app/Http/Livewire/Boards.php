<?php

namespace App\Http\Livewire;

use App\Models\Board;
use Livewire\Component;
use Illuminate\View\View;

class Boards extends Component
{
    public string $search;

    public function mount(): void
    {
        $this->search = '';
    }
    public function render(): View
    {
        return view('livewire.boards', [
            'boards' => Board::where('name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('uuid', 'like', '%'.$this->search.'%')
                ->get()
        ]);
    }
}

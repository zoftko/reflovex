<?php

namespace App\Http\Livewire;

use App\Models\Board;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\View\View;

class Boards extends Component
{
    public string $search;
    public string $addBName;
    public string $addBUuid;

    public function mount(): void
    {
        $this->search = '';
        $this->addBUuid = '';
        $this->addBName = '';
    }

    public function addBoard(): void
    {
        if (empty($this->addBName) or empty($this->addBUuid)) {
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'error', 'message' => 'Fill board name and UUID']);
            return;
        }

        $validator = Validator::make([
            'name' => $this->addBName,
            'uuid' => $this->addBUuid
        ], [
            'name' => 'string|max:255',
            'uuid' => 'unique:boards,uuid|string|max:12'
        ]);
        if($validator->fails()){
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'error', 'message' => 'UUID too long or registered (remember UUID size is 12)']);
            return;
        }

        $board = new Board();
        $board->name = $this->addBName;
        $board->uuid = $this->addBUuid;
        if( $board->save() ){
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'success', 'message' => 'Board added successfully']);
        }
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

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
    public string $editName;
    public int $editId;

    protected $listeners = [
        'deleteBoard'
    ];

    public function mount(): void
    {
        $this->search = '';
        $this->addBUuid = '';
        $this->addBName = '';
        $this->editId = 0;
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
            'uuid' => 'unique:boards,uuid|string|min:12|max:12'
        ]);
        if($validator->fails()){
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'error', 'message' => $validator->errors()->first()]);
            return;
        }

        $board = new Board();
        $board->name = $this->addBName;
        $board->uuid = $this->addBUuid;
        if( $board->save() ){
            $this->addBName = '';
            $this->addBUuid = '';
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'success', 'message' => 'Board added successfully']);
        }
    }

    public function setEditData(string $name, int $id): void
    {
        $this->editName = $name;
        $this->editId = $id;
        $this->dispatchBrowserEvent('scrollToEditSection', ['name' => $name]);
    }

    public function updateBoardData(): void
    {
        if(empty($this->editName) or ($this->editId == 0)){
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'error', 'message' => 'Name empty or not board selected']);
            return;
        }

        $validator = Validator::make([
            'name' => $this->editName,
        ], [
            'name' => 'string|max:255',
        ]);
        if($validator->fails()){
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'error', 'message' => 'Name too long']);
            return;
        }

        $board = Board::find($this->editId);
        $board->name = $this->editName;
        if($board->save()){
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'success', 'message' => 'Board data updated successfully']);
            $this->editName = '';
        }
    }

    public function deleteBoard(int $id): void
    {
        if(Board::find($id)->delete()){
            $this->dispatchBrowserEvent('serverMessage', ['icon' => 'success', 'message' => 'Board removed successfully']);
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

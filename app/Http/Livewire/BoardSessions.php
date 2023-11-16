<?php

namespace App\Http\Livewire;

use App\Models\Board;
use App\Models\Session;
use Carbon\CarbonInterval;
use Livewire\Component;

class BoardSessions extends Component
{
    public $board;
    public bool $hasSessions;

    public function mount(int $id): void
    {
        $this->board = Board::with('sessions.measurements')->find($id);
        if($this->board->sessions->count() != 0)
            $this->hasSessions = true;
        else
            $this->hasSessions = false;
    }

    public function viewSession(int $id): void
    {
        $session = Session::with('measurements')->find($id);
        if (! is_null($session)) {
            $xAxis = $session->measurements->map(function ($measurement) {
                return $measurement->sequence;
            });
            $yAxis = $session->measurements->map(function ($measurement) {
                return $measurement->temperature;
            });
        }
        $xAxis = $xAxis ?? [];
        $yAxis = $yAxis ?? [];
        $sessionTime = CarbonInterval::seconds(count($yAxis))->cascade()->forHumans();
        $this->dispatchBrowserEvent('updateSessionChartData', [
            'xdata' => $xAxis,
            'ydata' => $yAxis,
            'sessionTime' => $sessionTime,
        ]);
    }

    public function render()
    {
        //dd($this->board->sessions->last()->measurements[100]);
        return view('livewire.board-sessions', [
            'sessions' => $this->board->sessions
        ]);
    }
}

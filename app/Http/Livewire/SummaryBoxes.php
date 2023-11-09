<?php

namespace App\Http\Livewire;

use App\Models\Board;
use App\Models\Measurement;
use App\Models\Profile;
use App\Models\Session;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class SummaryBoxes extends Component
{
    public int $boardsCount;

    public int $sessionsCount;

    public int $profilesCount;

    /** @var Collection<string, string> */
    public Collection $statistics;

    public function updateStatistics(): void
    {
        $this->statistics = $this->generalStatistics();
        $this->boardsCount = Board::count();
        $this->sessionsCount = Session::count();
        $this->profilesCount = Profile::count();
    }

    /** @return Collection<string, string> */
    private function generalStatistics(): Collection
    {
        $statistics = collect();

        //Max temperature registered
        $maxTempReg = Measurement::max('temperature');
        $statistics->put('Max.Temp.Reg.', ['data' => $maxTempReg.' °C', 'class' => 'afterMaxTemp']);

        //Largest session
        $allMeasurements = Measurement::get()->groupBy('session_id');
        $max = 0;
        $sessionKey = null;
        foreach ($allMeasurements as $sk => $m) {
            $current = $m->count();
            if ($current > $max) {
                $sessionKey = $sk;
                $max = $current;
            }
        }
        $statistics->put('Longest Session', ['data' => CarbonInterval::seconds($max)->cascade()->forHumans(), 'class' => 'afterLongSession']);

        //Max temperature of the day
        $maxTempToday = Measurement::whereDay('created_at', (string) (now()->day))->max('temperature');
        $maxTempToday = $maxTempToday != null ? $maxTempToday.' °C' : 'N/A';
        $statistics->put('Max.Temp.Today', ['data' => $maxTempToday, 'class' => 'afterTodayTemp']);

        //Board with most sessions
        $sessions = Session::with('board')->orderBy('id', 'desc')->get()->groupBy('board_id');
        $boardMostSessions = null;
        $boardSessionCount = 0;
        foreach ($sessions as $boardId => $s) {
            $count = $s->count();
            if ($count > $boardSessionCount) {
                $boardSessionCount = $count;
                $boardMostSessions = $s[0]->board ?? null;
            }
        }
        $boardName = $boardMostSessions->name ?? 'N/A';
        $statistics->put('Most sessions', ['data' => $boardName.' ('.$boardSessionCount.')', 'class' => 'afterMostSessions']);

        return $statistics;
    }

    public function render(): view
    {
        $this->updateStatistics();

        return view('livewire.summary-boxes');
    }
}

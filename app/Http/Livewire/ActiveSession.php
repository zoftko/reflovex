<?php

namespace App\Http\Livewire;

use App\Models\Measurement;
use App\Models\Session;
use Illuminate\Database\Eloquent\Model as SModel;
use Illuminate\View\View;
use Livewire\Component;

class ActiveSession extends Component
{
    public bool $activeSession = false;

    public string $sessionBoardName;

    /** @mixin Session */
    public Session $session;

    /** @var array<string> */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /*
     * @var SModel $lastSession
     */
    public function lastSession(): void
    {
        //Get last session from database and compare with now time
        $lastSession = Session::with('board')->orderBy('id', 'desc')->limit(1)->first();
        if (($lastSession ?? false) and ! $this->activeSession) {
            if (($lastSession->created_at ?? false) and $lastSession->created_at->diffInSeconds(now()) < 30) {
                $this->activeSession = true;
                $this->session = $lastSession;
                if ($this->session->board ?? false) {
                    $this->sessionBoardName = $this->session->board->name;
                }
                $this->dispatchBrowserEvent('startActiveSessionUpdater');
            }
        }
    }

    public function sessionMeasurements(): void
    {
        //If session has started we need retrieve all measurements for this session
        //And at the same check created_at of this measurements
        if ($this->activeSession) {
            $measurements = Measurement::where('session_id', $this->session->id)
                ->get();
            if ($measurements->count() > 0) {
                $msmnCrDate = $measurements->last()->created_at ?? false;
                //The RPI sends data every 10 seconds, we'll wait a greater time to declare no data is received
                if ($msmnCrDate and $msmnCrDate->diffInSeconds(now()) < 15) {
                    $dataToSend = $measurements->map(function ($m) {
                        return (float) $m->temperature;
                    })->toArray();
                    $this->dispatchBrowserEvent('getSessionMeasurements', $dataToSend);
                } else {
                    $this->activeSession = false;
                    $this->dispatchBrowserEvent('stopActiveSessionUpdater');
                }
            }
        }
    }

    public function boot(): void
    {
        $this->activeSession = false;
    }

    public function render(): view
    {
        return view('livewire.active-session');
    }
}

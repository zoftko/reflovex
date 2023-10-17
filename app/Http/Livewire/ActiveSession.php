<?php

namespace App\Http\Livewire;

use App\Models\Measurement;
use App\Models\Session;
use Illuminate\View\View;
use Livewire\Component;

class ActiveSession extends Component
{
    public bool $activeSession = false;

    public Session $session;

    /** @var array<string> */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function test(): void
    {
        $this->activeSession = ! $this->activeSession;
        $this->emitSelf('refresh');
    }

    /*
     * @var App\Models\Session $lastSession
     */
    public function lastSession(): void
    {
        //Get last session from database and compare with now time
        $lastSession = Session::orderBy('id', 'desc')->limit(1)->first();
        if (($lastSession ?? false) and ! $this->activeSession) {
            if (($lastSession->created_at ?? false) and $lastSession->created_at->diffInSeconds(now()) < 10) {
                $this->activeSession = true;
                $this->session = $lastSession;
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
                if ($msmnCrDate and $msmnCrDate->diffInSeconds(now()) < 50) {
                    $dataToSend = $measurements->map(function ($m) {
                        return (float) $m->temperature;
                    })->toArray();
                    $this->dispatchBrowserEvent('getSessionMeasurements', $dataToSend);
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

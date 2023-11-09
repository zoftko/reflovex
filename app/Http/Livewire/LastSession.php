<?php

namespace App\Http\Livewire;

use App\Models\Session;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class LastSession extends Component
{
    /** @mixin Session */
    public ?Session $session;

    public string $sessionTime;

    /**
     * @var Collection<int, int>|array<empty>|null
     */
    public $xAxis;

    /**
     * @var Collection<int, int>|array<empty>|null
     */
    public $yAxis;

    public function updateLastSessionChart(): void
    {
        $session = Session::latest()->with('measurements')->first();
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
        $this->dispatchBrowserEvent('updateLastSessionChartData', [
            'xdata' => $xAxis,
            'ydata' => $yAxis,
            'sessionTime' => $sessionTime,
        ]);
    }

    public function render(): view
    {
        $this->session = Session::latest()->with('measurements')->first();
        if (! is_null($this->session)) {
            $this->xAxis = $this->session->measurements->map(function ($measurement) {
                return $measurement->sequence;
            });
            $this->yAxis = $this->session->measurements->map(function ($measurement) {
                return $measurement->temperature;
            });
        }
        $this->xAxis = $this->xAxis ?? [];
        $this->yAxis = $this->yAxis ?? [];
        $this->sessionTime = CarbonInterval::seconds(count($this->yAxis))->cascade()->forHumans();

        return view('livewire.last-session');
    }
}

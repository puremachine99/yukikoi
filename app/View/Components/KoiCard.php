<?php

namespace App\View\Components;

use Illuminate\View\Component;

class KoiCard extends Component
{
    public $koi;
    public $totalBids;

    /**
     * Create a new component instance.
     */
    public function __construct($koi, $totalBids = [])
    {
        $this->koi = $koi;
        $this->totalBids = $totalBids;
        $this->koi->end_time = \Carbon\Carbon::parse($koi->auction->end_time)->toIso8601String();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.koi-card');
    }
}
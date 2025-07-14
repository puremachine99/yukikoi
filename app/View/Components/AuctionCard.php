<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class AuctionCard extends Component
{
    public $auction;

    public function __construct($auction)
    {
        $this->auction = $auction;
        $this->auction->end_time_iso = optional($auction->end_time)
            ? Carbon::parse($auction->end_time)->toIso8601String()
            : null;
    }

    public function render()
    {
        return view('components.auction-card');
    }
}

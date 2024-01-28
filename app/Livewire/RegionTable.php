<?php

namespace App\Livewire;

use App\Models\Region;
use Livewire\Component;

class RegionTable extends Component
{
    public $perPage = 100;
    public $page = 1;

    public function render()
    {
        // $regions = Region::skip(($this->page - 1) * $this->perPage)
        //     ->take($this->perPage)
        //     ->get();
            
        $regions = Region::paginate($this->perPage);
        return view('livewire.region-table', ['regions' => $regions]);
    }
}

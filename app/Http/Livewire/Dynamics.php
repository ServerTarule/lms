<?php

namespace App\Http\Livewire;

use App\Models\DynamicMain;
use Livewire\Component;

class Dynamics extends Component
{
    public function render()
    {
        $master=DynamicMain::where('master',0)->orderBy('name')->get();
        $main=DynamicMain::where('master',1)->orderBy('name')->get();
        // dd($main);
        return view('livewire.dynamics',['masters'=> $master,'main'=>$main]);
    }
}
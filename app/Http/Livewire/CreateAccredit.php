<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreateAccredit extends Component
{
    public $showDiv = false;
    public $display_type = "ed1";
    public $accredit_type = "7";
    public $pin;

    public function mount()
    {
        $this->pin = rand(1000, 9999);
    }

    public function render()
    {
        return view('livewire.create-accredit');
    }
}

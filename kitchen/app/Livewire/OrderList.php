<?php

namespace App\Livewire;

use Livewire\Component;

class OrderList extends Component
{
    public $orders;
    public $status;

    public function render()
    {
        return view('livewire.order-list');
    }
}

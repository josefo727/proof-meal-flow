<?php

namespace App\Livewire;

use App\Actions\StartNewSessionAction;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Menu extends Component
{
    public function createOrder(): void
    {
        app(\App\Actions\CreateOrderAction::class)->execute();
    }

    public function clearOrders(): void
    {
        app(StartNewSessionAction::class)->execute();
        $this->dispatch('clearAllOrders');
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.menu');
    }
}

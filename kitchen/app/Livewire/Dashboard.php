<?php

namespace App\Livewire;

use App\Models\Order;
use App\Enums\OrderStatus;
use Livewire\Component;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    public array $ordersByStatus = [];

    public array $statuses;

    protected $listeners = ['handleOrderUpdated'];

    public function mount(): void
    {
        $this->statuses = OrderStatus::cases();
        $this->loadOrders();
    }

    #[On('echo:update-status-notifications,.UpdateStatusNotification')]
    public function loadOrders(): void
    {
        $this->ordersByStatus = [];
        foreach ($this->statuses as $status) {
            $this->ordersByStatus[$status->value] = Order::query()
                ->with(['recipe'])
                ->orderBy('updated_at', 'desc')
                ->byStatus($status->value)
                ->get();
        }
    }


    #[On('clearAllOrders')]
    public function clearOrders(): void
    {
        Order::query()->truncate();
        $this->loadOrders();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}


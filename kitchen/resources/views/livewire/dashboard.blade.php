<div class="gap-4">
    <!-- Menu -->
    <div class="bg-gray-100 p-4 rounded-lg">
        <livewire:menu />
    </div>

    <!-- Order Lists -->
    <div class="grid grid-cols-5 gap-4 p-4 steps">
        @foreach (App\Enums\OrderStatus::cases() as $status)
            <livewire:order-list
                :key="'order-list-' . $status->value . '-' . md5(json_encode($ordersByStatus[$status->value] ?? []))"
                :orders="$ordersByStatus[$status->value] ?? []"
                :status="$status->label()"
            />
        @endforeach
    </div>
</div>

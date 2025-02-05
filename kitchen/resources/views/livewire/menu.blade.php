<div class="flex items-center justify-between bg-white p-6 rounded-lg shadow">
    <button
        wire:click="createOrder"
        class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 transition">
        Nuevo Pedido
    </button>

    <button
        onclick="if (confirm('¿Estás seguro de que deseas limpiar las órdenes? Esta acción no se puede deshacer y reiniciará el registro de eventos.')) { @this.call('clearOrders') }"
        class="px-4 py-2 bg-red-500 text-white font-bold rounded-lg hover:bg-red-600 transition">
        Limpiar Órdenes
    </button>
</div>

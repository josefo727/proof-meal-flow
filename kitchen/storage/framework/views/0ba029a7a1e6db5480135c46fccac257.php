<div class="gap-4">
    <!-- Menu -->
    <div class="bg-gray-100 p-4 rounded-lg">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('menu', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3035283330-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>

    <!-- Order Lists -->
    <div class="grid grid-cols-5 gap-4 p-4 steps">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = App\Enums\OrderStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('order-list', ['orders' => $ordersByStatus[$status->value] ?? [],'status' => $status->label()]);

$__html = app('livewire')->mount($__name, $__params, 'order-list-' . $status->value . '-' . md5(json_encode($ordersByStatus[$status->value] ?? [])), $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH /app/resources/views/livewire/dashboard.blade.php ENDPATH**/ ?>
<div class="bg-white p-4 rounded-lg shadow">
    <h3 class="text-xl font-bold mb-4 text-gray-800"><?php echo e(ucfirst($status)); ?> - <?php echo e($orders->count()); ?></h3>
    <ul class="space-y-2">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li wire:key=<?php echo e($order['id'].'-'.$order['updated_at']); ?> class="flex items-center p-2 bg-gray-100 rounded">
                <img src="<?php echo e($order->recipe->image); ?>" alt="<?php echo e($order->recipe->name); ?>" class="w-12 h-12 object-cover rounded mr-4">
                <div>
                    <p class="font-bold text-gray-700"><?php echo e($order->recipe->name); ?></p>
                    <p class="text-sm text-gray-600">Para: <?php echo e($order->customer_name); ?></p>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </ul>
</div>
<?php /**PATH /app/resources/views/livewire/order-list.blade.php ENDPATH**/ ?>
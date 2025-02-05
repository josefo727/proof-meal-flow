<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case AWAITING = 'awaiting';
    case PROCESSING = 'processing';
    case READY = 'ready';
    case DELIVERED = 'delivered';

    /**
     * @return string'
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendiente',
            self::AWAITING => 'En espera',
            self::PROCESSING => 'En preparación',
            self::READY => 'Listo',
            self::DELIVERED => 'Entregado',
        };
    }
}

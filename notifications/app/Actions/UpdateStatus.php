<?php

namespace App\Actions;

use App\Events\UpdateStatusNotification;

class UpdateStatus
{
    public function process(array $data): void
    {
        UpdateStatusNotification::dispatch($data);
    }

}

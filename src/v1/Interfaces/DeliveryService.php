<?php

namespace ErpNET\Delivery\v1\Interfaces;

/**
 * Interface DeliveryService
 * @package namespace ErpNET\Models\v1\Interfaces;
 * @see \ErpNET\Delivery\v1\Services\DeliveryServiceEloquent
 */
interface DeliveryService
{
    public function createUser($fields);

    public function createPackage($fields);

    public function productStock();
}

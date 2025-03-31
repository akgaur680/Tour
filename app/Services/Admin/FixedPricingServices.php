<?php

namespace App\Services\Admin;

use App\Models\FixedTourPrices;
use App\Services\CoreService;

class FixedPricingServices extends CoreService
{
    public $model;
    public function __construct()
    {
        $this->model = new FixedTourPrices();
    }
    

}
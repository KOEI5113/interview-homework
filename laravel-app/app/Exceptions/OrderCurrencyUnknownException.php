<?php

namespace App\Exceptions;

use App\Exceptions\BasicException;

class OrderCurrencyUnknownException extends BasicException
{
    protected string $error_identify_code = "ORDER_CURRENCY_UNKNOWN";
    protected int $http_code = 400;
}

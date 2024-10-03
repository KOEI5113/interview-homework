<?php

namespace App\Exceptions;

use App\Exceptions\BasicException;

class OrderNumberDuplicatedException extends BasicException
{
    protected string $error_identify_code = "ORDER_NUMBER_DUPLICATED";
    protected int $http_code = 400;
}

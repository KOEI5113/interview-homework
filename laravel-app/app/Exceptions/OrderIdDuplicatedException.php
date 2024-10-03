<?php

namespace App\Exceptions;

use App\Exceptions\BasicException;

class OrderIdDuplicatedException extends BasicException
{
    protected string $error_identify_code = "ORDER_ID_DUPLICATED";
    protected int $http_code = 400;
}

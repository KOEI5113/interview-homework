<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasicException extends Exception
{
    /**
     * 用來與前端做狀態識別的代碼
     * 
     * @var string
     */
    protected string $error_identify_code = "UNKNOWN";
    
    /**
     * 用來決定 HTTP CODE
     * @var int
     */
    protected int $http_code = 400;

    public static function make(
        string $message, 
        int $http_code = null, 
        string $error_identify_code = null
    ): BasicException
    {
        $Exception = new static($message);
        $Exception->http_code = $http_code ?: $Exception->http_code;
        $Exception->error_identify_code = $error_identify_code ?: $Exception->error_identify_code;
        return $Exception;
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            "status" => $this->http_code,
            "error" => $this->error_identify_code,
            "message" => $this->getMessage()
        ], $this->http_code);
    }
}

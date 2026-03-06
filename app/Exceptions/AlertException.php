<?php

namespace App\Exceptions;

use Exception;

class AlertException extends Exception
{
    protected $message;
    protected $data;

    /**
     * @param $message
     * @param $data
     */
    public function __construct($message, $data)
    {
        $this->message = $message;
        $this->data = $data;
    }


    public function render()
    {
        return response()->json([
            'status' => false
            , 'message' => $this->message
            , 'data' => $this->data
        ], 498);
    }
}

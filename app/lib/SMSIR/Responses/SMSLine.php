<?php

namespace App\lib\SMSIR\Responses;

class SMSLine
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $lineNumber;

    public function __construct(int $id, string $lineNumber)
    {
        $this->id = $id;
        $this->lineNumber = $lineNumber;
    }
}

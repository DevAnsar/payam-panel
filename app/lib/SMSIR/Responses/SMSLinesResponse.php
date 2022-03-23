<?php

namespace App\lib\SMSIR\Responses;

class SMSLinesResponse extends BaseResponse
{
    /**
     * @var SMSLine[]
     */
    public $SMSLines;

    public function __construct(bool $isSuccessful, string $message, array $SMSLines)
    {
        $this->isSuccessful = $isSuccessful;
        $this->message = $message;
        $this->SMSLines = $SMSLines;
    }
}

<?php


namespace App\lib\SMSIR;

use GuzzleHttp\Client;

use App\lib\SMSIR\Responses\SMSLine;
use Psr\Http\Message\ResponseInterface;
use App\lib\SMSIR\Responses\Message;
use GuzzleHttp\Exception\GuzzleException;
use App\lib\SMSIR\Responses\ReceivedMessage;

//use App\lib\SMSIR\Responses\SentMessagesResponse;
//use App\lib\SMSIR\Responses\VerificationCodeResponse;
//use App\lib\SMSIR\Responses\ReceivedMessagesResponse;
//use App\lib\SMSIR\Responses\SentMessage;
//use App\lib\SMSIR\Responses\CreditResponse;

class SmsIRClient
{
    private string $userApiKey;
    private string $secretKey;
    private string $token;
    private string $lineNumber;
    private Client $client;

    /**
     * Create a new SMSIR Instance
     * @param string $userApiKey
     * @param string $secretKey
     * @param string $lineNumber
     * @param int $timeout
     */
    public function __construct(string $userApiKey, string $secretKey, string $lineNumber, int $timeout = 10)
    {
        $this->userApiKey = $userApiKey;
        $this->secretKey = $secretKey;
        $this->token = "";
        $this->lineNumber = $lineNumber;

        $this->client = new Client([
            'base_uri' => 'http://RestfulSms.com/api/',
            'timeout' => $timeout,
        ]);
    }

    /**
     * this method return your credit in sms.ir (sms credit, not money)
     *
     * @return array
     * @throws GuzzleException
     */
    public function smsCredit()
    {
        $result = $this->executeRequest('credit');
        $json = json_decode($result->getBody()->getContents(), true);
        return [
            'isSuccessful'=>$json['IsSuccessful'],
            'message'=>$json['Message'],
            'credit'=>$json['Credit']
        ];
    }

    /**
     * @param string $route
     * @param null $body
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function executeRequest(string $route, $body = null): ResponseInterface
    {
        if (is_null($body)) {
            return $this->client->get($route, [
                'headers' => [
                    'x-sms-ir-secure-token' => $this->getToken(),
                ],
            ]);
        }
        return $this->client->post($route, [
            'json' => $body,
            'headers' => [
                'x-sms-ir-secure-token' => $this->getToken(),
            ],
        ]);
    }

    /**
     * this method used in every request to get the token at first.
     *
     * @return mixed - the Token for use api
     * @return string
     * @throws GuzzleException
     */
    private function getToken()
    {
        $body = [
            'UserApiKey' => $this->userApiKey,
            'SecretKey' => $this->secretKey,
        ];
        $result = $this->client->post('Token', [
            'json' => $body,
        ]);
        return json_decode($result->getBody()->getContents(), true)['TokenKey'];
    }

    /**
     * by this method you can fetch all of your sms lines.
     *
     * @return array
     * @throws GuzzleException
     */
    public function getSMSLines()
    {
        $result = $this->executeRequest('SMSLine');
        $json = json_decode($result->getBody()->getContents(), true);
        $lineArray = [];
        foreach ($json['SMSLines'] as $SMSLine) {
            $lineArray[] = new SMSLine((int)$SMSLine['ID'], (string)$SMSLine['LineNumber']);
        }
        return [
            'isSuccessful'=>$json['IsSuccessful'],
            'message'=> $json['Message'],
            'SMSLines'=>$lineArray
        ];
    }

    /**
     * Simple send message with sms.ir account and line number
     *
     * @param array $messages Messages - Count must be equal with $mobileNumbers
     * @param array $mobileNumbers Numbers - must be equal with $messages
     * @param null $sendDateTime Avoid this param if you want to send message now
     * @return
     * @throws GuzzleException
     */
    public function send(array $messages, array $mobileNumbers, $sendDateTime = null)
    {
        $body = [
            'Messages' => $messages,
            'MobileNumbers' => $mobileNumbers,
            'LineNumber' => $this->lineNumber,
        ];
        if ($sendDateTime !== null) {
            $body['SendDateTime'] = $sendDateTime;
        }
        $result = $this->executeRequest('MessageSend', $body);
        $json = json_decode($result->getBody()->getContents(), true);
        $sentMessages = [];
        if ($json['Ids'] != null ){
            foreach ($json['Ids'] as $sentMessage) {
                $sentMessages[] = [
                    'id'=>(int)$sentMessage['ID'],
                    'mobileNumber'=>(string)$sentMessage['MobileNo']
                ];
//                $sentMessages[] = new SentMessage((int)$sentMessage['ID'], (string)$sentMessage['MobileNo']);
            }
        }

        return [
            'isSuccessful'=>$json['IsSuccessful'],
            'message'=> $json['Message'],
            'batchKey'=>$json['BatchKey'],
            'sentMessages' =>$sentMessages,
        ];

    }

    /**
     * this method send a verification code to your customer. need active the module at panel first.
     *
     * @param string $code
     * @param string $mobileNumber
     * @return
     * @throws GuzzleException
     */
    public function sendVerificationCode(string $code, string $mobileNumber)
    {
        $body = [
            'Code' => $code,
            'MobileNumber' => $mobileNumber,
        ];
        $result = $this->executeRequest('VerificationCode', $body);
        $json = json_decode($result->getBody()->getContents(), true);
        return [
            "isSuccessful"=>$json['IsSuccessful'],
            "message"=>$json['Message'],
            "verificationCodeId"=>(string)$json['VerificationCodeId']
        ];
    }


    /**
     * @param  array  $parameters
     * @param  string  $templateId
     * @param  string  $mobileNumber
     * @return array
     * @throws GuzzleException
     */
    public function ultraFastSend(array $parameters, string $templateId, string $mobileNumber)
    {
        $params = [];
        foreach ($parameters as $key => $value) {
            $params[] = ['Parameter' => $key, 'ParameterValue' => $value];
        }
        $body = [
            'ParameterArray' => $params,
            'TemplateId' => $templateId,
            'Mobile' => $mobileNumber,
        ];
        $result = $this->executeRequest('UltraFastSend', $body);
        $json = json_decode($result->getBody()->getContents(), true);
        return [
            "isSuccessful"=>$json['IsSuccessful'],
            "message"=>$json['Message'],
            "verificationCodeId"=>(string)$json['VerificationCodeId']
        ];
    }

    /**
     * this method used for fetch your sent messages
     *
     * @param $fromDate  = from date (example: 1399/06/01)
     * @param $toDate  = to date (example: 1399/08/25)
     * @param  int  $pageNumber  = the page number
     * @param  int  $perPage  = how many sms you want to fetch in every page
     * @return array
     * @throws GuzzleException
     */
    public function getSentMessages($fromDate, $toDate, int $pageNumber = 1, int $perPage = 100)
    {
        $result = $this->executeRequest("MessageSend?Shamsi_FromDate=$fromDate&Shamsi_ToDate=$toDate&RowsPerPage=$perPage&RequestedPageNumber=$pageNumber");
        $json = json_decode($result->getBody()->getContents(), true);
        $messages = [];
        foreach ($json['Messages'] as $message) {
            $messages[] = new Message(
                (int)$message['ID'],
                (string)$message['LineNumber'],
                (string)$message['SMSMessageBody'],
                (string)$message['MobileNo'],
                (string)$message['TypeOfMessage'],
                (string)$message['NativeDeliveryStatus'],
                (string)$message['ToBeSentAt'],
                (string)$message['SendDateTimeLatin'],
                (string)$message['PersianSendDateTime'],
                (bool)$message['IsChecked'],
                (bool)$message['IsError'],
            );
        }
        return [
            "isSuccessful"=>(bool)$json['IsSuccessful'],
            "message"=>$json['Message'],
            "countOfAll"=>(int)$json['CountOfAll'],
            "messages"=>$messages
        ];
    }

    /**
     * this method used for fetch received messages
     *
     * @param $fromDate  = from date (example: 1399/06/01)
     * @param $toDate  = to date (example: 1399/08/25)
     * @param  int  $pageNumber  = the page number
     * @param  int  $perPage  = how many sms you want to fetch in every page
     * @return array
     * @throws GuzzleException
     */
    public function getReceivedMessages(
        $fromDate,
        $toDate,
        int $pageNumber = 1,
        int $perPage = 100
    ) {
        $result = $this->executeRequest("ReceiveMessage?Shamsi_FromDate=$fromDate&Shamsi_ToDate=$toDate&RowsPerPage=$perPage&RequestedPageNumber=$pageNumber");
        $json = json_decode($result->getBody()->getContents(), true);
        $messages = [];
        foreach ($json['Messages'] as $message) {
            $messages[] = new ReceivedMessage(
                (int)$message['ID'],
                (string)$message['LineNumber'],
                (string)$message['SMSMessageBody'],
                (string)$message['MobileNo'],
                (string)$message['TypeOfMessage'],
                (string)$message['LatinReceiveDateTime'],
                (string)$message['ReceiveDateTime']
            );
        }
        return [
            "isSuccessful"=>(bool)$json['IsSuccessful'],
            "message"=>$json['Message'],
            "countOfAll"=>(int)$json['CountOfAll'],
            "receivedMessage"=>$messages
        ];
    }
}

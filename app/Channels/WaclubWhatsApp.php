<?php

namespace App\Channels;

class WaclubWhatsApp
{




    private $nodeurl;
    private $mediaurl;
    
    private $buttons = [
        'replyButtons' => [
            ['buttonId' => 'yesContinue', 'buttonText' => ['displayText' => 'YES'], 'type' => 1],
            ['buttonId' => 'noContinue', 'buttonText' => ['displayText' => 'NO'], 'type' => 1],
            ['buttonId' => 'info', 'buttonText' => ['displayText' => 'More Info'], 'type' => 1],
        ],
     
        // 'templateButtons' = [
        //     ['index' => 1, 'urlButton' => ['displayText' => 'Visit my website!', 'url' => 'http://waclub.in']],
        //     ['index' => 2, 'callButton' => ['displayText' => 'Call me!', 'phoneNumber' => '+1 (234) 5678-9012']],
        //     ['index' => 3, 'quickReplyButton' => ['displayText' => 'This is a reply, just like normal buttons!', 'id' => 'info']],
        // ],
     
        // 'listButtons' => [
        //     ['title' => 'Level', 'rows' => [['title' => 'Super hot', 'description' => 'Spicy level: super hot', 'rowId' => 'level_super_hot'], ['title' => 'Medium hot', 'description' => 'Spicy level: medium hot', 'rowId' => 'level_medium_hot']]],
        //     ['title' => 'Extra', 'rows' => [['title' => 'Pickles', 'description' => 'Free pickles', 'rowId' => 'free_pickles']]],
        // ],
        // 'mainTitle' => 'Main title', // listButtons only
        // 'buttonText' => 'Text on button', // listButtons only
     
        'footerText' => 'This is footer',
    ];

    public function __construct()
    {
        $this->nodeUrl =  env('NODE_URL');
        $this->mediaurl =  env('MEDIA_URL');
        
    }

    public static function sendMessage($to, $msgtext)
    {
        try {

            $data = [
                'receiver'  => $to,
                'msgtext'   => $msgtext,
                'token'     => env('WACLUB_WHATSAPP_API_TOKE'),
                // 'mediaurl'  => env('NODE_URL'), // delete this line if no media
                // 'buttons'   => $buttons, // delete this line if no buttons
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_URL,  env('NODE_URL'));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        } catch (Request $e) {
            throw new \Exception($e->getMessage());
        }
    }}

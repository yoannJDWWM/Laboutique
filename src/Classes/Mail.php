<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;

class Mail{
    private $api_key = '4123baf5231e70fff0191d1ad91e018d';
    private $api_key_secret ='8f95c0ac0ca52fb9c241bf3390926d6e';

    public function send($to_email, $to_name, $subject, $content ,){

        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
     
$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "yoann@jayles.net",
                'Name' => "La Boutique"
            ],
            'To' => [
                [
                    'Email' => $to_email,
                    'Name' => $to_name
                ]
            ],
            'TemplateID' => 4121951,
            'TemplateLanguage' => true,
            'Subject' => $subject,
            'Variables' => [
                'content' => $content,
               
            ]
        ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);
$response->success() && ($response->getData());
    }
}
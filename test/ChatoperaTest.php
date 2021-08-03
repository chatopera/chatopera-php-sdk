<?php

include_once __DIR__ . "/../vendor/autoload.php";
include_once __DIR__ . "/../src/chatopera/sdk/Chatbot.php";

use PHPUnit\Framework\TestCase;

$accessToken = "token-xxx";

final class ChatoperaTest extends TestCase
{

    public function testCreateChatbot()
    {
        global $accessToken;

        $chatopera = new Chatopera($accessToken);

        $resp = $chatopera->command("POST", "/chatbot", array(
            "description" => "bin",
            "logo" => "",
            "name" => "PHP-Bot" . time(),
            "primaryLanguage" => "zh_CN",
            "fallback" => "11223344",
        ));

        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "done";
        } else {
            throw new Exception("wrong response.");
        }
    }
}

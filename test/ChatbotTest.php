<?php

include_once __DIR__ . "/../vendor/autoload.php";
include_once __DIR__ . "/../src/chatopera/sdk.php";

use PHPUnit\Framework\TestCase;
use chatopera\sdk\Chatbot;

final class EmailTest extends TestCase{

    public function testGenerateCredentails(){
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $method = "POST";
        $path = "/api/v1/chatbot/".$appId."/faq/query";
        chatopera\sdk\generate($appId, $secret, $method, $path);
    }

    public function testCanBeCreatedFromValidEmailAddress()
    {
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $method = "POST";
        $path = "/api/v1/chatbot/".$appId."/faq/query";
        $chatbot = new Chatbot($appId, $secret);

        $chatbot->print();
    }
}



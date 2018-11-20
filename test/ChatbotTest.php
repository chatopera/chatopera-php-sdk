<?php

include_once __DIR__ . "/../vendor/autoload.php";
include_once __DIR__ . "/../src/chatopera/sdk.php";

use PHPUnit\Framework\TestCase;
use chatopera\sdk\Chatbot;

final class ChatbotTest extends TestCase{

    public function testGenerateCredentails(){
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $method = "POST";
        $path = "/api/v1/chatbot/".$appId."/faq/query";
        chatopera\sdk\generate($appId, $secret, $method, $path);
    }

    public function testChatbotDetail()
    {
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->detail();
        print_r($resp);
        if(isset($resp['rc'])  && ($resp['rc'] == 0)){
            print "done";
        } else {
             throw new Exception("wrong response.");
        }
    }

    public function testChatbotConversation()
    {
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->conversation("phpsdk", "你好");
        print_r($resp);
        if(isset($resp['rc'])  && ($resp['rc'] == 0)){
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotFaq()
    {
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->faq("phpsdk", "机器人怎么购买");
        print_r($resp);
        if(isset($resp['rc'])  && ($resp['rc'] == 0)){
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotUsers()
    {
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->users(50, 1);
        print_r($resp);
        if(isset($resp['rc'])  && ($resp['rc'] == 0)){
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }


    public function testChatbotUserChats()
    {
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->chats('phpsdk', 10);
        print_r($resp);
        if(isset($resp['rc'])  && ($resp['rc'] == 0)){
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

//    public function testChatbotMute()
//    {
//        $appId = "5bf27e4d6f80090017b404b7";
//        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
//        $chatbot = new Chatbot($appId, $secret);
//        $resp = $chatbot->mute('phpsdk');
//        print_r($resp);
//    }

//    public function testChatbotIsMute()
//    {
//        $appId = "5bf27e4d6f80090017b404b7";
//        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
//        $chatbot = new Chatbot($appId, $secret);
//        $resp = $chatbot->ismute('phpsdk');
//        print($resp ? "true":"false");
//    }


    public function testChatbotUserProfile()
    {
        $appId = "5bf27e4d6f80090017b404b7";
        $secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->profile('phpsdk');
        print_r($resp);
    }


}



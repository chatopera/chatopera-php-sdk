<?php

include_once __DIR__ . "/../vendor/autoload.php";
include_once __DIR__ . "/../src/chatopera/sdk/Chatbot.php";

use chatopera\sdk\Chatbot;
use PHPUnit\Framework\TestCase;

$appId = "appid-xxx";
$secret = "secret-xxx";

final class ChatbotTest extends TestCase
{
    // public function testGenerateCredentails()
    // {
    //     $appId = "appid-xxx";
    //     $secret = "secret-xxx";
    //     $method = "POST";
    //     $path = "/api/v1/chatbot/" . $appId . "/faq/query";
    //     chatopera\sdk\generate($appId, $secret, $method, $path);
    // }

    public function testChatbotDetail()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->detail();
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "done";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotConversation()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->conversation("phpsdk", "你好");
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotFaq()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->faq("phpsdk", "机器人怎么购买");
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotUsers()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->users(50, 1);
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotUserChats()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->chats('phpsdk', 10);
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotMute()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->mute('phpsdk');
        print_r($resp);
    }

    // public function testChatbotIsMute()
    // {
    //     $appId = "appid-xxx";
    //     $secret = "secret-xxx";
    //     $chatbot = new Chatbot($appId, $secret);
    //     $resp = $chatbot->ismute('phpsdk');
    //     print($resp ? "true" : "false");
    // }

    // public function testChatbotUserProfile()
    // {
    //     $appId = "appid-xxx";
    //     $secret = "secret-xxx";
    //     $chatbot = new Chatbot($appId, $secret);
    //     $resp = $chatbot->profile('phpsdk');
    //     print_r($resp);
    // }

    public function testChatbotIntentSession()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->intentSession('phpsdk', 'phpchannel');
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testChatbotIntentSessionDetail()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->intentSessionDetail('12C168F19B886CD7E0B3686100000000');
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testIntentChat()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->intentSessionDetail('12C168F19B886CD7E0B3686100000000', 'phpsdk', '我想打车');
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testPsychChat()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->psychChat('test', 'nodejs', 'uid001', '确定自己是否有抑郁倾向，想要知道自己当下该怎么办');
        print('testPsychChat');
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }

    public function testPsychSearch()
    {
        global $appId, $secret;

        $chatbot = new Chatbot($appId, $secret);
        $resp = $chatbot->psychSearch('确定自己是否有抑郁倾向，想要知道自己当下该怎么办', 0.2);
        print('testPsychSearch');
        print_r($resp);
        if (isset($resp['rc']) && ($resp['rc'] == 0)) {
            print "pass";
        } else {
            throw new Exception("wrong response.");
        }
    }
}

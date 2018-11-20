<?php
include_once __DIR__ . "/../src/chatopera/chatbot.php";

$appId = "5bf27e4d6f80090017b404b7";
$secret = "e4cbc6a65708c011ec0da73b0f5db7a1";
$method = "POST";
$path = "/api/v1/chatbot/".$appId."/faq/query";

print generate($appId, $secret, $method, $path);
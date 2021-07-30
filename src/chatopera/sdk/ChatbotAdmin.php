<?php
/**
 * Chatopera 开发者平台 PHP SDK
 *  @Author: Hai Liang Wang
 *  @Company: 北京华夏春松科技有限公司
 *  All right reserved.
 */

namespace Chatopera\SDK;

/**
 * Class ChatbotAdmin 管理企业聊天机器人
 * @package Chatopera\SDK
 */
class ChatbotAdmin
{
    private $baseUrl;
    private $accessToken;

    public function __construct($accessToken, $serviceProvider = "https://bot.chatopera.com")
    {
        $this->accessToken = $accessToken;
        $this->baseUrl = $serviceProvider;
    }

    public function command($method, $path, $body = null)
    {
        $service_method = strtoupper($method);
        $service_path = '/api/v1' . $path;

        if (strpos($service_path, '?')) {
            $service_path = $service_path . '&sdklang=php';
        } else {
            $service_path = $service_path . '?sdklang=php';
        }

        $service_url = $this->baseUrl . $service_path;
        $token = $this->$accessToken;

        $request = curl_init($service_url);
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $token",
            "Accept: application/json",
        );

        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, $service_method);
        curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

        if (!empty($body)) {
            $data = json_encode($body);
            array_push($headers, "Content-Length: " . strlen($data));
            curl_setopt($request, CURLOPT_POSTFIELDS, $data);
        }

        $curl_response = curl_exec($request);

        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            throw new Exception("Wrong Chatbot Response.");
        }

        return $this->purge(json_decode($curl_response, true));
    }
}

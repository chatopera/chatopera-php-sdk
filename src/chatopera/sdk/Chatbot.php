<?php
/**
 * Chatopera 开发者平台 PHP SDK
 *  @Author: Hai Liang Wang
 *  @Company: 北京华夏春松科技有限公司
 *  All right reserved.
 */

namespace Chatopera\SDK;

use Exception;

/**
 * Class Chatbot 企业聊天机器人
 * @package Chatopera\SDK
 */
class Chatbot
{

    private $baseUrl; // 服务地址
    private $clientId; // 机器人 ClientId
    private $clientSecret; // 机器人 Secret

    /**
     * Chatbot constructor.
     * @param $clientId 机器人 ClientId
     * @param $clientSecret 机器人 Secret
     */
    public function __construct($clientId, $clientSecret, $serviceProvider = "https://bot.chatopera.com")
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->baseUrl = $serviceProvider;
    }

    /**
     * 认证签名算法
     * @param $clientId
     * @param $secret
     * @param $method
     * @param $path
     * @return string
     */
    private function generate($clientId, $secret, $method, $path)
    {

        if ($clientId == null || $secret == null) {
            return null;
        }

        $timestamp = time();
        $random = rand(1000000000, 9999999999);
        $signature = hash_hmac('sha1', $clientId . $timestamp . $random . $method . $path, $secret);
        $json = json_encode(array(
            'appId' => $clientId,
            'timestamp' => $timestamp,
            'random' => $random,
            'signature' => $signature,
        ));

        return base64_encode($json);
    }

    public function arsRecognize($service_url, $body, $token)
    {
        $request = curl_init($service_url);
        $headers = array(
            $contentType,
            "Authorization: $token",
            "Accept: application/json",
        );

        $data = array(
            'type' => $body['type'],
            'nbest' => array_key_exists('nbest', $body) ? $body['nbest'] : 5,
            'pos' => array_key_exists('pos', $body) ? $body['pos'] : 'false',
            'fromUserId' => $body['fromUserId'],
        );

        $contentType = '';

        if ($body->type == 'base64') {
            $contentType = "Content-Type: application/json";
            $data['data'] = $body->data;
            curl_setopt($request, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($request, CURLOPT_SAFE_UPLOAD, true);
            $data['file'] = new \CURLFile(realpath($body['filepath']));
            $post_body = $data;
            curl_setopt($request, CURLOPT_POSTFIELDS, $post_body);
        }

        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

        $curl_response = curl_exec($request);

        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            throw new Exception("Wrong Chatbot Response.");
        }

        return $this->purge(json_decode($curl_response, true));
    }

    /**
     * 聊天机器人核心接口，API参考
     * https://docs.chatopera.com/products/chatbot-platform/integration.html
     * @param $method HTTP 方法
     * @param $path URL 路径
     * @param $body HTTP Request Body
     * @return mixed
     */
    public function command($method, $path, $body = null)
    {
        $service_method = strtoupper($method);
        $service_path = '/api/v1/chatbot/' . $this->clientId . $path;

        if (strpos($service_path, '?')) {
            $service_path = $service_path . '&sdklang=php';
        } else {
            $service_path = $service_path . '?sdklang=php';
        }

        $service_url = $this->baseUrl . $service_path;

        $token = $this->generate($this->clientId, $this->clientSecret, $service_method, $service_path);

        if ($path == '/asr/recognize') {
            return $this->arsRecognize($service_url, $body, $token);
        }

        $request = curl_init($service_url);
        $headers = array(
            "Content-Type: application/json",
            "Authorization: $token",
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

    /**
     * 查看机器人详情
     * @return mixed
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function detail()
    {
        return $this->command('GET', '/');
    }

    /**
     * 检索多轮对话
     * @param $userId 用户唯一标识
     * @param $textMessage 问题
     * @return mixed
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function conversation($userId, $textMessage)
    {
        return $this->command('POST', '/conversation/query', array(
            "fromUserId" => $userId,
            "textMessage" => $textMessage,
            "isDebug" => false,
        ));
    }

    /**
     * 检索机器人知识库
     * @param $userId 用户唯一标识
     * @param $query  问题
     * @return mixed
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function faq($userId, $query)
    {
        return $this->command('POST', '/faq/query', array(
            "fromUserId" => $userId,
            "query" => $query,
        ));
    }

    /**
     * 查询用户列表
     * @param int $limit 每页数据条数
     * @param int $page 页面索引
     * @param string $sortby 排序规则
     * @return mixed
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function users($limit = 50, $page = 1, $sortby = "-lasttime")
    {
        return $this->command('GET', '/users?page=' . $page . '&limit=' . $limit . "&sortby=" . $sortby);
    }

    /**
     * 查看一个用户的聊天历史
     * @param $userId 用户唯一标识
     * @param int $limit 每页数据条数
     * @param int $page 页面索引
     * @param string $sortby 排序规则[-lasttime: 最后对话时间降序]
     * @return mixed
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function chats($userId, $limit = 50, $page = 1, $sortby = '-lasttime')
    {
        return $this->command('GET', '/users/' . $userId . '/chats?page=' . $page . '&limit=' . $limit . "&sortby=" . $sortby);
    }

    /**
     * 屏蔽用户
     * @param $userId 用户唯一标识
     * @return bool 执行是否成功
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function mute($userId)
    {
        return $this->command('POST', '/users/' . $userId . '/mute');
    }

    /**
     * 取消屏蔽用户
     * @param $userId 用户唯一标识
     * @return bool 执行是否成功
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function unmute($userId)
    {
        return $this->command('POST', '/users/' . $userId . '/unmute');
    }

    /**
     * 检测用户是否被屏蔽
     * @param $userId 用户唯一标识
     * @return bool 用户是否被屏蔽
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function ismute($userId)
    {
        return $this->command('POST', '/users/' . $userId . '/ismute');
    }

    /**
     * 读取用户画像
     * @param $userId 用户唯一标识
     * @return mixed
     * @throws Exception
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function user($userId)
    {
        return $this->command('POST', '/users/' . $userId . '/profile');
    }

    /**
     * 创建意图session
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function intentSession($uid, $channel)
    {
        return $this->command('POST', '/clause/prover/session', array(
            "uid" => $uid,
            "channel" => $channel,
        ));
    }

    /**
     * 获取意图session详情
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function intentSessionDetail($sessionId)
    {
        return $this->command('GET', '/clause/prover/session/' . $sessionId);
    }

    /**
     * 意图对话
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function intentChat($sessionId, $uid, $textMessage)
    {
        return $this->command('POST', '/clause/prover/chat', array(
            "fromUserId" => $uid,
            "session" => array(
                "id" => $sessionId,
            ),
            "message" => array(
                "textMessage" => $textMessage,
            ),
        ));
    }

    /**
     * 心理咨询聊天
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function psychChat($channel, $channelId, $userId, $textMessage)
    {
        return $this->command('POST', '/skills/psych/chat', array(
            "channel" => $channel,
            "channelId" => $channelId,
            "userId" => $userId,
            "textMessage" => $textMessage,
        ));
    }

    /**
     * 心理咨询查询
     * @deprecated DeprecationWarning: use `Chatbot#command` API instead, removed in 2020-10
     */
    public function psychSearch($query, $threshold = 0.2)
    {
        return $this->command('POST', '/skills/psych/search', array(
            "query" => $query,
            "threshold" => $threshold,
        ));
    }

    /**
     * 删除内部ID
     * @param $resp
     * @return mixed
     */
    private function purge($resp)
    {
        if (isset($resp["data"]) && is_array($resp["data"])) {
            foreach ($resp["data"] as $key => $value) {
                // data: sublist
                if (is_array($resp["data"][$key])) {
                    foreach ($resp["data"][$key] as $key2 => $value2) {
                        if ($key2 == "chatbotID") {
                            unset($resp["data"][$key][$key2]);
                        }

                    }
                } else { // data: plain object
                    if ($key == "chatbotID") {
                        unset($resp["data"][$key]);
                    }
                }
            }
        }
        return $resp;
    }
}

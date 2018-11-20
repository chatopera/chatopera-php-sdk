<?php
/*	My super power is talk.
 *	@Author: Hai Liang Wang
 *  @Company: 北京华夏春松科技有限公司
 *  All right reserved.
 **/

namespace chatopera\sdk;

function generate($appId, $secret, $method, $path)
{
    $timestamp = time();
    $random = rand(1000000000, 9999999999);
    $signature = hash_hmac('sha1', $appId.$timestamp.$random.$method.$path, $secret);
    $json =json_encode(array(
        'appId' => $appId,
        'timestamp' => $timestamp,
        'random' => $random,
        'signature' => $signature
    ));

    return base64_encode($json);
}

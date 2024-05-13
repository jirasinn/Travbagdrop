<?php
// Configuration
$wechatAppID = 'wx3cf0f39249eb0exxx';
$wechatAppSecret = 'f1c242f4f28f735d4687abb469072xxx';
$redirectUri = 'http://localhost/travbagdrop/Social-login/wechat-oauth.php';


$authUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize';
$params = array(
    'appid' => $wechatAppID,
    'redirect_uri' => $redirectUri,
    'response_type' => 'code',
    'scope' => 'snsapi_login',
    'state' => 'STATE',
);
$redirectUrl = $authUrl . '?' . http_build_query($params);
header('Location: ' . $redirectUrl);
exit;


if (isset($_GET['code'])) {
    $code = $_GET['code'];


    $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    $tokenParams = array(
        'appid' => $wechatAppID,
        'secret' => $wechatAppSecret,
        'code' => $code,
        'grant_type' => 'authorization_code',
    );
    $tokenResponse = file_get_contents($tokenUrl . '?' . http_build_query($tokenParams));
    $tokenData = json_decode($tokenResponse, true);


    $userInfoUrl = 'https://api.weixin.qq.com/sns/userinfo';
    $userInfoParams = array(
        'access_token' => $tokenData['access_token'],
        'openid' => $tokenData['openid'],
    );
    $userInfoResponse = file_get_contents($userInfoUrl . '?' . http_build_query($userInfoParams));
    $userInfoData = json_decode($userInfoResponse, true);
}

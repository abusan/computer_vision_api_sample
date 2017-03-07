<?php
/**
 * API設定
 */

/** APIリクエスト時のヘッダー */
$headers = array(
    "HTTP/1.1",
    'Content-Type:application/octet-stream',
    'Host:westus.api.cognitive.microsoft.com',
    'Ocp-Apim-Subscription-Key:{Your api key}'
);

/** APIリクエストパラメータ */
$parameter = array(
    'visualFeatures' => 'Categories,Tags,Description,Faces,ImageType,Color,Adult',
);

/** 対象とするファイルの拡張子 */
$extension_arr = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');

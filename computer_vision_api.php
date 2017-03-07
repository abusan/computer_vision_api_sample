<?php
include 'config.sample.php';

$image_directory = new DirectoryIterator('./image');
foreach ($image_directory as $file_info) {
    usleep(500000);

    if ($file_info->isDot() === false && $file_info->isFile() === true && in_array($file_info->getExtension(), $extension_arr, true) === true) {
        $image_file = $file_info->openFile('r');

        if (!$image_file) {
            echo 'ファイルが見つかりません'."\n";
            exit();
        } elseif($image_file->getSize() > 4000000) {
            echo 'ファイルサイズが制限を超えています。4MB以下にしてください。'."\n";
            exit();
        }

        $post_data = $image_file->fread($image_file->getSize());
        $curl=curl_init('https://westus.api.cognitive.microsoft.com/vision/v1.0/analyze?'.http_build_query($parameter));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $output= curl_exec($curl);

        $now_time = date('YmdHis');
        $result_json_file = new SplFileObject('./result/computer_vision_result_'.$now_time.'.json', 'w');
        $result_json_file->fwrite($output);

        $result_image_file = new SplFileObject('./result/computer_vision_result_'.$now_time.'.'.$image_file->getExtension(), 'w');
        $result_image_file->fwrite($post_data);

        echo '結果取得完了:'.$image_file->getFilename().' -> ./result/computer_vision_result_'.$now_time.'.json'."\n";

        // 処理が完了したファイルを削除
        unlink($image_file->getPathname());
        unset($image_file, $file_info);
    }
}
echo '全ての画像を処理しました。'."\n";

<?php
/**
 * download 僕の心のヤバイやつ (The Dangers in My Heart)
 * 僕の心のヤバイやつ』TVアニメ2023年4月放送決定記念！ コミックス1～6巻無料公開！【2022年12月07日まで】
 * ex)
 * php yaba.php
 */

// config
$viewer_pattern = 'https://mangacross.jp/comics/yabai/%s/viewer.json';
$save_path_pattern = './%s/%s.jpg';

// download volume 1 to 6
for($vol=1; $vol <= 6; $vol++) {
    if(file_exists($vol) === false) {
        mkdir($vol);
    }
    $viewer_path = sprintf($viewer_pattern, $vol);
    $json = file_get_contents($viewer_path);
    $viewer = json_decode($json);
    foreach($viewer->episode_pages as $page) {
        $jpg = file_get_contents($page->image->original_url);
        $path = sprintf($save_path_pattern, $vol, $page->order_index);
        file_put_contents($path, $jpg);
    }
    echo $path;
}

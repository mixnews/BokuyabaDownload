<?php
/**
 * download 僕の心のヤバイやつ (The Dangers in My Heart)
 * 僕の心のヤバイやつ』TVアニメ2023年4月放送決定記念！ コミックス1～6巻無料公開！【2022年12月07日まで】
 * エピソード1から順にダウンロードし、公開が終了しているエピソードが出現すると中断します。
 * ignore_episodesに追加することで該当エピソードをスキップして続行します。
 * ex)
 * php yaba.php
 */

// config
$viewer_pattern = 'https://mangacross.jp/comics/yabai/%s/viewer.json';
$save_path_pattern = './%s/%s.jpg';
$ignore_episodes = array(20, 21, 41, 50, 56); // ignore extra episode (not public)
for($i=91; $i<= 114; $i++) {
    $ignore_episodes[] = $i;
}
for($episode=117; $episode <= 300; $episode++) {
    if(in_array($episode, $ignore_episodes)) { continue; }
    $viewer_path = sprintf($viewer_pattern, $episode);
    $json = file_get_contents($viewer_path);
    $viewer = json_decode($json);
    if(isset($viewer->status) && $viewer->status == '404') { echo $episode.':viewer.json not found'; break; }
    $dir = str_replace('.', '', $viewer->volume);
    if(file_exists($dir) === false) {
        mkdir($dir);
    }
    foreach($viewer->episode_pages as $page) {
        $jpg = file_get_contents($page->image->original_url);
        $path = sprintf($save_path_pattern, $dir, $page->order_index);
        file_put_contents($path, $jpg);
    }
    echo $path;
}

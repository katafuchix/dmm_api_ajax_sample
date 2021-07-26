<?php


try {
  // 検索キーワード
  $word = $_REQUEST['word'];

  // tmpディレクトリに検索情報を保存
  $filename = __DIR__."/tmp/{$word}.txt";
  $timestamp1 = @filemtime($filename);
  $timestamp2 = time();
  $seconddiff = $timestamp2 - $timestamp1;

  // 3時間以内の検索ならキャッシュから返す
  if($seconddiff > 3 * 60 * 60){
    // 登録情報
    $api_id = "DMM API ID";
    $aff_id = "DMM Affiliate ID";
    $eword = urlencode($word);
    // APIのベース https://affiliate.dmm.com/api/v3/itemlist.html
    $api_url = "https://api.dmm.com/affiliate/v3/ItemList?api_id={$api_id}&affiliate_id={$aff_id}&keyword={$eword}&output=json"

    // 商品検索API アイドル動画
    $url = "{$api_url}&site=DMM.com&service=digital&floor=idol&hits=10&sort=rank";
    $text = @file_get_contents($url);
    $obj = json_decode($text,true);

    // 検索結果が 0件ならば写真集で検索
    if ( count($obj['result']['items']) == 0 ) {
      $url = "{$api_url}&site=DMM.com&service=ebook&floor=photo&hits=10&sort=date";
      $text = @file_get_contents($url);
    }

    // 検索結果が 0件ならば FANZAで検索
    $obj = json_decode($text,true);
    if ( count($obj['result']['items']) == 0 ) {
      $url = "{$api_url}}&site=FANZA&service=digital&floor=videoa&hits=10&sort=date";
      $text = @file_get_contents($url);
    }

    $fp = fopen($filename, "w"); //書き込みモードでファイルをオープン
    if (!(empty($fp))) {
      flock($fp, LOCK_EX);
      fputs($fp, $text); //データの書き出し
      flock($fp, LOCK_UN);
      fclose($fp);
    }
  }
  // 保存済みJSONファイルから
  else{
    $text = @file_get_contents($filename);
  }
  $content = "jsonpdmm({$text})";
  echo $content;

} catch (Exception $e) {
    echo '捕捉した例外: '.  $e->getMessage();
}

 ?>

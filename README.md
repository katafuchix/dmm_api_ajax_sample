# dmm_api_ajax_sample

- DMM 商品検索APIを利用してブログパーツ風に商品を表示します。
- アイドル動画検索　→ 写真集検索　→ FANZA検索　の３段階で検索します。
- 検索結果は３時間キャッシュします。
- ロリポップやSakuraなどのPHPが利用できるレンタルサーバーで動作確認済みです。
- [[RSS、XMLをAjax＋JSONPで表示するブログパーツを作成|https://codezine.jp/article/detail/5065]]

利用例

```
// JSONP
function jsonpdmm(data){
  var dmmHtml = "<table><tr>";
  for (i=0;i<data.result.items.length;i++) {
    var title = data.result.items[i].title;
    var affiliateURL = data.result.items[i].affiliateURL;

    // 写真集のJSONはサムネイルがないのでこうする
    try {
      var imageUrl = data.result.items[i].imageURL.small;
      dmmHtml += "<td><center><a href=\""+ affiliateURL + "\" target=\"_blank\"><img src=\"" + imageUrl + "\"><br>" + title + "</a></center></td>";
    } catch (error) {
      dmmHtml += "<td><center><a href=\""+ affiliateURL + "\" target=\"_blank\">" + title + "</a></center></td>";
    }
  }
  dmmHtml += "</tr></table>"
  jQuery("#dmm_ad").append(dmmHtml);
}

// API呼び出し
jQuery(function($){
    var script = $("<script>");
    script.attr("src", "/api.php?word=次原かな");
    $(document.body).append(script);
});
```

<img width="600" alt="スクリーンショット 2021-07-26 12 30 18" src="https://user-images.githubusercontent.com/6063541/126929801-e479df6b-7904-433c-827f-34f104136664.png">

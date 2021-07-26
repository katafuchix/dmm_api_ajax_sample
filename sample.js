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

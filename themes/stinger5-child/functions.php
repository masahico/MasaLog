<?php
/* WordPressのアイキャッチ画像をRSSリーダーに表示 */
/* http://netaone.com/wp/wordpress-feedreader/ */
function rss_post_thumbnail($content) {
global $post;
if(has_post_thumbnail($post->ID)) {
$content = '<p>' . get_the_post_thumbnail($post->ID) . '</p>' . $content;
}
return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

//サイトドメインを取得
function get_this_site_domain(){
  //ドメイン情報を$results[1]に取得する
  preg_match( '/https?:\/\/(.+?)\//i', admin_url(), $results );
  return $results[1];
}

//本文抜粋を取得する関数（綺麗な抜粋文を作成するため）
//使用方法：http://nelog.jp/get_the_custom_excerpt
function get_the_custom_excerpt($content, $length) {
  $length = ($length ? $length : 70);//デフォルトの長さを指定する
  $content =  preg_replace('/<!--more-->.+/is',"",$content); //moreタグ以降削除
  $content =  strip_shortcodes($content);//ショートコード削除
  $content =  strip_tags($content);//タグの除去
  $content =  str_replace("&nbsp;","",$content);//特殊文字の削除（今回はスペースのみ）
  $content =  mb_substr($content,0,$length);//文字列を指定した長さで切り取る
  return $content;
}

//本文中のURLをブログカードタグに変更する
function url_to_blog_card($the_content) {
  if ( is_singular() ) {//投稿ページもしくは固定ページのとき
    //1行にURLのみが期待されている行（URL）を全て$mに取得
    $res = preg_match_all('/^(<p>)?(<a.+?>)?https?:\/\/'.preg_quote(get_this_site_domain()).'\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(<\/p>)?(<br ? \/>)?$/im', $the_content,$m);
    //マッチしたURL一つ一つをループしてカードを作成
    foreach ($m[0] as $match) {
      $url = strip_tags($match);//URL
      $id = url_to_postid( $url );//IDを取得（URLから投稿ID変換）
      if ( !$id ) continue;//IDを取得できない場合はループを飛ばす
      $post = get_post($id);//IDから投稿情報の取得
      $title = $post->post_title;//タイトルの取得
      $date = mysql2date('Y-m-d H:i', $post->post_date);//投稿日の取得
      $excerpt = get_the_custom_excerpt($post->post_content, 90);//抜粋の取得
      $thumbnail = get_the_post_thumbnail($id, 'thumb100', array('style' => 'width:100px;height:100px;', 'class' => 'blog-card-thumb-image'));//サムネイルの取得（要100×100のサムネイル設定）
      if ( !$thumbnail ) {//サムネイルが存在しない場合
        $thumbnail = '<img src="'.get_template_directory_uri().'/images/no-image.png" style="width:100px;height:100px;" />';
      }
      //取得した情報からブログカードのHTMLタグを作成
      $tag = '<div class="blog-card"><div class="blog-card-thumbnail"><a href="'.$url.'" class="blog-card-thumbnail-link">'.$thumbnail.'</a></div><div class="blog-card-content"><div class="blog-card-title"><a href="'.$url.'" class="blog-card-title-link">'.$title.'</a></div><div class="blog-card-excerpt">'.$excerpt.'</div></div><div class="blog-card-footer clear"><span class="blog-card-date">'.$date.'</span></div></div>';
      //本文中のURLをブログカードタグで置換
      $the_content = preg_replace('{'.preg_quote($match).'}', $tag , $the_content, 1);
    }
  }
  return $the_content;//置換後のコンテンツを返す
}
add_filter('the_content','url_to_blog_card');//本文表示をフック
?>
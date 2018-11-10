<?php //子テーマ用関数

//親skins の取得有無の設定
function include_parent_skins(){
  return true; //親skinsを含める場合はtrue、含めない場合はfalse
}

//子テーマ用のビジュアルエディタースタイルを適用
add_editor_style();

//以下にSimplicity子テーマ用の関数を書く

// フィードにコンテンツを追加
function do_post_contents_feeds($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '<div>' .get_the_post_thumbnail($post->ID). '</div>' .$content. '<div><a href="' .get_permalink($post->ID).'" target="_blank">この記事の続きを読む</a></div><div><a href="' .get_permalink($post->ID). '" target="_blank">' .get_the_title($post->ID). '</a> は <a href="https://masalog.net/">MasaLog</a> の記事です</div>';
    }
    return $content;
}
add_filter('the_excerpt_rss', 'do_post_contents_feeds');
add_filter('the_content_feed', 'do_post_contents_feeds');

// WordPressの一覧に表示する記事数をPCとスマホで変える
// https://worklog.be/archives/3129
function mobile_pre_get_posts( $query ) {
    if ( ! is_admin() && is_mobile() && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 10 );
    }
}
add_action( 'pre_get_posts', 'mobile_pre_get_posts' );

// For AMP plugin
// https://www.imamura.biz/blog/25576
add_filter( 'amp_post_template_analytics', 'xyz_amp_add_custom_analytics' );
function xyz_amp_add_custom_analytics( $analytics ) {
    if ( ! is_array( $analytics ) ) {
        $analytics = array();
    }

    // https://developers.google.com/analytics/devguides/collection/amp-analytics/
    $analytics['xyz-googleanalytics'] = array(
        'type' => 'googleanalytics',
        'attributes' => array(
            // 'data-credentials' => 'include',
        ),
        'config_data' => array(
            'vars' => array(
                'account' => "UA-36243978-1"
            ),
            'triggers' => array(
                'trackPageview' => array(
                    'on' => 'visible',
                    'request' => 'pageview',
                ),
            ),
        ),
    );

    return $analytics;
}

//WordPress 4.4 で追加された Embed を無効化
//remove_action('wp_head','rest_output_link_wp_head');
//remove_action('wp_head','wp_oembed_add_discovery_links');
//remove_action('wp_head','wp_oembed_add_host_js');
//remove_action('template_redirect', 'rest_output_link_header', 11 );
// 2.2.0dにアップデート後削除が必要
//remove_filter( 'pre_oembed_result',  'wp_filter_pre_oembed_result');


//最後のh2見出し手前にアドセンスを表示（スマホのみ）
function add_ad_before_h2_for_2times($the_content) {
//最初に表示させるアドセンス
$ad1 = <<< EOF
<div class=" ad-space">
 <div class="ad-label">スポンサーリンク</div>

 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 本文中 336x280 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="5478691504"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<div class="clear"></div>
</div>
EOF;

$ad2 = <<< EOF
<div class=" ad-space">
          <div class="ad-label">スポンサーリンク</div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- モバイル 本文中1 336x280 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="9033623740"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<div class="clear"></div>
</div>
EOF;

//最後に表示させるアドセンス
$ad3 = <<< EOF
<div class=" ad-space">
 <div class="ad-label">スポンサーリンク</div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 本文中(2) 336x280 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="2131884305"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<div class="clear"></div>
</div>
EOF;

$ad4 = <<< EOF
<div class=" ad-space">
          <div class="ad-label">スポンサーリンク</div>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="8845921480"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>          

<div class="ad-responsive ad-mobile adsense-300">
<!-- モバイル終了直前 (戻す場合はここ)-->
</div>
</div>
EOF;

// amp用広告
$ad5 = <<< EOF
<div class=" ad-space">
<div class="ad-label">スポンサーリンク</div>
<amp-ad width="300" height="250" type="adsense" data-ad-client="ca-pub-2684783162843499" data-ad-slot="5454040614"></amp-ad>
</div>
EOF;

if ( is_single() && is_ads_visible() ) {//投稿ページ かつ 広告表示がオンのとき
	 $h2 = '/^<h2.*?>.+?<\/h2>$/im';//H2見出しのパターン
	 if ( preg_match_all( $h2, $the_content, $h2s )) {//H2見出しが本文中にあるかどうか
	 	if ( $h2s[0] ) {//チェックは不要と思うけど一応
 			if ( $h2s[0][0] ) {//1番目のH2見出し手前に広告を挿入
                if (is_mobile()){ //スマホ表示
                     if(!is_amp()){
                        $ad = $ad2;
                     }else{
                        $ad = $ad5;
                     }
                }else{  // PC表示
                    $ad = $ad1;
                }
                $the_content  = str_replace($h2s[0][0], $ad.$h2s[0][0], $the_content);
            }
            if ( $h2s[0][1] ) {////H2が2個以上なら最後のH2見出し手前にad2を挿入
    	 		if (is_mobile()){//スマホ表示
                     if(!is_amp()){
                        $ad = $ad4;
                     }else{
                        $ad = $ad5;
                     }
                }else{  // PC表示
                    $ad = $ad3;
                }
                $the_content  = str_replace($h2s[0][count($h2s[0]) - 1], $ad.$h2s[0][count($h2s[0]) - 1], $the_content);
            }
        }
    }
}
return $the_content;
}
add_filter('the_content','add_ad_before_h2_for_2times');


// Simplicityのスマホ判定をW3 Total Cacheの判定に合わせる
//if (function_exists('w3_instance')) {
//  function is_mobile() {
//    $w3_mobile = w3_instance('W3_Mobile');
//    $group = $w3_mobile->get_group();
//    return "high" === $group || "low" === $group;
//  }
//}

if (function_exists('w3_instance')) {
  function is_mobile()    {
    $cache = w3_instance('W3_PgCache');
    $group = $cache->_mobile->get_group();
    return "high" === $group || "low" === $group;
  }
}

// はてなタグ入れる
// http://www.wakatta-blog.com/hatenabookmark-wordpress.html
function hatena(){ ?>
<!--
<rdf:RDF
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:foaf="http://xmlns.com/foaf/0.1/">
<rdf:Description rdf:about="<?php echo esc_url( home_url() . $_SERVER['REQUEST_URI'] ); ?>">
<foaf:maker rdf:parseType="Resource">
<foaf:holdsAccount>
<foaf:OnlineAccount foaf:accountName="masa730">
<foaf:accountServiceHomepage rdf:resource="http://www.hatena.ne.jp/" />
</foaf:OnlineAccount>
</foaf:holdsAccount>
</foaf:maker>
</rdf:Description>
</rdf:RDF>
-->
<?php }
add_action( 'wp_head', 'hatena' );

//コンテンツ内の非SSL URLを表示前にSSL化する
function chagne_site_url_html_to_https_plus($the_content){

  //置換条件
  //iTunesの画像リンク変更
  $search  = '{http://is(\d+).mzstatic.com}';
  $replace = "https://is$1-ssl.mzstatic.com";
  $the_content = preg_replace($search, $replace, $the_content);

  // //のSSL化
  // $search  = '';
  // $replace = '';
  // $the_content = str_replace($search, $replace, $the_content);

  return $the_content;
}
add_filter('the_content', 'chagne_site_url_html_to_https_plus', 1);

// CSS更新反映のためのバージョンチェック用関数
function getCssVersion($fileName, $isChild=true) {
  $directory = ($isChild)
    ? get_stylesheet_directory()
    : get_template_directory() ;
  $filePath  = "{$directory}/{$fileName}";
  return file_exists($filePath) ? filemtime($filePath) : 0 ;
}

//タグクラウドの出力変更
function wp_tag_cloud_custom_ex( $output ) {
  //style属性を取り除く
  $output = preg_replace( '/\s*?style="[^"]+?"/i', '',  $output);
  //カッコを取り除く
  $output = str_replace( ' (', '',  $output);
  $output = str_replace( ')', '',  $output);
  return $output;
}
add_filter( 'wp_tag_cloud', 'wp_tag_cloud_custom_ex');

// タグクラウドの最大表示数を変更
function my_tag_cloud_number_filter($args) {
	$myargs = array(
		'number' => 300,
	);
	$args = wp_parse_args($args, $myargs);
	return $args;
}
add_filter('widget_tag_cloud_args', 'my_tag_cloud_number_filter');

// WordPressの文字自動変換（例：「"」が「“」になる）を停止する
remove_filter('the_title', 'wptexturize');
remove_filter('the_content', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');

//CSS、JSファイルに編集時間をバージョンとして付加する（ファイル編集後のブラウザキャッシュ対策）
add_filter( 'style_loader_src', 'add_file_ver_to_css_js_demo');
add_filter( 'script_loader_src', 'add_file_ver_to_css_js_demo');
if ( !function_exists( 'add_file_ver_to_css_js_demo' ) ):
function add_file_ver_to_css_js_demo( $src ) {
  //サーバー内のファイルの場合
  if (strpos( $src, site_url() ) !== false) {
    // //Wordpressのバージョンを除去する場合
    // if ( strpos( $src, 'ver=' ) )
    //   $src = remove_query_arg( 'ver', $src );

    //クエリーを削除したファイルURLを取得
    $removed_src = preg_replace('{\?.+$}i', '', $src);
    //URLをパスに変換
    $resource_file = str_replace(site_url('/'), ABSPATH, $removed_src );
    //ファイルの編集時間バージョンを追加
    $src = add_query_arg( 'fver', date('Ymdhis', filemtime($resource_file)), $src );
  }
  return $src;
}
endif;

?>

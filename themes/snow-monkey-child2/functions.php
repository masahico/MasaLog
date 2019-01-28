<?php

// スタイルシート、Font Awesome読み込み
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style(
		get_stylesheet(),
		get_stylesheet_uri(),
		[ get_template() ]
	);

    wp_enqueue_style(
        'fontawesome5',
        'https://masalog.net/wp-includes/fontawesome/css/fontawesome-all.min.css'
//        'https://use.fontawesome.com/releases/v5.0.10/css/all.css'
    );
} );

// 外部スタイルシート読み込み (タベレバ)
function load_import_css() {
    wp_enqueue_style( "tabereba_responsive", get_stylesheet_directory_uri()."/tabereba-responsive.css", false );
    wp_enqueue_style( "kaereba_yomereba_responsive", get_stylesheet_directory_uri()."/yomereba-kaereba-responsive.css", false );

}
add_action('wp_enqueue_scripts', 'load_import_css');

// WordPressのダブルクォーテーションの自動変換を止める
remove_filter('the_content', 'wptexturize'); 
remove_filter('the_excerpt', 'wptexturize'); 
remove_filter('the_title', 'wptexturize');


//スマホ表示分岐
function is_mobile(){
  $useragents = array(
    'iPhone', // iPhone
    'iPod', // iPod touch
    'Android.*Mobile', // 1.5+ Android *** Only mobile
    'Windows.*Phone', // *** Windows Phone
    'dream', // Pre 1.5 Android
    'CUPCAKE', // 1.5+ Android
    'blackberry9500', // Storm
    'blackberry9530', // Storm
    'blackberry9520', // Storm v2
    'blackberry9550', // Storm v2
    'blackberry9800', // Torch
    'webOS', // Palm Pre Experimental
    'incognito', // Other iPhone browser
    'webmate' ,// Other iPhone browser
    'Mobile.*Firefox', // Firefox OS
    'Opera Mini', // Opera Mini Browser
    'BB10', // BlackBerry 10
	);
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

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
<div class="ad-responsive ad-mobile adsense-300">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- モバイル 本文中1 336x280 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="9033623740"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
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

if ( is_single() ) {//投稿ページ かつ 広告表示がオンのとき
	 $h2 = '/^<h2.*?>.+?<\/h2>$/im';//H2見出しのパターン
	 if ( preg_match_all( $h2, $the_content, $h2s )) {//H2見出しが本文中にあるかどうか
	 	if ( $h2s[0] ) {//チェックは不要と思うけど一応
 			if ( $h2s[0][0] ) {//1番目のH2見出し手前に広告を挿入
    	 		if (is_mobile()){//スマホ表示
                    $ad = $ad2;
                }else{  // PC表示
                    $ad = $ad1;
                }
                $the_content  = str_replace($h2s[0][0], $ad.$h2s[0][0], $the_content);
            }
            if ( $h2s[0][1] ) {////H2が2個以上なら最後のH2見出し手前にad2を挿入
    	 		if (is_mobile()){//スマホ表示
                    $ad = $ad4;
                }else{  // PC表示
                    $ad = $ad1;
                }
                $the_content  = str_replace($h2s[0][count($h2s[0]) - 1], $ad.$h2s[0][count($h2s[0]) - 1], $the_content);
            }
        }
    }
}
return $the_content;
}
add_filter('the_content','add_ad_before_h2_for_2times');

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

// 目次は自動表示
add_filter( 'snow_monkey_display_contents_outline', '__return_true' );

// 目次の上にリンクユニットを表示
add_action( 'inc2734_wp_contents_outline_before', function( $attributes ) {
if ( ! isset( $attributes['move_to_before_1st_heading'] ) || 'true' !== $attributes['move_to_before_1st_heading'] ) {
return;
}
?>
<style>
.wpco-wrapper {
display: block !important;
}
.wpco-wrapper .wpco {
visibility: hidden;
}
.wpco-wrapper[aria-hidden="false"] .wpco {
visibility: visible;
}
</style>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- リンクユニット(レスポンシブ) -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="3503421852"
     data-ad-format="link"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php
} );

// タイトル下にタグの一覧を表示
add_action( 'snow_monkey_entry_meta_items', function() {
    $tags = get_the_terms( get_the_ID(), 'post_tag' );
    if ( ! $tags ) {
        return;
    }
    ?>
    <li class="c-meta__item c-meta__item--tags">
        <span class="screen-reader-text">タグ</span>
        <?php foreach ( $tags as $tag ) : ?>
            <a href="<?php echo esc_url( get_term_link( $tag ) ); ?>">
                <i class="fa fa-tag" aria-hidden="true"></i> <?php echo esc_html( $tag->name ); ?>
            </a>
        <?php endforeach; ?>
    </li>
    <?php
}, 50 );

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

// WordPress記事を修正した時に更新日を変更するかしないかを選択できるようにする
// https://nelog.jp/update-level-custom
//管理画面が開いたときに実行
add_action( 'admin_menu', 'add_update_level_custom_box' );
//更新ボタンが押されたときに実行
add_action( 'save_post', 'save_custom_field_postdata' );

//カスタムフィールドを投稿画面に追加
function add_update_level_custom_box() {
  //ページ編集画面にカスタムメタボックスを追加
  add_meta_box( 'update_level', '更新日の変更', 'html_update_level_custom_box', 'post', 'side', 'high' );
}

//投稿画面に表示するフォームのHTMLソース
function html_update_level_custom_box() {
    $post = isset($_GET['post']) ? $_GET['post'] :null;
  $update_level = get_post_meta( $post, 'update_level' );

  $level = $update_level ? $update_level[0] : null;
  echo '<div style="padding-top: 3px; overflow: hidden;">';
  echo '<div style="width: 100px; float: left;"><input name="update_level" type="radio" value="high" ';
  if( $level=="" || $level=="high" ) echo ' checked="checked"';
  echo ' />更新する</div><div><input name="update_level" type="radio" value="low" ';
  if( $level=="low" ) echo ' checked="checked"';
  echo '/>更新しない<br /></div>';
  echo '<p class="howto" style="margin-top:1em;">更新日時を変更するかどうかを設定します。誤字修正などで更新日を変更したくない場合は「変更しない」にチェックを入れてください。</p>';
  echo '</div>';
}

//設定したカスタムフィールドの値をDBに書き込む記述
function save_custom_field_postdata( $post_id ) {
  $mydata = isset($_POST['update_level']) ? $_POST['update_level'] : null;
  if( "" == get_post_meta( $post_id, 'update_level' )) {
    /* update_levelというキーでデータが保存されていなかった場合、新しく保存 */
    add_post_meta( $post_id, 'update_level', $mydata, true ) ;
  } elseif( $mydata != get_post_meta( $post_id, 'update_level' )) {
    /* update_levelというキーのデータと、現在のデータが不一致の場合、更新 */
    update_post_meta( $post_id, 'update_level', $mydata ) ;
  } elseif( "" == $mydata ) {
    /* 現在のデータが無い場合、update_levelというキーの値を削除 */
    delete_post_meta( $post_id, 'update_level' ) ;
  }
}

//「更新」以外は更新日時を変更しない
add_filter( 'wp_insert_post_data', 'my_insert_post_data', 10, 2 );
function my_insert_post_data( $data, $postarr ){
  $mydata = isset($_POST['update_level']) ? $_POST['update_level'] : null;
    if( $mydata == "low" ){
        unset( $data["post_modified"] );
        unset( $data["post_modified_gmt"] );
    }
    return $data;
}

// reCAPTCHAを使っているページだけロゴを表示する
// contact form7関連のコードも読まない
// https://moriawase.net/contact-form-7-recaptcha-logo
add_action( 'wp_enqueue_scripts', function() {
	if(is_page('contact')) return;
    wp_dequeue_style( 'contact-form-7' );
    wp_deregister_script( 'contact-form-7' );
    wp_deregister_script( 'google-recaptcha' );
});

// タグクラウドの最大表示数を変更 ('number' => 0で上限無し)
function my_tag_cloud_number_filter($args) {
	$myargs = array(
		'number' => 200,
	);
	$args = wp_parse_args($args, $myargs);
	return $args;
}
add_filter('widget_tag_cloud_args', 'my_tag_cloud_number_filter');

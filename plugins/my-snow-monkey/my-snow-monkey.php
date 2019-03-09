<?php
/**
 * Plugin name: My Snow Monkey
 * Description: このプラグインに、あなたの Snow Monkey 用カスタマイズコードを書いてください。
 * Version: 0.1.0
 *
 * @package my-snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 */
/**
 * Snow Monkey 以外のテーマを利用している場合は有効化してもカスタマイズが反映されないようにする
 */
$theme = wp_get_theme();
if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
	return;
}

/******************************/
/* 外部スタイルシート読み込み */
/******************************/
function load_import_css() {

/* style.cssの代わり */
    wp_enqueue_style( "my_style", content_url()."/my-css/my-style.css", array(), '1.0.1' );

    wp_enqueue_style( "kaereba_yomereba_responsive", content_url()."/my-css/yomereba-kaereba-responsive.css", array(), '1.0.2' );

    wp_enqueue_style( "tabereba_responsive", content_url()."/my-css/tabereba-responsive.css",array(),'1.0.0');

}
add_action('wp_enqueue_scripts', 'load_import_css');

/******************************/
/* Font Awesome読み込み       */
/******************************/
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'fontawesome5',
        'https://masalog.net/wp-includes/fontawesome/css/fontawesome-all.min.css'
    );
} );


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

// reCAPTCHAを使っているページだけロゴを表示する
// contact form7関連のコードも読まない
// https://moriawase.net/contact-form-7-recaptcha-logo
add_action(
    'after_setup_theme',
    function() {
        add_action( 'wp_enqueue_scripts', function() {
        	if(is_page('contact')) return;
            wp_dequeue_style( 'contact-form-7' );
            wp_deregister_script( 'contact-form-7' );
            wp_deregister_script( 'google-recaptcha' );
        });
    }
);

// タグクラウドの最大表示数を変更 ('number' => 0で上限無し)
function my_tag_cloud_number_filter($args) {
	$myargs = array(
		'number' => 200,
	);
	$args = wp_parse_args($args, $myargs);
	return $args;
}
add_filter('widget_tag_cloud_args', 'my_tag_cloud_number_filter');
?><?php
//---------------------------------------------------------------------------
// 記事投稿(編集)画面に更新レベルのボックス追加
//---------------------------------------------------------------------------

/* ボックス追加 */
if( function_exists( 'thk_post_update_level' ) === false ):
function thk_post_update_level() {
	add_meta_box( 'update_level', '更新方法', 'post_update_level_box', 'post', 'side', 'default' );
	add_meta_box( 'update_level', '更新方法', 'post_update_level_box', 'page', 'side', 'default' );
}
add_action( 'admin_menu', 'thk_post_update_level' );
endif;

/* メインフォーム */
if( function_exists( 'post_update_level_box' ) === false ):
function post_update_level_box() {
	global $post;
?>
<div style="padding-top: 5px; overflow: hidden;">
<div style="padding:5px 0"><input name="update_level" type="radio" value="high" checked="checked" />通常更新</div>
<div style="padding: 5px 0"><input name="update_level" type="radio" value="low" />修正のみ(更新日時を変更せず記事更新)</div>
<div style="padding: 5px 0"><input name="update_level" type="radio" value="del" />更新日時消去(公開日時と同じにする)</div>
<div style="padding: 5px 0; margin-bottom: 10px"><input id="update_level_edit" name="update_level" type="radio" value="edit" />更新日時を手動で変更</div>
<?php
	if( get_the_modified_date( 'c' ) ) {
		$stamp = '更新日時: <span style="font-weight:bold">' . get_the_modified_date( __( 'M j, Y @ H:i' ) ) . '</span>';
	}
	else {
		$stamp = '更新日時: <span style="font-weight:bold">未更新</span>';
	}
	$date = date_i18n( get_option('date_format') . ' @ ' . get_option('time_format'), strtotime( $post->post_modified ) );
?>
<style>
.modtime { padding: 2px 0 1px 0; display: inline !important; height: auto !important; }
.modtime:before { font: normal 20px/1 'dashicons'; content: '\f145'; color: #888; padding: 0 5px 0 0; top: -1px; left: -1px; position: relative; vertical-align: top; }
#timestamp_mod_div { padding-top: 5px; line-height: 23px; }
#timestamp_mod_div p { margin: 8px 0 6px; }
#timestamp_mod_div input { border-width: 1px; border-style: solid; }
#timestamp_mod_div select { height: 21px; line-height: 14px; padding: 0; vertical-align: top;font-size: 12px; }
#aa_mod, #jj_mod, #hh_mod, #mn_mod { padding: 1px; font-size: 12px; }
#jj_mod, #hh_mod, #mn_mod { width: 2em; }
#aa_mod { width: 3.4em; }
</style>
<span class="modtime"><?php printf( $stamp, $date ); ?></span>
<div id="timestamp_mod_div" onkeydown="document.getElementById('update_level_edit').checked=true" onclick="document.getElementById('update_level_edit').checked=true">
<?php thk_time_mod_form(); ?>
</div>
</div>
<?php
}
endif;

/* 更新日時変更の入力フォーム */
if( function_exists( 'thk_time_mod_form' ) === false ):
function thk_time_mod_form() {
	global $wp_locale, $post;

	$tab_index = 0;
	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 ) {
		$tab_index_attribute = ' tabindex="' . $tab_index . '"';
	}

	$jj_mod = mysql2date( 'd', $post->post_modified, false );
	$mm_mod = mysql2date( 'm', $post->post_modified, false );
	$aa_mod = mysql2date( 'Y', $post->post_modified, false );
	$hh_mod = mysql2date( 'H', $post->post_modified, false );
	$mn_mod = mysql2date( 'i', $post->post_modified, false );
	$ss_mod = mysql2date( 's', $post->post_modified, false );

	$year = '<label for="aa_mod" class="screen-reader-text">年' .
		'</label><input type="text" id="aa_mod" name="aa_mod" value="' .
		$aa_mod . '" size="4" maxlength="4"' . $tab_index_attribute . ' autocomplete="off" />年';

	$month = '<label for="mm_mod" class="screen-reader-text">月' .
		'</label><select id="mm_mod" name="mm_mod"' . $tab_index_attribute . ">\n";
	for( $i = 1; $i < 13; $i = $i +1 ) {
		$monthnum = zeroise($i, 2);
		$month .= "\t\t\t" . '<option value="' . $monthnum . '" ' . selected( $monthnum, $mm_mod, false ) . '>';
		$month .= $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
		$month .= "</option>\n";
	}
	$month .= '</select>';

	$day = '<label for="jj_mod" class="screen-reader-text">日' .
		'</label><input type="text" id="jj_mod" name="jj_mod" value="' .
		$jj_mod . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />日';
	$hour = '<label for="hh_mod" class="screen-reader-text">時' .
		'</label><input type="text" id="hh_mod" name="hh_mod" value="' . $hh_mod .
		'" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
	$minute = '<label for="mn_mod" class="screen-reader-text">分' .
		'</label><input type="text" id="mn_mod" name="mn_mod" value="' . $mn_mod .
		'" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';

	printf( '%1$s %2$s %3$s @ %4$s : %5$s', $year, $month, $day, $hour, $minute );
	echo '<input type="hidden" id="ss_mod" name="ss_mod" value="' . $ss_mod . '" />';
}
endif;

/* 「修正のみ」は更新しない。それ以外は、それぞれの更新日時に変更する */
if( function_exists( 'thk_insert_post_data' ) === false ):
function thk_insert_post_data( $data, $postarr ){
	$mydata = isset( $_POST['update_level'] ) ? $_POST['update_level'] : null;

	if( $mydata === 'low' ){
		unset( $data['post_modified'] );
		unset( $data['post_modified_gmt'] );
	}
	elseif( $mydata === 'edit' ) {
		$aa_mod = $_POST['aa_mod'] <= 0 ? date('Y') : $_POST['aa_mod'];
		$mm_mod = $_POST['mm_mod'] <= 0 ? date('n') : $_POST['mm_mod'];
		$jj_mod = $_POST['jj_mod'] > 31 ? 31 : $_POST['jj_mod'];
		$jj_mod = $jj_mod <= 0 ? date('j') : $jj_mod;
		$hh_mod = $_POST['hh_mod'] > 23 ? $_POST['hh_mod'] -24 : $_POST['hh_mod'];
		$mn_mod = $_POST['mn_mod'] > 59 ? $_POST['mn_mod'] -60 : $_POST['mn_mod'];
		$ss_mod = $_POST['ss_mod'] > 59 ? $_POST['ss_mod'] -60 : $_POST['ss_mod'];
		$modified_date = sprintf( '%04d-%02d-%02d %02d:%02d:%02d', $aa_mod, $mm_mod, $jj_mod, $hh_mod, $mn_mod, $ss_mod );
		if ( ! wp_checkdate( $mm_mod, $jj_mod, $aa_mod, $modified_date ) ) {
			unset( $data['post_modified'] );
			unset( $data['post_modified_gmt'] );
			return $data;
		}
		$data['post_modified'] = $modified_date;
		$data['post_modified_gmt'] = get_gmt_from_date( $modified_date );
	}
	elseif( $mydata === 'del' ) {
		$data['post_modified'] = $data['post_date'];
	}
	return $data;
}
add_filter( 'wp_insert_post_data', 'thk_insert_post_data', 10, 2 );
endif;

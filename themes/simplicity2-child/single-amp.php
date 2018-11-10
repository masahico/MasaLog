<!DOCTYPE html>
<html amp>
<head>
<meta charset="utf-8">
<link rel="canonical" href="<?php the_permalink() ?>" />
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<?php get_template_part('header-title-tag'); ?>
<?php if ( is_facebook_ogp_enable() ) //Facebook OGPタグ挿入がオンのとき
get_template_part('header-ogp');//Facebook OGP用のタグテンプレート?>
<?php if ( is_twitter_cards_enable() ) //Twitterカードタグ挿入がオンのとき
get_template_part('header-twitter-card');//Twitterカード用のタグテンプレート?>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<?php
//広告（AdSense）タグを記入
ob_start();//バッファリング
get_template_part('ad-amp');//広告貼り付け用に作成したテンプレート
$ad_template = ob_get_clean();
while(have_posts()): the_post();
  //$the_content = convert_content_for_amp(get_the_content()).$ad_template;
  //以下の処理はthe_contentで取得しないとプラグインやフックなどの処理後のHTMLが取得できなかったので（get_the_contentではダメだった）
  ob_start();//バッファリング
  the_content();//広告貼り付け用に作成したテンプレート
  $the_content = ob_get_clean();
  $the_content = $the_content.$ad_template;
endwhile;
$elements = array(
  'amp-analytics' => 'amp-analytics-0.1.js',
  'amp-facebook' => 'amp-facebook-0.1.js',
  'amp-youtube' => 'amp-youtube-0.1.js',
  'amp-vine' => 'amp-vine-0.1.js',
  'amp-twitter' => 'amp-twitter-0.1.js',
  'amp-instagram' => 'amp-instagram-0.1.js',
  'amp-social-share' => 'amp-social-share-0.1.js',
  'amp-ad' => 'amp-ad-0.1.js',
  'amp-iframe' => 'amp-iframe-0.1.js',
);
//var_dump($the_content);
foreach( $elements as $key => $val ) {
  if( strpos($the_content, '<'.$key) !== false ) {
    echo '<script async custom-element="'.$key.'" src="https://cdn.ampproject.org/v0/'.$val.'"></script>'.PHP_EOL;

  }
}
 ?>
<?php //JSON-LDの読み込み
get_template_part('json-ld'); ?>
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<style amp-custom>
<?php
if ( WP_Filesystem() ) {//WP_Filesystemの初期化
  global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
  $css_all = '';
  //AMPスタイルの取得
  $css_file = get_template_directory().'/amp.css';
  if ( file_exists($css_file) ) {
    $css = $wp_filesystem->get_contents($css_file);//ファイルの読み込み
    $css_all .= $css;
  }

  //文字装飾スタイルの取得
  $css_file = get_template_directory().'/css/extension.css';
  if ( file_exists($css_file) ) {
    $css = $wp_filesystem->get_contents($css_file);//ファイルの読み込み
    $css_all .= $css;
  }

  ///////////////////////////////////////////
  //スキンのスタイル
  ///////////////////////////////////////////
  if ( get_skin_file() ) {//設定されたスキンがある場合
    if ( get_pearts_base_skin() ) {//パーツスキンの場合
      $parts_skin_file = url_to_local(get_parts_skin_file_uri());
      if (file_exists($parts_skin_file)) {
        $parts_skin_css = $wp_filesystem->get_contents($parts_skin_file);//ファイルの読み込み
        $css_all .= $parts_skin_css;
      }
    }
  } else {
    //通常のスキンスタイル
    $skin_file = url_to_local(get_skin_file());
    $amp_css_file = str_replace('style.css', 'amp.css', $skin_file);
    if (file_exists($amp_css_file)) {
      $amp_css = $wp_filesystem->get_contents($amp_css_file);//ファイルの読み込み
      $css_all .= $amp_css;
    }
  }

  ///////////////////////////////////////////
  //カスタマイザーのスタイル
  ///////////////////////////////////////////
  ob_start();//バッファリング
  get_template_part('css-custom');//カスタムテンプレートの呼び出し
  $css_custom = ob_get_clean();
  $css_all .= $css_custom;

  ///////////////////////////////////////////
  //子テーマのスタイル
  ///////////////////////////////////////////
  if ( get_template_directory_uri() != get_stylesheet_directory_uri() ) {
    $css_file_child = get_stylesheet_directory().'/amp.css';
    if ( file_exists($css_file_child) ) {
      $css_child = $wp_filesystem->get_contents($css_file_child);//ファイルの読み込み
      $css_all .= $css_child;
    }
  }

  //CSSの縮小化
  $css_all = minify_css($css_all);

  //全てのCSSの出力
  echo $css_all;
}?>
</style>
<!-- AMP Analytics --><script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
</head>
<body <?php body_class('amp'); ?> itemscope itemtype="http://schema.org/WebPage">
<!-- Google Tag Manager -->
<amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-KLJGBS2&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
<?php //Google Analyticsコード（ログインユーザーはカウントしない）
if ( !is_user_logged_in() && get_tracking_id() ): ?>
<amp-pixel src="//ssl.google-analytics.com/collect?v=1&amp;tid=<?php echo get_tracking_id() ?>&amp;t=pageview&amp;cid=<?php echo mt_rand(0, 99999999); ?>&amp;dt=<?php the_title() ?>【AMP】&amp;dl=<?php echo get_amp_permalink() ?>&amp;z=<?php echo mt_rand(0, 99999999); ?>"></amp-pixel>
<?php endif ?>
  <div id="container">
    <!-- header -->
    <header itemscope itemtype="http://schema.org/WPHeader">
      <div id="header" class="clearfix">
        <div id="header-in">
          <div id="h-top">

            <div class="alignleft top-title-catchphrase">
              <p id="site-title" itemscope itemtype="http://schema.org/Organization">
                <?php
                $site_title = '<a href="'.home_url('/').'">'.get_bloginfo('name').'</a>';
                echo $site_title ?>
              </p>
              <p id="site-description">
                <?php echo get_bloginfo('description') ?>
              </p>
            </div>

            <div class="alignright top-sns-follows">
            </div>

          </div><!-- /#h-top -->
        </div><!-- /#header-in -->
      </div><!-- /#header -->
    </header>
    <!-- 本体部分 -->
    <div id="body">
      <div id="body-in">
       <!-- main -->
        <main itemscope itemprop="mainContentOfPage">
          <div id="main" itemscope itemtype="http://schema.org/Blog">
            <?php //get_template_part('breadcrumbs'); //カテゴリパンくずリスト?>




<?php while(have_posts()): the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <article class="article">
    <header>
      <h1 class="entry-title">
        <?php the_title(); //投稿のタイトル?>
      </h1>
      <p class="post-meta">
        <?php get_template_part('datetime') //投稿日と更新日?>
        <?php if ( is_category_visible() && //カテゴリを表示する場合
                   get_the_category() ): //投稿ページの場合?>
        <span class="category"><amp-img src="<?php echo get_template_directory_uri(); ?>/images/folder.svg" width="12" height="12" class="fa fa-svg fa-fw"></amp-img><?php the_category(', ') ?></span>
        <?php endif; //is_category_visible?>

        <?php //通常ページへ
        if (is_user_logged_in() && is_amp_link_visible() ): ?>
        <span class="view-amp"><amp-img src="<?php echo get_template_directory_uri(); ?>/images/file-text-o.svg" width="12" height="12" class="fa fa-svg fa-fw"></amp-img><a href="<?php echo the_permalink(); ?>">通常ページ</a></span>
        <?php endif ?>

        <?php //AMPテストへ
        if (is_user_logged_in() && is_amp_test_link_visible() ): ?>
        <span class="view-amp"><amp-img src="<?php echo get_template_directory_uri(); ?>/images/amp-logo2.svg" width="12" height="12" class="fa fa-svg fa-fw"></amp-img><a href="<?php echo get_amp_test_tool_url(get_amp_permalink()); ?>" target="_blank">テスト</a></span>
        <?php endif ?>
      </p>

      <?php get_template_part('admin-pv');//管理者のみにPV表示?>

      <?php //if ( is_single() ) get_template_part('ad-top');//記事トップ広告 ?>

      <?php //if ( is_single() ) get_template_part('sns-buttons-top');//タイトル下の小さなシェアボタン?>

  <?php //AMP用の関連コンテンツユニット
get_template_part('ad-amp-top'); ?>

    </header>

    <?php get_template_part_amp('entry-eye-catch');//アイキャッチ挿入機能?>

    <div id="the-content" class="entry-content">
      <?php //記事本文の表示
        the_content( get_theme_text_read_more() ); //デフォルト：続きを読む?>
    </div>

    <footer>
      <?php if ( is_single() ) get_template_part('pager-page-links');//ページリンクのページャー?>

      <?php //if ( is_single() ) get_template_part('ad-article-footer');?>

      <?php //AMP用のアドセンスコード
      get_template_part('ad-amp'); ?>

      <?php //AMP用のSNSシェアボタン
      get_template_part('sns-amp'); ?>

      <p class="footer-post-meta">
        <?php if (is_tag_visible()): ?>
        <span class="post-tag"><?php the_tags('<amp-img src="'.get_template_directory_uri().'/images/tags.svg" width="12" height="12" class="fa fa-svg fa-fw"></amp-img>',', '); ?></span>
        <?php endif; ?>

        <?php if ( is_single() ) get_template_part('author-link') //投稿者リンク?>
      </p>
    </footer>
  </article><!-- .article -->
</div><!-- .post -->
<?php endwhile; ?>


<div id="under-entry-body">

  <?php if ( is_related_entry_visible() ): //関連記事を表示するか?>
  <aside id="related-entries">
    <h2><?php echo get_theme_text_related_entry();//関連記事タイトルの取得 ?></h2>
    <?php get_template_part_amp('related-entries'); ?>
  </aside><!-- #related-entries -->
  <?php endif; //is_related_entry_visible?>

  <?php //AMP用の関連コンテンツユニット
get_template_part('ad-amp-kanren'); ?>
 
</div>

<!-- footer -->
<footer itemscope itemtype="http://schema.org/WPFooter">
  <div id="footer" class="main-footer">
    <div id="footer-in">
      <div id="copyright" class="wrapper">
        <div class="credit">
          <?php echo get_site_license(); //サイトのライセンス表記の取得 ?>
        </div>

      </div>
  </div><!-- /#footer-in -->
  </div><!-- /#footer -->
</footer>

          </div>
        </main>
      </div>
    </div>
  </div>
</body>
</html>
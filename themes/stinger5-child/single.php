<?php get_header(); ?>

<div id="content" class="clearfix">
  <div id="contentInner">
    <main>
      <article>
        <div class="post"> 
          <!--ぱんくず -->
          <div id="breadcrumb">
            <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"> <a href="<?php echo home_url(); ?>" itemprop="url"> <span itemprop="title">ホーム</span> </a> &gt; </div>
            <?php $postcat = get_the_category(); ?>
            <?php $catid = $postcat[0]->cat_ID; ?>
            <?php $allcats = array($catid); ?>
            <?php 
while(!$catid==0) {
    $mycat = get_category($catid);
    $catid = $mycat->parent;
    array_push($allcats, $catid);
}
array_pop($allcats);
$allcats = array_reverse($allcats);
?>
            <?php foreach($allcats as $catid): ?>
            <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"> <a href="<?php echo get_category_link($catid); ?>" itemprop="url"> <span itemprop="title"><?php echo get_cat_name($catid); ?></span> </a> &gt; </div>
            <?php endforeach; ?>
          </div>
          <!--/ ぱんくず -->

<!-- ランキング -->
<!-- < ? php get_template_part('category-ranking'); ? > -->
<!-- /ランキング -->
          
          <section> 
            <!--ループ開始 -->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <h1 class="entry-title">
              <?php the_title(); //タイトル ?>
            </h1>
            <div class="blogbox">
              <p><span class="kdate"><i class="fa fa-calendar"></i>&nbsp;
<!--Microformats対応で "updated" 追記 2014.11.5-->
                <time class="entry-date updated" datetime="<?php the_time('c') ;?>">
                  <?php the_time('Y/m/d') ;?>
                </time>
                &nbsp;
                <?php if ($mtime = get_mtime('Y/m/d')) echo ' <i class="fa fa-repeat"></i>&nbsp; ' , $mtime; ?>
                <!--Microformats対応で下1行追加 2014.11.5-->
<span class="vcard author"><span class="fn">by <a href="https://twitter.com/masa_hico" rel="author"><?php the_author_meta('nickname'); ?></a></span></span>
                </span>
                </p>
          <p class="tagst"><i class="fa fa-folder-o"></i>&nbsp;-
            <?php the_category(', ') ?>
            &nbsp;
            <i class="fa fa-tags"></i>&nbsp;-
            <?php the_tags('', ', '); ?>
          </p>
          </div>

<!-- シェアボタン -->
<?php get_template_part('sns2');?>
<!-- /シェアボタン -->
            <?php the_content(); //本文 ?>
          </section>
          <!--/section-->
          <?php wp_link_pages(); ?>

<!-- Google Adsense -->
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<div style="color: #000000 margin-bottom:3px;">スポンサーリンク</div>
<div class="mb_adsense">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 記事下(レスポンシブ) -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="2500157109"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<?php else: ?>
<!-- PC用 -->
<?php endif; ?>
<!-- Google Adsense -->

<!-- 関連記事 -->
<?php wp_related_posts(); ?>
<!-- /関連記事 -->

<!-- シェアボタン -->
<div class="kizi02">
<?php get_template_part('sns');?>
</div>
<!-- シェアボタン -->

<!-- Google Adsense -->
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<div style="color: #000000 margin-bottom:3px;">スポンサーリンク</div>
<div class="mb_adsense">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- モバイル記事下(レスポンシブ) -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="3746231101"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<?php else: ?>
<!-- PC用 -->
<div style="padding:10px 0px;">
<div id="ad-bottom-oya">
<div style="clear:both;"></div>
<div style="color: #000000 margin-bottom:3px;">スポンサーリンク</div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 下 レクタングル大 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="5050580707"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
</div>
<?php endif; ?>
<!-- Google Adsense -->
<!-- Rakuten Widget FROM HERE -->
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<script type="text/javascript">rakuten_design="slide";rakuten_affiliateId="0e125c5e.e9d8611b.0e125c5f.562bdea3";rakuten_items="ctsmatch";rakuten_genreId=0;rakuten_size="300x250";rakuten_target="_blank";rakuten_theme="gray";rakuten_border="off";rakuten_auto_mode="off";rakuten_genre_title="off";rakuten_recommend="on";</script><script type="text/javascript" src="http://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js"></script>
<?php else: ?>
<!-- PC用の記述 -->
<script type="text/javascript">rakuten_design="slide";rakuten_affiliateId="0e125c5e.e9d8611b.0e125c5f.562bdea3";rakuten_items="ctsmatch";rakuten_genreId=0;rakuten_size="600x200";rakuten_target="_blank";rakuten_theme="gray";rakuten_border="off";rakuten_auto_mode="off";rakuten_genre_title="off";rakuten_recommend="on";</script><script type="text/javascript" src="http://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js"></script>
<?php endif; ?>
<!-- Rakuten Widget TO HERE -->
<!-- Facebook Like Box FROM HERE -->
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<!-- ADPRESSO -->
<div presso_sid="44"></div> <br />
<!-- /ADPRESSO -->
 <?php else: ?>
<!-- PC用の記述 -->
<hr>
<b>Facebookページの「いいね！」をぜひ！<br />
今後の記事をタイムラインにお届けします。
</b>
<div style="padding:20px 0px;">
<div class="fb-page" data-href="https://www.facebook.com/masalog" data-width="500" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/masalog"><a href="https://www.facebook.com/masalog">MasaLog</a></blockquote></div></div>
</div>

<?php endif; ?>
<!-- Facebook Like Box TO HERE -->

          <?php endwhile; else: ?>
          <p>記事がありません</p>
          <?php endif; ?>
          <!--ループ終了-->
 
          <!--関連記事-->
<ins id="ssRelatedPageBase"></ins>
<!--
          <h4 class="point"><i class="fa fa-th-list"></i>&nbsp;  関連記事</h4>
-->
          <?php //get_template_part('kanren');?>

          <!--ページナビ-->
          <div class="p-navi clearfix">
            <dl>
              <?php
        $prev_post = get_previous_post();
        if (!empty( $prev_post )): ?>
              <dt>PREV </dt>
              <dd><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a></dd>
              <?php endif; ?>
              <?php
        $next_post = get_next_post();
        if (!empty( $next_post )): ?>
              <dt>NEXT </dt>
              <dd><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a></dd>
              <?php endif; ?>
            </dl>
          </div>
        </div>
        <!--/post--> 
      </article>
    </main>
  </div>
  <!-- /#contentInner -->
  <?php get_sidebar(); ?>
</div>
<!--/#content -->

<?php get_footer(); ?>

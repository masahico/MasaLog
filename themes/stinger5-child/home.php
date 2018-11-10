<?php get_header(); ?>

<!-- Google Adsense -->
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- モバイルトップページ -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="7250701507"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php else: ?>
<!-- PC用 -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ビックバナー -->
<!--
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-2684783162843499"
     data-ad-slot="4948546150"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
-->
<?php endif; ?>
<!-- Google Adsense -->

<div id="content" class="clearfix">
  <div id="contentInner">
    <main>
      <article>
        <section>
          <?php get_template_part('itiran');?>
        </section>
        <!-- /section --> 
<?php get_template_part('sns-top'); //ソーシャルボタン読み込み ?> 
        <!-- ページナビ -->
        <?php if (function_exists("pagination")) {
pagination($wp_query->max_num_pages);
} ?>
      </article>
    </main>
  </div>
  <!-- /#contentInner -->
  <?php get_sidebar(); ?>
</div>
<!-- /#content -->
<?php get_footer(); ?>

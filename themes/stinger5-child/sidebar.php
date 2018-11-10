<aside>
<?php if (is_404()) { ?>
<?php } else { ?>
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<?php else: ?>
<!-- PC用 -->
  <div class="ad">
    <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(4) ) : else : //アドセンス ?>
    <?php endif; ?>
  </div>
<?php endif; ?>
<?php } ?>
  <!-- 検索フォーム -->
 <?php get_search_form(); //検索フォーム表示  ?>

<!-- 運営者情報 -->
<div class="twibox">
<h4 class="menu_underh2">プロフィール</h4>
<div class="textwidget">
<ul><li>
<img src="http://masalog.net/images/profile.jpg" width="120" height="120" align="left" vapace="5" hspace="5">
<strong>まさ <a href="https://twitter.com/masa_hico" target="_blank">@masa_hico</a></strong><br/>
東京の下町在住。2人の男の子のパパ。ライフログマニアで色々なことをiPhoneで記録することに凝ってます。
<br/>
<a href="http://masalog.net/about" target="_blank">詳しくはこちら</a>
</li></ul>
</div></div>

<!-- フォロー・いいねのお願い -->
<div class="twibox">
<h4 class="menu_underh2">「いいね！」・フォローお願いします！</h4>
<div class="textwidget">
<?php if ( is_mobile() ) :?>
<?php else: ?>
<div class="fb-page" data-href="https://www.facebook.com/masalog" data-width="330" data-height="250" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/masalog"><a href="https://www.facebook.com/masalog">MasaLog</a></blockquote></div>
</div>
<br />
<?php endif; ?>
<ul>
<li><a href='http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fmasalog.net%2Ffeed'  target='blank'><img id='feedlyFollow' src='http://s3.feedly.com/img/follows/feedly-follow-rectangle-volume-big_2x.png' alt='follow us in feedly' width='131' height='56'></a>
</li>
<li>
<a href="https://twitter.com/masalog_net" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @masalog_net</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</li>
</ul>
</div></div>


  <!-- 最近のエントリ -->
  <h4 class="menu_underh2">最近の記事</h4>
  <?php get_template_part('newpost');?>
  <!-- /最近のエントリ -->
<!-- A8 or Value Commerce -->
<iframe src="http://rcm-fe.amazon-adsystem.com/e/cm?t=a8-affi-238824-22&o=9&p=12&l=ur1&category=amazonrotate&f=ifr" width=300 height=250 scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe> <img border="0" width="1" height="1" src="http://www12.a8.net/0.gif?a8mat=2BLISZ+DG1FLE+249K+BWGDT" alt="">
<!-- /A8 or Value Commerce -->

  <div id="mybox">
    <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : //サイドウイジェット読み込み ?>
    <?php endif; ?>
  </div>
</aside>

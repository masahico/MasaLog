<h4>シェア・フォローいただけると嬉しいです！</h4>
<div class="sns">
    <ul class="snsb clearfix">
      <li> <a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js" async></script> 
      </li>
      <li>
<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
      </li>
      <li><div style="height:70px;"><a href="https://getpocket.com/save" class="pocket-btn" data-lang="en" data-save-url="<?php get_permalink(); ?>" data-pocket-count="vertical" data-pocket-align="left" >Pocket</a><script type="text/javascript" async defer>!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script></div>
      </li>
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
      <li> <a href="http://b.hatena.ne.jp/entry/<?php the_permalink(); ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?php the_title(); ?>｜<?php bloginfo('name'); ?>" data-hatena-bookmark-layout="vertical" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script> 
      </li>
<?php else: ?>
<!-- PC用の記述 -->
      <li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="vertical-balloon" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
      </li>
<?php endif; ?>
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
 <?php else: ?>
<!-- PC用の記述 -->
      <li><div class="g-plusone" data-size="tall"></div></li>
      <li><?php
if ( false === ( $subscribers = get_transient( 'feedly_subscribers' ) ) ) :
    $feed_url = rawurlencode( get_bloginfo( 'rss2_url' ) );
 
    $subscribers = wp_remote_get( "http://cloud.feedly.com/v3/feeds/feed%2F$feed_url" );
    $subscribers = json_decode( $subscribers['body'] );
    $subscribers = $subscribers->subscribers;
 
    // 負荷軽減のため半日キャッシュする（数値はお好みで）
    set_transient( 'feedly_subscribers', $subscribers, 60 * 60 * 12 );
endif;
?>
<div class="feedly-followers">
<span class="feedly-count" class="fdly-count"><?php echo $subscribers; ?></span><a href='http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fmasalog.net%2Ffeed'  target='blank'><img id='feedlyFollow' src='http://s3.feedly.com/img/follows/feedly-follow-rectangle-volume-small_2x.png' alt='follow us in feedly' width='66' height='20'></a>
</div>
      </li>
<?php endif; ?>
    </ul>
  </div>
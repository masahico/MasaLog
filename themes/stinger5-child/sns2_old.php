<!-- SNS count -->
<?php
  $url_encode=urlencode(get_permalink());
  $title_encode=urlencode(get_the_title());
?>

<div class="sns-box clearfix">
<div class="twitter-button">
<div class="balloon"><span class="num" data-scc="twitter"><?php if(function_exists('get_scc_twitter')) echo get_scc_twitter(); ?></span></div> 

<a class="button" href="http://twitter.com/intent/tweet?url=<?php echo $url_encode ?>&text=<?php echo $title_encode ?>&tw_p=tweetbutton" title="twitter">
<span class="icon-twitter"></span><span class="text">ツイート</span></a></div>

<div class="fb-button"><div class="balloon"><span class="num" data-scc="facebook"><?php if(function_exists('get_scc_facebook')) echo get_scc_facebook(); ?></span></div>
<a class="button" href="http://www.facebook.com/sharer.php?src=bm&u=<?php echo $url_encode;?>&t=<?php echo $title_encode;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"><span class="icon-facebook"></span><span class="text">シェア！</span></a></div>

<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<?php else: ?>
<!-- PC用の記述 -->
<div class="gplus-button"><div class="balloon"><span class="num" data-scc="gplus"><?php if(function_exists('get_scc_gplus')) echo get_scc_gplus(); ?></span></div> 
<a class="button" href="https://plus.google.com/share?url=<?php echo $url_encode;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=500');return false;" title="google"><span class="icon-gplus"></span><span class="text">+1</span></a></div>
<?php endif; ?>

<div class="hatena-button"><div class="balloon"><span class="num" data-scc="hatena"><?php if(function_exists('get_scc_hatebu')) echo get_scc_hatebu(); ?></span></div> 

<a  class="button" href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=510');return false;" title="hatenabookmark"><span class="icon-hatena"></span><span class="text">はてブ！</span></a></div>

<div class="pocket-button"><div class="balloon"><span class="num" data-scc="pocket"><?php if(function_exists('get_scc_pocket')) echo get_scc_pocket(); ?></span></div> 
<a class="button" href="http://getpocket.com/edit?url=<?php echo $url_encode ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;" title="Pocket"><span class="icon-pocket"></span><span class="text">Pocket</span></a></div>

<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
 <?php else: ?>
<!-- PC用の記述 -->
      <?php
if ( false === ( $subscribers = get_transient( 'feedly_subscribers' ) ) ) :
    $feed_url = rawurlencode( get_bloginfo( 'rss2_url' ) );
 
    $subscribers = wp_remote_get( "http://cloud.feedly.com/v3/feeds/feed%2F$feed_url" );
    $subscribers = json_decode( $subscribers['body'] );
    $subscribers = $subscribers->subscribers;
 
    // 負荷軽減のため半日キャッシュする（数値はお好みで）
    set_transient( 'feedly_subscribers', $subscribers, 60 * 60 * 12 );
endif; ?>
<div class="feedly-button"><div class="balloon"><span class="num" data-scc="hatena"><?php echo $subscribers; ?></span></div>
<a class="button" href='http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fmasalog.net%2Ffeed' target="blank"><span class="icon-feedly"></span><span class="text">Follow</span></a>
</div>
<?php endif; ?>

</div>

<!-- SNS count -->

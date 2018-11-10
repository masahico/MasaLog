<?php if (is_single() || is_category()) :?>
<?php if ( is_mobile() ) :?>
<!-- スマホ用の記述 -->
<?php
/* 現在のカテゴリ−の取得 */
$cat_now = get_the_category();
$cat_now = $cat_now[0];
$now_id = $cat_now->cat_ID; /* カテゴリID */
?>
<?php if (function_exists('wpp_get_mostpopular')) {
$args = '
limit=3&
range=monthly&
order_by=views&
thumbnail_width=50&
thumbnail_height=50&
wpp_start=\'<b>このカテゴリーの人気記事</b><ul class="wpp-list-mb">\'&
wpp_end="</ul>"&
pid="'.$post->ID.'"&
cat="'.$now_id.'"&
stats_views=0&
stats_comments=0';
wpp_get_mostpopular($args);
} ?>
<?php else: ?>
<!-- PC用 -->
<?php
/* 現在のカテゴリ−の取得 */
$cat_now = get_the_category();
$cat_now = $cat_now[0];
$now_id = $cat_now->cat_ID; /* カテゴリID */
?>
<?php if (function_exists('wpp_get_mostpopular')) {
$args = '
limit=5&
range=monthly&
order_by=views&
thumbnail_width=100&
thumbnail_height=80&
wpp_start=\'<b>このカテゴリーの人気記事</b><ul class="wpp-list">\'&
wpp_end="</ul>"&
pid="'.$post->ID.'"&
cat="'.$now_id.'"&
stats_views=0&
stats_comments=0';
wpp_get_mostpopular($args);
} ?>
<?php endif; ?>
<?php endif; ?>
<div style="clear:both" /></div>

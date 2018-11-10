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
        $content = '<div>' .get_the_post_thumbnail($post->ID). '</div>' .$content. '<div><a href="' .get_permalink($post->ID).'" target="_blank">この記事の続きを読む</a></div><div><a href="' .get_permalink($post->ID). '" target="_blank">' .get_the_title($post->ID). '</a> は <a href="http://masalog.net/">MasaLog</a> の記事です</div>';
    }
    return $content;
}
add_filter('the_excerpt_rss', 'do_post_contents_feeds');
add_filter('the_content_feed', 'do_post_contents_feeds');
?>

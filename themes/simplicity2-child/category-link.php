<?php //インデックスページや投稿ページで表示されるカテゴリーリンク
if ( is_category_visible() && //カテゴリを表示する場合
           get_the_category() ): //投稿ページの場合?>
<span class="category"><span class="fa fa-folder fa-fw"></span><?php the_category('<span class="category-separator">, </span>') ?></span>
<?php endif; //is_category_visible?>

<?php if (is_tag_visible()):   // タグ表示 2017.10.7 追加 ?>
<span class="post-tag"><?php the_tags('<span class="fa fa-tags fa-fw"></span>','<span class="tag-separator">, </span>'); ?></span>
<?php endif; ?>

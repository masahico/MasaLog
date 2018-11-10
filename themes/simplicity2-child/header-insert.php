<?php
//ヘッダー部分にタグを挿入したいときは、このテンプレート挿入（ヘッダーに挿入する解析タグなど）
//子テーマのカスタマイズ部分を最小限に抑えたい場合に有効なテンプレートとなります。
//例：<script type="text/javascript">解析コード</script>
?>
<?php if (!is_user_logged_in()) : 
//ログインユーザーをカウントしたくない場合は
//↓ここに挿入 ?>

<?php endif; ?>
<?php //ログインユーザーも含めてカウントする場合は以下に挿入 ?>
<?php
//インターナショナル ターゲティング対応 →削除
?>
<link rel="alternate" hreflang="ja" href="<?php the_permalink(); ?>">

<link rel="stylesheet" href="//masalog.net/wp-content/themes/simplicity2-child/yomereba-kaereba-responsive.css">
<?php
// ページ単位広告
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-2684783162843499",
    enable_page_level_ads: true
  });
</script>
<?php
// Facebook シェア時の作成者表示用 (以下の行がそうだがいったん除外、必要なときはPHPの外に出すこと)
// <meta name="author" content="Masa">
?>

<?php
//構造化タグ
//<span class="vcard author">
//    <span itemprop="author" itemscope itemtype="http://schema.org/Person" class="fn">
//        <span itemprop="name">Masa</span>
//    </span>
// </span>
?>

<?php
// ValueComerce おまかせ広告
?>
<script src="//js.omks.valuecommerce.com/vcomks.js"></script>


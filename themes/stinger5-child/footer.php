<footer id="footer">
  <h3>
    <?php if (is_home()) { ?>
    <?php bloginfo( 'name' ); ?>
    <?php } else { ?>
    <?php wp_title(''); ?>
    <?php } ?>
  </h3>
  <p>
    <?php bloginfo('description'); ?>
  </p>
  <p class="copy">Copyright&copy;
    <?php bloginfo('name');?>
    ,
    <?php the_date('Y');?>
    All Rights Reserved.</p>
</footer>
</div>
<!-- /#wrapper --> 
<!-- ページトップへ戻る -->
<div id="page-top"><a href="#wrapper" class="fa fa-angle-up"></a></div>
<!-- ページトップへ戻る　終わり -->
<?php  wp_enqueue_script('base',get_bloginfo('template_url') . '/js/base.js', array()); ?>

<?php if(is_mobile()) { //PCのみ追尾広告のjs読み込み ?>
<?php } else { ?>
<?php  wp_enqueue_script('scroll',get_bloginfo('template_url') . '/js/scroll.js', array()); ?>
<?php } ?>

<?php wp_footer(); ?>

<!-- Ptengine -->
<script type="text/javascript" async defer>
	window._pt_sp_2 = [];
	_pt_sp_2.push('setAccount,712076e4');
	var _protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
	(function() {
		var atag = document.createElement('script'); atag.type = 'text/javascript'; atag.async = true;
		atag.src = _protocol + 'js.ptengine.jp/pta.js';
		var stag = document.createElement('script'); stag.type = 'text/javascript'; stag.async = true;
		stag.src = _protocol + 'js.ptengine.jp/pts.js';
		var s = document.getElementsByTagName('script')[0]; 
		s.parentNode.insertBefore(atag, s);s.parentNode.insertBefore(stag, s);
	})();
</script>
<!-- Ptengine -->

</body></html>
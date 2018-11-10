<?php //Adsense 関連コンテンツユニット ?>
<?php if ( is_ads_visible() ): //広告表示がオンのとき?>
  <?php if ( generate_amp_adsense_code() ) :  ?>
  <div class="ad-space">
  <div class="ad-label"><?php echo get_ads_label() ?></div>
  <amp-ad layout="fixed-height" height="1221" type="adsense"
   data-ad-client="ca-pub-2684783162843499"
   data-ad-slot="5923651502"></amp-ad>
  </div>
  <?php endif; ?>
<?php endif; ?>

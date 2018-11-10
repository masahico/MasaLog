<?php if ( is_ads_visible() ): //広告表示がオンのとき?>
  <?php if ( generate_amp_adsense_code() ) :  ?>
     <div class="ad-space">
      <div class="ad-label"><?php echo get_ads_label() ?></div>
      <div class="ad-responsive ad-mobile adsense-300">
      <amp-ad width="300" height="250" type="adsense" data-ad-client="ca-pub-2684783162843499" data-ad-slot="5454040614"></amp-ad>
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>

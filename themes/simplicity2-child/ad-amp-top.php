<?php if ( is_ads_visible() ): //広告表示がオンのとき?>
  <?php if ( generate_amp_adsense_code() ) :  ?>
     <div class="ad-space">
      <div class="ad-label">スポンサーリンク</div>
      <amp-ad width="320" height="100" type="adsense" data-ad-client="ca-pub-2684783162843499" data-ad-slot="6843225906"></amp-ad>
      </div>
  <?php endif; ?>
<?php endif; ?>
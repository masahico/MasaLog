<!-- search form --> 
<div id="search">
  <form id="cse-search-box" action="http://google.com/cse" target="_blank">
    <label class="hidden" for="s">
      <?php _e('', 'kubrick'); ?>
    </label>
    <input type="hidden" name="cx" value="partner-pub-2684783162843499:6720931503" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" id="s" name="q" />
    <input type="image" src="<?php echo get_template_directory_uri(); ?>/images/search.png" alt="検索" id="searchsubmit"  name="sa" value="<?php _e('Search', 'kubrick'); ?>" />
  </form>
</div>
<script type="text/javascript" src="http://www.google.co.jp/coop/cse/brand?form=cse-search-box&amp;lang=ja"></script>
<!-- /search form -->
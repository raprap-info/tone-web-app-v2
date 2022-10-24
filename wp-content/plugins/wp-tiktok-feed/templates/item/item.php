<?php

use QUADLAYERS\TIKTOK\Frontend\Load as Frontend; ?>
<div id="tiktok-feed-item-<?php echo esc_attr($item['id']); ?>" class="tiktok-feed-item tiktok-feed-cols-<?php echo esc_attr($feed['columns']); ?>
     <?php echo ($feed['layout'] == 'carousel' || $feed['layout'] == 'carousel-vertical') ? ' swiper-slide nofancybox' : '' ?>
     <?php echo in_array($feed['layout'], array('highlight', 'highlight-square')) && array_intersect(array_merge((array) $item['i'], (array) $item['id'], $item['hashtags']), $feed['highlight']) ? 'highlight' : ''; ?>" data-item="<?php echo htmlentities(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>" data-elementor-open-lightbox="no">
  <div class="tiktok-feed-item-wrap">

    <?php
    include(Frontend::template_path('item/item-video.php'));
    ?>
  </div>
</div>
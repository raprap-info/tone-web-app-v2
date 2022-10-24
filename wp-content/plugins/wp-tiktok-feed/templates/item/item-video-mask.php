<div class="tiktok-feed-video-mask">
</div>
<div class="tiktok-feed-video-mask-content">
  <?php if ($feed['mask']['digg_count']) : ?>
    <span class="tiktok-digg_count">
      <i class="qlttf-icon-heart"></i>
      <?php echo esc_attr($item['digg_count']); ?>
    </span>
  <?php endif; ?>
  <?php if ($feed['mask']['comment_count'] !== false) : ?>
    <span class="ig-card-comment_count">
      <i class="qlttf-icon-comment"></i>
      <?php echo esc_attr($item['comment_count']); ?>
    </span>
  <?php endif; ?>
</div>
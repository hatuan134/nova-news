<?php
/** Template for an editorial story card in a WordPress Loop. */
$category = nova_primary_category();
?>
<article <?php post_class('story-card'); ?>>
    <a class="story-thumb" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('nova-card', ['loading' => 'lazy']); ?>
        <?php else : ?><span class="thumb-placeholder"><span aria-hidden="true">N✦</span></span><?php endif; ?>
    </a>
    <div class="story-copy">
        <?php if ($category) : ?><a class="eyebrow" href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?></a><?php endif; ?>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php echo esc_html(get_the_excerpt()); ?></p>
        <div class="story-meta"><span><?php echo esc_html(get_the_date('d/m/Y')); ?></span><span class="meta-dot">·</span><span><?php echo esc_html(nova_read_time()); ?> phút đọc</span></div>
    </div>
</article>

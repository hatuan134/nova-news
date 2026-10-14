<?php get_header(); ?>
<main id="main" class="article-page container">
<?php while (have_posts()) : the_post(); $cat = nova_primary_category(); ?>
<article <?php post_class('article-body'); ?>><div class="article-head"><div class="breadcrumbs"><a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a><span>›</span><?php if ($cat) : ?><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a><?php endif; ?></div>
    <?php if ($cat) : ?><a class="eyebrow" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a><?php endif; ?><h1><?php the_title(); ?></h1><p class="article-deck"><?php echo esc_html(get_the_excerpt()); ?></p><div class="article-info"><div><strong><?php echo esc_html(get_the_author()); ?></strong><span>Biên tập viên NOVA NEWS</span></div><div><?php echo esc_html(get_the_date('d/m/Y')); ?> <span class="meta-dot">·</span> <?php echo esc_html(nova_read_time()); ?> phút đọc</div></div></div>
    <?php if (has_post_thumbnail()) : ?><figure class="article-cover"><?php the_post_thumbnail('full'); if (get_the_post_thumbnail_caption()) : ?><figcaption><?php echo esc_html(get_the_post_thumbnail_caption()); ?></figcaption><?php endif; ?></figure><?php endif; ?>
    <div class="prose"><?php the_content(); wp_link_pages(); ?></div>
    <div class="article-end"><span>✳ NOVA NEWS</span><a href="<?php echo esc_url(home_url('/')); ?>">← Trở về trang chủ</a></div>
</article>
<?php endwhile; ?>
<?php $related = new WP_Query(['posts_per_page' => 3, 'post__not_in' => [get_the_ID()], 'category__in' => wp_get_post_categories(get_the_ID()), 'ignore_sticky_posts' => true]); if ($related->have_posts()) : ?><section class="related-section"><div class="section-heading"><div><span class="section-kicker">ĐỌC TIẾP</span><h2>Có thể <em>bạn quan tâm</em><span class="orange-period">.</span></h2></div></div><div class="story-grid"><?php while ($related->have_posts()) : $related->the_post(); get_template_part('template', 'card'); endwhile; ?></div></section><?php endif; wp_reset_postdata(); ?>
</main>
<?php get_footer(); ?>

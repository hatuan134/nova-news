<?php get_header(); ?>
<main id="main" class="container listing-page">
    <div class="listing-intro"><span class="section-kicker">NOVA NEWS / LƯU TRỮ</span><h1><?php if (is_home()) : echo 'Tất cả bài viết'; elseif (is_archive()) : the_archive_title(); else : echo 'Tin tức'; endif; ?><span class="orange-period">.</span></h1><?php if (is_archive()) : the_archive_description('<p>', '</p>'); endif; ?></div>
    <?php if (have_posts()) : ?><div class="story-grid"><?php while (have_posts()) : the_post(); get_template_part('template', 'card'); endwhile; ?></div><div class="pagination"><?php the_posts_pagination(['mid_size' => 1, 'prev_text' => '← Trước', 'next_text' => 'Tiếp →']); ?></div><?php else : ?><p class="no-results">Chưa có bài viết trong mục này.</p><?php endif; ?>
</main>
<?php get_footer(); ?>

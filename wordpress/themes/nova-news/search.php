<?php get_header(); ?>
<main id="main" class="container listing-page"><div class="listing-intro"><span class="section-kicker">NOVA / TÌM KIẾM</span><h1>Kết quả cho “<?php echo esc_html(get_search_query()); ?>”<span class="orange-period">.</span></h1></div>
<?php if (have_posts()) : ?><div class="story-grid"><?php while (have_posts()) : the_post(); get_template_part('template', 'card'); endwhile; ?></div><div class="pagination"><?php the_posts_pagination(['prev_text' => '← Trước', 'next_text' => 'Tiếp →']); ?></div><?php else : ?><div class="no-results"><p>Chưa tìm thấy bài viết phù hợp. Hãy thử từ khóa khác.</p><?php get_search_form(); ?></div><?php endif; ?>
</main>
<?php get_footer(); ?>

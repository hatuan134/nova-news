<?php get_header(); ?>
<main id="main">
    <section class="intro-block container">
        <div class="intro-badge"><span class="red-pulse"></span> ĐỘC LẬP TRONG GÓC NHÌN</div>
        <div class="intro-grid"><h1>Chạm vào<br><em>nhịp sống</em> hôm nay<span class="orange-period">.</span></h1><div class="intro-aside"><p>Tin tức đáng quan tâm. Những phân tích dễ hiểu. Mọi điều bạn cần biết để kết nối với thế giới đang chuyển động.</p><a href="#tin-moi" class="text-arrow">Khám phá tin mới <span aria-hidden="true">↗</span></a></div></div>
        <div class="divider-line"><span>THỜI SỰ • CÔNG NGHỆ • GIÁO DỤC • ĐỜI SỐNG</span><span>01 / NOVA NEWS</span></div>
    </section>
    <?php
    $hero = new WP_Query(['posts_per_page' => 4, 'ignore_sticky_posts' => true]);
    if ($hero->have_posts()) :
        $hero_ids = [];
        $hero->the_post();
        $hero_ids[] = get_the_ID();
        $cat = nova_primary_category();
    ?>
    <section class="container lead-layout" aria-label="Tin nổi bật">
        <article <?php post_class('lead-story'); ?>>
            <a href="<?php the_permalink(); ?>" class="lead-image" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                <?php if (has_post_thumbnail()) : the_post_thumbnail('nova-hero', ['fetchpriority' => 'high']); else : ?><span class="lead-placeholder" aria-hidden="true">N<span>✦</span></span><?php endif; ?>
                <span class="lead-image-tag">TIN NỔI BẬT</span>
            </a>
            <div class="lead-content">
                <?php if ($cat) : ?><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="eyebrow"><?php echo esc_html($cat->name); ?></a><?php endif; ?>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <div class="story-meta"><span><?php echo esc_html(get_the_date('d/m/Y')); ?></span><span class="meta-dot">·</span><span><?php echo esc_html(nova_read_time()); ?> phút đọc</span></div>
            </div>
        </article>
        <div class="lead-sidebar">
            <div class="side-heading"><span>TIÊU ĐIỂM</span><span class="small-arrow">↗</span></div>
            <?php while ($hero->have_posts()) : $hero->the_post(); $hero_ids[] = get_the_ID(); $cat = nova_primary_category(); ?>
                <article class="mini-story">
                    <a class="mini-story-thumb" href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : the_post_thumbnail('thumbnail', ['loading' => 'lazy']); else : ?><span class="thumb-placeholder"><span>N✦</span></span><?php endif; ?>
                    </a>
                    <div><?php if ($cat) : ?><a class="eyebrow" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a><?php endif; ?><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><span class="story-meta"><?php echo esc_html(get_the_date('d/m/Y')); ?></span></div>
                </article>
            <?php endwhile; ?>
            <div class="side-note"><span class="side-note-icon">✳</span><strong>Một ngày, nhiều góc nhìn.</strong><p>Đọc để hiểu hơn những câu chuyện đang diễn ra quanh ta.</p></div>
        </div>
    </section>
    <?php wp_reset_postdata(); else : ?>
    <section class="container empty-feature"><div class="empty-number">01</div><div><span class="eyebrow">BẮT ĐẦU CÂU CHUYỆN</span><h2>Không gian tin tức đã sẵn sàng.</h2><p>Hãy đăng nhập trang quản trị, tạo danh mục và xuất bản bài viết đầu tiên. Tin nổi bật sẽ tự động xuất hiện tại đây.</p><a class="pill-btn" href="<?php echo esc_url(wp_login_url()); ?>">Đi đến đăng nhập quản trị ↗</a></div></section>
    <?php endif; ?>

    <section class="section-news container" id="tin-moi">
        <div class="section-heading"><div><span class="section-kicker">CẬP NHẬT MỖI NGÀY</span><h2>Tin mới <em>nhất</em><span class="orange-period">.</span></h2></div><span class="section-count">NOVA / EDITORIAL</span></div>
        <?php $recent = new WP_Query(['posts_per_page' => 6, 'ignore_sticky_posts' => true]); ?>
        <?php if ($recent->have_posts()) : ?><div class="story-grid">
            <?php while ($recent->have_posts()) : $recent->the_post(); get_template_part('template', 'card'); endwhile; ?>
        </div><?php else : ?><div class="no-results">Chưa có bài viết nào. Hãy tạo bài viết trong <strong>Admin → Bài viết → Viết bài mới</strong>.</div><?php endif; wp_reset_postdata(); ?>
    </section>
    <section class="newsletter-block container"><div><span>THE NOVA BRIEF</span><h2>Không bỏ lỡ những<br>điều <em>đáng biết.</em></h2></div><p>Mỗi bài viết là một góc nhìn mới.<br>Tiếp tục khám phá các chủ đề bạn quan tâm.</p><a href="#chuyen-muc" class="round-arrow" aria-label="Đi đến chuyên mục">↗</a></section>
    <section class="section-categories container" id="chuyen-muc"><div class="section-heading"><div><span class="section-kicker">CHỦ ĐỀ DÀNH CHO BẠN</span><h2>Khám phá <em>chuyên mục</em><span class="orange-period">.</span></h2></div></div>
        <div class="category-grid">
        <?php $cats = get_categories(['hide_empty' => false, 'number' => 6, 'exclude' => [get_option('default_category')]]); if ($cats) : foreach ($cats as $index => $category) : ?>
            <a class="category-tile" href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><span class="category-no">0<?php echo esc_html($index + 1); ?></span><strong><?php echo esc_html($category->name); ?></strong><span class="category-arrow">↗</span></a>
        <?php endforeach; else : ?><div class="no-results">Bạn chưa tạo danh mục. Vào <strong>Admin → Bài viết → Chuyên mục</strong> để thêm các chủ đề tin tức.</div><?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>

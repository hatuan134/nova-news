<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Bỏ qua đến nội dung</a>
<div class="top-strip">
    <div class="container top-strip-inner">
        <span><span class="live-dot" aria-hidden="true"></span> TIN TỨC • GÓC NHÌN • CUỘC SỐNG</span>
        <span><?php echo esc_html(wp_date('l, d/m/Y')); ?></span>
    </div>
</div>
<header class="site-header">
    <div class="container header-main">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Nova News - Trang chủ">
            <span class="brand-mark" aria-hidden="true">N<span>✦</span></span>
            <span class="brand-copy"><strong>NOVA<span>NEWS</span></strong><small>CHUYỂN ĐỘNG MỖI NGÀY</small></span>
        </a>
        <div class="header-actions">
            <a class="header-date" href="<?php echo esc_url(home_url('/')); ?>">Cổng thông tin điện tử</a>
            <button class="mobile-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="Mở menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
    <div class="header-nav-wrap">
        <div class="container nav-layout">
            <nav class="primary-nav" id="primary-navigation" aria-label="Menu chính">
                <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list', 'fallback_cb' => 'nova_fallback_menu', 'depth' => 1]); ?>
            </nav>
            <button class="search-trigger" type="button" aria-controls="site-search" aria-expanded="false" aria-label="Mở tìm kiếm">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>
            </button>
        </div>
    </div>
    <div class="container search-panel" id="site-search" hidden>
        <?php get_search_form(); ?>
    </div>
</header>

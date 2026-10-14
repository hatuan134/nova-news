<?php
/** Nova News theme setup. */
if (!defined('ABSPATH')) { exit; }

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo', ['height' => 80, 'width' => 320, 'flex-height' => true, 'flex-width' => true]);
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus(['primary' => __('Menu chính', 'nova-news')]);
    add_image_size('nova-hero', 1000, 680, true);
    add_image_size('nova-card', 640, 440, true);
});

add_action('wp_enqueue_scripts', function () {
    $uri = get_template_directory_uri();
    $path = get_template_directory();
    wp_enqueue_style('nova-main', $uri . '/assets/css/main.css', [], filemtime($path . '/assets/css/main.css'));
    wp_enqueue_script('nova-main', $uri . '/assets/js/main.js', [], filemtime($path . '/assets/js/main.js'), true);
});

function nova_primary_category($post_id = null) {
    $terms = get_the_category($post_id ?: get_the_ID());
    return ($terms && !is_wp_error($terms)) ? $terms[0] : null;
}

function nova_read_time($post_id = null) {
    $post = get_post($post_id ?: get_the_ID());
    $words = $post ? str_word_count(wp_strip_all_tags($post->post_content)) : 0;
    return max(1, (int) ceil($words / 220));
}

function nova_fallback_menu() {
    echo '<ul class="nav-list">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li>';
    wp_list_categories(['title_li' => '', 'number' => 5, 'hide_empty' => false]);
    echo '</ul>';
}

add_filter('excerpt_length', function () { return 23; }, 999);
add_filter('excerpt_more', function () { return '…'; });

<?php
function figueira_digital_scripts() {
    wp_enqueue_style('figueira-digital-style', get_stylesheet_uri());
    wp_enqueue_script('three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', array(), null, true);
    wp_enqueue_script('background', get_template_directory_uri() . '/js/background.js', array('three-js'), null, true);

    $page_type = get_page_type();
    wp_localize_script('background', 'pageInfo', array(
        'type' => $page_type
    ));
}
add_action('wp_enqueue_scripts', 'figueira_digital_scripts');

function get_page_type() {
    if (is_front_page()) return 'landing';
    // if (is_page('agency')) return 'agency';
    // if (is_page('academy')) return 'academy';
    return 'default';
}

function register_my_menu() {
    register_nav_menu('header-menu', __('Header Menu'));
}
add_action('init', 'register_my_menu');

function create_footer_page() {
    if (!get_page_by_path('footer-content')) {
        wp_insert_post(array(
            'post_title'    => 'Footer Content',
            'post_content'  => 'Edit this page to change the footer content.',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'footer-content'
        ));
    }
}
add_action('after_switch_theme', 'create_footer_page');

function create_cookie_banner_page() {
    if (!get_page_by_path('cookie-banner-content')) {
        wp_insert_post(array(
            'post_title'    => 'Cookie Banner Content',
            'post_content'  => 'We use cookies to improve your experience on our website. By browsing this website, you agree to our use of cookies.',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'cookie-banner-content'
        ));
    }
}
add_action('after_switch_theme', 'create_cookie_banner_page');

function enqueue_cookie_banner_script() {
    wp_enqueue_script('cookie-banner', get_template_directory_uri() . '/js/cookie-banner.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_cookie_banner_script');

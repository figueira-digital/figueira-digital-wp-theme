<?php
function figueira_digital_scripts() {
    wp_enqueue_style('figueira-digital-style', get_stylesheet_uri());
    wp_enqueue_script('three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', array(), null, true);
    wp_enqueue_script('background', get_template_directory_uri() . '/js/background.js', array('three-js'), null, true);

    $page_type = get_page_type();
    wp_localize_script('background', 'pageInfo', array(
        'type' => $page_type
    ));

    // Enqueue scroll snap styles if needed
    if (is_page()) {
        wp_enqueue_style(
            'scroll-snap-styles',
            get_template_directory_uri() . '/css/scroll-snap.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'figueira_digital_scripts');

function get_page_type() {
    if (is_front_page()) return 'landing';
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

// Register block styles for full-height sections
function register_block_styles() {
    register_block_style(
        'core/group',
        array(
            'name'         => 'full-height-section',
            'label'        => __('Full Height Section', 'figueira-digital'),
        )
    );
}
add_action('init', 'register_block_styles');

// Check for full-height sections and add necessary body class
function check_for_full_height_sections($content) {
    if (is_page() && has_blocks($content)) {
        $blocks = parse_blocks($content);
        $has_full_height_section = false;
        
        foreach ($blocks as $block) {
            if ($block['blockName'] === 'core/group' && 
                isset($block['attrs']['className']) && 
                strpos($block['attrs']['className'], 'is-style-full-height-section') !== false) {
                $has_full_height_section = true;
                break;
            }
        }
        
        if ($has_full_height_section) {
            add_filter('body_class', function($classes) {
                return array_merge($classes, array('has-scroll-snap'));
            });
        }
    }
    return $content;
}
add_filter('the_content', 'check_for_full_height_sections', 1);

function enqueue_cookie_banner_script() {
    wp_enqueue_script('cookie-banner', get_template_directory_uri() . '/js/cookie-banner.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_cookie_banner_script');
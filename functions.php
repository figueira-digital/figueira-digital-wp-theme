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
    // Only proceed if Polylang is active
    if (function_exists('pll_languages_list')) {
        $languages = pll_languages_list();
        
        foreach ($languages as $lang) {
            $page_title = $lang === 'en' ? 'Cookie Banner Content' : 'Cookie Banner Content ' . strtoupper($lang);
            $content = $lang === 'en' 
                ? 'We use cookies to improve your experience on our website. By browsing this website, you agree to our use of cookies.'
                : ''; // Leave blank for manual translation
            
            // Check if the page exists in this language
            $page = get_page_by_path('cookie-banner-content-' . $lang);
            
            if (!$page) {
                $page_id = wp_insert_post(array(
                    'post_title'    => $page_title,
                    'post_content'  => $content,
                    'post_status'   => 'publish',
                    'post_author'   => 1,
                    'post_type'     => 'page',
                    'post_name'     => 'cookie-banner-content-' . $lang
                ));
                
                // Set the language for the new page
                if (function_exists('pll_set_post_language')) {
                    pll_set_post_language($page_id, $lang);
                }
            }
        }
    }
}
add_action('after_switch_theme', 'create_cookie_banner_page');

function enqueue_cookie_banner_script() {
    wp_enqueue_script('cookie-banner', get_template_directory_uri() . '/js/cookie-banner.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_cookie_banner_script');



function register_workshop_post_type() {
    $labels = array(
        'name'                  => 'Workshops',
        'singular_name'         => 'Workshop',
        'menu_name'            => 'Workshops',
        'add_new'              => 'Add New Workshop',
        'add_new_item'         => 'Add New Workshop',
        'edit_item'            => 'Edit Workshop',
        'new_item'             => 'New Workshop',
        'view_item'            => 'View Workshop',
        'search_items'         => 'Search Workshops',
        'not_found'            => 'No workshops found',
        'not_found_in_trash'   => 'No workshops found in trash',
        'all_items'            => 'All Workshops',
        'archives'             => 'Workshop Archives'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'show_in_rest'        => true, // Enable Gutenberg editor
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-calendar-alt',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'workshops'),
        'publicly_queryable'  => true
    );

    register_post_type('workshop', $args);
}
add_action('init', 'register_workshop_post_type');

// Flush rewrite rules on theme activation
function workshop_rewrite_flush() {
    register_workshop_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'workshop_rewrite_flush');

// Add this to your functions.php
function register_cookie_strings() {
    if (function_exists('pll_register_string')) {
        pll_register_string('cookie-accept', 'Accept', 'Cookie Banner');
    }
}
add_action('init', 'register_cookie_strings');

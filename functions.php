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

// Add custom class to body when page uses scroll snap
function add_scroll_snap_body_class($classes) {
    if (is_page()) {
        $post = get_post();
        if (has_blocks($post->post_content)) {
            $blocks = parse_blocks($post->post_content);
            foreach ($blocks as $block) {
                if ($block['blockName'] === 'core/group' && 
                    isset($block['attrs']['className']) && 
                    strpos($block['attrs']['className'], 'is-style-full-height-section') !== false) {
                    $classes[] = 'has-scroll-snap';
                    break;
                }
            }
        }
    }
    return $classes;
}
add_filter('body_class', 'add_scroll_snap_body_class');

// Enqueue styles for scroll snap
function enqueue_scroll_snap_styles() {
    wp_enqueue_style(
        'scroll-snap-styles',
        get_template_directory_uri() . '/css/scroll-snap.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_scroll_snap_styles');

// Add this to functions.php
function enqueue_scroll_snap_script() {
    if (is_page()) {
        wp_enqueue_script(
            'scroll-snap-script',
            get_template_directory_uri() . '/js/scroll-snap.js',
            array(),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_scroll_snap_script');


function modify_content_for_scroll_snap($content) {
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
add_filter('the_content', 'modify_content_for_scroll_snap', 1);

// Ensure proper script loading order
function adjust_script_priority() {
    // Remove existing script
    remove_action('wp_enqueue_scripts', 'figueira_digital_scripts');
    
    // Re-add with later priority
    add_action('wp_enqueue_scripts', 'figueira_digital_scripts', 20);
}
add_action('init', 'adjust_script_priority');


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

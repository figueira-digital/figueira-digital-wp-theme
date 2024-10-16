<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <div id="background-container"></div>
    <header id="masthead" class="site-header">
        <div class="site-branding">
            <div class="brand-wrapper">
                <a href="/">
                    <div class="brand-top">figueira</div>
                    <div class="brand-bottom">_digital</div>
                </a>
            </div>
        </div>
        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'header-menu',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => false 
                )
            );
            ?>
        </nav>
    </header>

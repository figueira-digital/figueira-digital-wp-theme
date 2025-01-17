</div>
    <footer id="colophon" class="site-footer">
        <div class="footer-content">
            <?php
            $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
            $footer_page = get_page_by_path('footer-content-' . $current_lang);
            if ($footer_page) {
                $content = apply_filters('the_content', $footer_page->post_content);
                echo $content;
            } else {
                echo '<p>Footer content page not found. Please create a page with the slug "footer-content-' . $current_lang . '".</p>';
            }
            ?>
        </div>
    </footer>
</div>
<div id="cookie-banner" style="display: none;">
    <div class="cookie-banner-content">
        <?php
        $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
        $cookie_banner_page = get_page_by_path('cookie-banner-content-' . $current_lang);
        if ($cookie_banner_page) {
            $content = apply_filters('the_content', $cookie_banner_page->post_content);
            echo $content;
        } else {
            echo '<p>Cookie banner content not found. Please create a page with the slug "cookie-banner-content-' . $current_lang . '".</p>';
        }
        ?>
    </div>
    <button class="wp-block-button__link has-background wp-element-button" id="accept-cookies" style="background:linear-gradient(90deg, rgba(116,72,174,1) 0%, rgba(236,43,128,1) 100%); border: none; outline:none; text-decoration: underline;" onmouseover="this.style.fontWeight='bold'" onmouseout="this.style.fontWeight='normal'"><?php echo function_exists('pll__') ? pll__('Accept') : 'Accept'; ?></button>
</div>
<?php wp_footer(); ?>
</body>
</html>

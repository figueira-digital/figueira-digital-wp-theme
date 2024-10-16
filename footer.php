</div>
    <footer id="colophon" class="site-footer">
        <div class="footer-content">
            <?php
            $footer_page = get_page_by_path('footer-content');
            if ($footer_page) {
                $content = apply_filters('the_content', $footer_page->post_content);
                echo $content;
            } else {
                echo '<p>Footer content page not found. Please create a page with the slug "footer-content".</p>';
            }
            ?>
        </div>
    </footer>
</div>

<div id="cookie-banner" style="display: none;">
    <div class="cookie-banner-content">
        <?php
        $cookie_banner_page = get_page_by_path('cookie-banner-content');
        if ($cookie_banner_page) {
            $content = apply_filters('the_content', $cookie_banner_page->post_content);
            echo $content;
        } else {
            echo '<p>Cookie banner content not found. Please create a page with the slug "cookie-banner-content".</p>';
        }
        ?>
    </div>
    <button id="accept-cookies">Accept</button>
</div>

<?php wp_footer(); ?>
</body>
</html>
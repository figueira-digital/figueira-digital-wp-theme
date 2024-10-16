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
<?php wp_footer(); ?>
</body>
</html>

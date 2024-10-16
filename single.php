<?php get_header(); ?>

<main id="primary" class="site-main">
    <div id="container">
        <div id="content">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <?php
                            echo 'Posted on ' . get_the_date();
                            ?>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php
            endwhile;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

<?php get_header(); ?>

<main id="primary" class="site-main">
    <div id="container">
        <div id="content">
            <header class="page-header">
                <h1 class="page-title">Workshops</h1>
            </header>

            <?php if (have_posts()) : ?>
                <div class="workshop-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="workshop-card">
                            <?php if ($image = get_field('image')): ?>
                                <div class="workshop-card-image">
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                </div>
                            <?php endif; ?>

                            <div class="workshop-card-content">
                                <h2 class="workshop-card-title">
                                    <?php echo esc_html(get_field('workshop_title')); ?>
                                </h2>

                                <div class="workshop-card-meta">
                                    <?php if ($date = get_field('workshop_date')): ?>
                                        <div><strong>Date:</strong> <?php echo esc_html($date); ?></div>
                                    <?php endif; ?>
                                    
                                    <?php if ($location = get_field('location')): ?>
                                        <div><strong>Location:</strong> <?php echo esc_html($location); ?></div>
                                    <?php endif; ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="workshop-card-link">
                                    Learn More
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php the_posts_navigation(); ?>

            <?php else : ?>
                <p>No workshops scheduled at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

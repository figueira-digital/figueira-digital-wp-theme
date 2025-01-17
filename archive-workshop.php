<?php get_header(); ?>

<main id="primary" class="site-main">
    <div id="container">
        <div id="content">
            <header class="page-header">
                <h1 class="page-title has-x-large-font-size">Workshops</h1>
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
                                <h2 class="workshop-card-title has-medium-font-size">
                                    <?php echo esc_html(get_field('workshop_title')); ?>
                                </h2>

                                <div class="workshop-card-meta">
                                    <?php if ($date = get_field('workshop_date')): ?>
                                        <div class="has-small-font-size"><strong>Date:</strong> <?php echo esc_html($date); ?></div>
                                    <?php endif; ?>
                                    
                                    <?php if ($location = get_field('location')): ?>
                                        <div class="has-small-font-size"><strong>Location:</strong> <?php echo esc_html($location); ?></div>
                                    <?php endif; ?>
                                </div>
								<div class="wp-block-button has-custom-font-size">
                                	<a href="<?php the_permalink(); ?>" class="wp-block-button__link has-background wp-element-button has-small-font-size" style="background:linear-gradient(90deg, rgba(116,72,174,1) 0%, rgba(236,43,128,1) 100%); border: none; outline:none; text-decoration: underline;" onmouseover="this.style.fontWeight='bold'" onmouseout="this.style.fontWeight='normal'">
                                    Learn More
                                </a>
								</div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php the_posts_navigation(); ?>

            <?php else : ?>
                <p  class="has-small-font-size">No workshops scheduled at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

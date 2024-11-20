<?php get_header(); ?>

<main id="primary" class="site-main">
    <div id="container">
        <div id="content">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if ($image = get_field('image')): ?>
                        <div class="workshop-image">
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                        </div>
                    <?php endif; ?>

                    <header class="entry-header">
                        <h1 class="entry-title">
                            <?php echo esc_html(get_field('workshop_title')); ?>
                        </h1>
                        <div class="workshop-meta">
                            <?php if ($date = get_field('workshop_date')): ?>
                                <div class="workshop-date">
                                    <strong>Date:</strong> <?php echo esc_html($date); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($start = get_field('start_time') && $end = get_field('end_time')): ?>
                                <div class="workshop-time">
                                    <strong>Time:</strong> <?php echo esc_html($start); ?> - <?php echo esc_html($end); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($location = get_field('location')): ?>
                                <div class="workshop-location">
                                    <strong>Location:</strong> <?php echo esc_html($location); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php if ($skills = get_field('skills_list')): ?>
                            <div class="workshop-skills">
                                <h2>Skills You'll Learn</h2>
                                <?php echo wp_kses_post(wpautop($skills)); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($requirements = get_field('requirements')): ?>
                            <div class="workshop-requirements">
                                <h2>Requirements</h2>
                                <?php echo wp_kses_post(wpautop($requirements)); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($registration_link = get_field('registration_link')): ?>
                            <div class="workshop-registration">
                                <a href="<?php echo esc_url($registration_link); ?>" class="registration-button">
                                    Register Now
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

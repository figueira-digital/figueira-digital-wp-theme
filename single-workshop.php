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

                        <?php 
                            $registration_limit = get_field('registration_limit');
                            $current_date = current_time('Y-m-d');
                            
                            if ($campaign_id = get_field('campaign_id')): 
                                if (!$registration_limit || strtotime($current_date) <= strtotime($registration_limit)):
                                ?>
                                    <div class="workshop-registration">
                                        <table style="margin: 0 auto; border-collapse: collapse; width: 400px; font-size: 18px;">
                                            <form id="WebToLeadForm" action="https://crm.figueira.digital/index.php?entryPoint=WebToPersonCapture" method="POST" name="WebToLeadForm">
                                                <tr>
                                                    <td style="padding: 15px;">
                                                        <label for="first_name">First Name: <span style="color: #ff4444;">*</span></label>
                                                    </td>
                                                    <td style="padding: 15px;">
                                                        <input name="first_name" id="first_name" type="text" required style="width: 100%; font-size: 18px; padding: 8px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px;">
                                                        <label for="last_name">Last Name: <span style="color: #ff4444;">*</span></label>
                                                    </td>
                                                    <td style="padding: 15px;">
                                                        <input name="last_name" id="last_name" type="text" required style="width: 100%; font-size: 18px; padding: 8px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px;">
                                                        <label for="phone_mobile">Mobile: <span style="color: #ff4444;">*</span></label>
                                                    </td>
                                                    <td style="padding: 15px;">
                                                        <input name="phone_mobile" id="phone_mobile" type="text" required style="width: 100%; font-size: 18px; padding: 8px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px;">
                                                        <label for="email1">Email Address: <span style="color: #ff4444;">*</span></label>
                                                    </td>
                                                    <td style="padding: 15px;">
                                                        <input name="email1" id="email1" type="email" required style="width: 100%; font-size: 18px; padding: 8px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px;">
                                                        <label for="birthdate">Birthdate: <span style="color: #ff4444;">*</span></label>
                                                    </td>
                                                    <td style="padding: 15px;">
                                                        <input name="birthdate" id="birthdate" type="date" required style="width: 100%; font-size: 18px; padding: 8px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px;">
                                                        <label for="primary_address_street">Address: <span style="color: #ff4444;">*</span></label>
                                                    </td>
                                                    <td style="padding: 15px;">
                                                        <input name="primary_address_street" id="primary_address_street" required type="text" style="width: 100%; font-size: 18px; padding: 8px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px;">
                                                        <label for="primary_address_city">City: <span style="color: #ff4444;">*</span></label>
                                                    </td>
                                                    <td style="padding: 15px;">
                                                        <input name="primary_address_city" id="primary_address_city" type="text" required style="width: 100%; font-size: 18px; padding: 8px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding: 15px; text-align: center;">
                                                        <input type="submit" value="Submit" style="font-size: 18px; padding: 10px 20px;">
                                                    </td>
                                                </tr>
                                                
                                                <!-- Hidden fields -->
                                                <input name="campaign_id" id="campaign_id" type="hidden" value="<?php echo esc_attr($campaign_id); ?>">
                                                <input name="redirect_url" id="redirect_url" type="hidden" value="https://figueira.digital/success/">
                                                <input name="assigned_user_id" id="assigned_user_id" type="hidden" value="c04a5e33-8fb1-7101-5b55-6712539a6ba7">
                                                <input name="moduleDir" id="moduleDir" type="hidden" value="Leads">
                                            </form>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="workshop-registration-closed" style="text-align: center; padding: 20px; background: rgba(255, 0, 0, 0.1); margin: 20px 0;">
                                        <p style="font-size: 18px; color: #fff;">Registration for this workshop is now closed.</p>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

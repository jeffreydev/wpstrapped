<?php
/*
 * Template Name: Home Page
 */

get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php echo get_template_part('content', 'home'); ?>
    <?php endwhile; else:?>
        <p><?php _e('Sorry, this page does not exist.'); ?></p>
<?php endif; ?>
    
<?php get_footer(); ?>

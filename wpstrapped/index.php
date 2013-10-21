<?php get_header(); ?>
<!-- Page Content
    ================================================== -->
    
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            <?php echo get_template_part('content', 'blog'); ?>
        <?php endwhile; ?>
        <div>
            <nav class="pagination">
                <?php if (function_exists("jdev_pagination")) : jdev_pagination();
                endif
                ?>
            </nav>
        </div> <!-- /span12 -->
        <?php endif; ?>
        </div>
            
            <?php get_sidebar(); ?>
            
        </div>
    </div>
<?php get_footer(); ?>
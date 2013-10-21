<?php get_header(); ?>
<!-- Page Content
    ================================================== -->
    
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="row post-wrap">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <h2 class="blog-title"><?php the_title(); ?></h2>
                    <h4 class="meta"><?php the_time('M d, Y g:i A') ?> - Posted by <?php the_author(); ?></h4>
                    <div class="entry-contents">
                        <?php the_content(); ?>
                    </div>
                    <?php endwhile; else : ?>
                        <h2 class="blog-title">No post was found</h2>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php get_sidebar(); ?>
            
        </div>
    </div>
<?php get_footer(); ?>

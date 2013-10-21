<?php get_header(); ?>
                
<div class="wrapper">


		<?php if(have_posts()) : ?>
                <center>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		<h1 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h1>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h1>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('Y'); ?></h1>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 class="pagetitle">Author Archive</h1>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle">Blog Archives</h1>               
                
		<?php } ?>
                </center>
                
                <center><hr/></center>
                
                <div class="archived">
		<?php while(have_posts()) : the_post(); ?>

                        <article class="thumb">                        
                            <?php the_post_thumbnail('full'); ?>
                            <div class="thumb-content">
                                <h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <?php the_excerpt(); ?>                     
                            </div>
                        </article> 

		<?php endwhile; else : ?>

		<div class="post">
		
			<h2>Page Not Found</h2>
			
			<p>Looks like the page you're looking for isn't here anymore. Try browsing the <a href="">categories</a>, <a href="">archives</a>, or using the search box below.</p>
			
			<?php include(TEMPLATEPATH.'/searhform.php'); ?>
		
		</div> <!-- .post -->

		<?php endif; ?>
	
		<div class="navigation clear">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
                </div><!-- end archive -->
                
                <?php get_sidebar(); ?>
</div>





<?php get_footer(); ?>
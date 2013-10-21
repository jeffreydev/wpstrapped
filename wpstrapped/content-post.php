<div class="container main-content">
    <div class="row-fluid">
        <div class="span8">
            <h2 class="entry-title"><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>
        </div>
        <div class="span3 offset1 sidebar">
            <?php echo get_sidebar(); ?>
        </div>
    </div>
</div>

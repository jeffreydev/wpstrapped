<div class="col-lg-4 col-md-offset-1 sidebar">
    <?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>

            <aside id="archives" class="widget">
                <h3 class="widget-title"><?php _e( 'Archives', 'wpstrapped' ); ?></h3>

                <ul>
                    <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
                </ul>
            </aside>

            <aside id="meta" class="widget">
                <h3 class="widget-title"><?php _e( 'Meta', 'wpstrapped' ); ?></h3>
                <ul>
                    <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
                </ul>
            </aside>
    <?php endif; // end sidebar widget area ?>
</div>

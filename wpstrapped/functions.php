<?php
/**
 * Register and include twitter bootstrap
 * scripts
 */
function wpstrapped_scripts() {
    wp_register_script('bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array('jquery'));
    wp_enqueue_script('bootstrap');
    
    wp_enqueue_script('backstretch', get_template_directory_uri() . '/js/jquery.backstretch.js');

    /* Font Awesome */
    //wp_enqueue_style('font-awesome-boostrap', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css');
    //wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css');
}

add_action('wp_enqueue_scripts', 'wpstrapped_scripts');




/**
 * Admin Scripts
 * 
 * 
 */
add_action('admin_print_scripts', 'strapped_quicktags');

function strapped_quicktags() {
    wp_enqueue_script('strapped_quicktags', get_template_directory_uri() . '/admin/js/strapped-quicktags.js', array('quicktags'));
}



/*
 * Add theme support for post thumbnails,
 * this also allow you to add a custom 
 * thumnail value, 
 * 
 * uncomment the add_image_size bellow
 * and change accordingly
 * 
 * 
 */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}



/**
 * Register Our Menues for our theme, We can also add more
 * by creating a new menu uption in our array
 * 
 * 
 */
add_action('init', 'wpstrapped_theme_menues');

function wpstrapped_theme_menues() {

    register_nav_menu('primary', __('Primary Menu', 'wpstrapped'));
    register_nav_menu('footer', __('Footer Menu', 'wpstrapped'));
}



/**
 * Add theme support for shortcodes in widgets 
 * 
 * 
 */
add_filter('widget_text', 'do_shortcode');



/**
 * Replaces "[...]" for our excerpt
 */
function wpstrapped_excerpt_more($more) {

    return ' &hellip;' . wpstrapped_continue_reading_link();
}

add_filter('excerpt_more', 'wpstrapped_excerpt_more');



/**
 * Creates our link for read more.
 * 
 *  
 */
function wpstrapped_continue_reading_link() {
    
    if(is_front_page()) 
        return;
    
    return '<p><a class="btn btn-primary btn-lg" href="' . esc_url(get_permalink()) . '">' . __('Continue Reading', 'wpstrapped') . '</a></p>';
}



/*
 * Add comment reply javascript
 * 
 * 
 */

function wpstrapped_threaded_links() {
    if (is_singular()) :
        wp_enqueue_script('comment-reply');
    endif;
}

add_action('wp_head', 'wpstrapped_threaded_links');




/**
 * We need to shorten up our excerpt length here, its way to long,
 * we will do this by hooking into excerpt lenth and returning our new
 * length of 40
 * 
 * 
 */
function wpstrapped_custom_excerpt_length($length) {
    return 40;
}

add_filter('excerpt_length', 'wpstrapped_custom_excerpt_length');




/**
 * Setup for our Widgets Area. This must be included
 * to have the ability to use the widgets area. 
 * 
 */
if (function_exists('register_sidebar')) {

    register_sidebar(array(
        'name' => 'sidebar',
        'before_widget' => '<div class="widget-area">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widg-title"><h3>',
        'after_title' => '</h3></div>',
            )
    );
    

    register_sidebar(array(
        'name' => 'footer',
        'before_widget' => '<div class="widget-area span12">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
            )
    );
}



/**
 * Bread Crumbs
 *  
 */
function wpstrapped_breadcrumb() {

    /* === OPTIONS === */
    $text['home'] = 'Home'; // text for the 'Home' link  
    $text['category'] = 'Archive by Category "%s"'; // text for a category page  
    $text['search'] = 'Search Results for "%s" Query'; // text for a search results page  
    $text['tag'] = 'Posts Tagged "%s"'; // text for a tag page  
    $text['author'] = 'Articles Posted by %s'; // text for an author page  
    $text['404'] = 'Error 404'; // text for the 404 page  

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show  
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show  
    $delimiter = ''; // delimiter between crumbs  
    $before = '<span class="current">'; // tag before the current crumb  
    $after = '</span>'; // tag after the current crumb  
    /* === END OF OPTIONS === */

    global $post;
    $homeLink = get_bloginfo('url') . '/';
    $linkBefore = '<li>';
    $linkAfter = '</li>';
    $linkAttr = ' rel="v:url" property="v:title"';
    $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a><span class="divider">/</span>' . $linkAfter;

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1)
            echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
    } else {

        echo '<ul class="breadcrumb">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
        } elseif (is_search()) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;
        } elseif (is_day()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($showCurrent == 1)
                    echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($showCurrent == 0)
                    $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                if ($showCurrent == 1)
                    echo $before . get_the_title() . $after;
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($showCurrent == 1)
                echo $delimiter . $before . get_the_title() . $after;
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1)
                echo $before . get_the_title() . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1)
                    echo $delimiter;
            }
            if ($showCurrent == 1)
                echo $delimiter . $before . get_the_title() . $after;
        } elseif (is_tag()) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;
        } elseif (is_404()) {
            echo $before . $text['404'] . $after;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ')';
        }

        echo '</ul>';
    }
}



/**
 * Numbered Pagination
 * 
 */
function jdev_pagination() {
    global $wp_query;

    $big = 999999999; // need an unlikely integer

    echo paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
   }
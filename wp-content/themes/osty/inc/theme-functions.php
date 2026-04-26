<?php if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); }

// Menu
function osty_render_menu( $variation = 'default' ) {
    $menu_class = 'navbar-nav';

    if ( class_exists('acf') ) {
        $field = get_field('menu_variation');
        if ( $field ) {
            $menu_class = ( $field === 'default' ) ? 'navbar-nav' : 'navbar-nav-button';
        }
    }

    ob_start();
    wp_nav_menu( array(
        'theme_location' => 'primary-menu',
        'container'      => true,
        'depth'          => 3,
        'menu_id'        => 'primary-menu-' . esc_attr($variation),
        'menu_class'     => $menu_class,
    ) );
    $menu_html = ob_get_clean();

    echo $menu_html;
}

// Theme Mode
function osty_theme_mode() {
    if(get_theme_mod( 'mode_switcher' )) {
        $out = osty_theme_mode_cookie();
    } else {
        if(get_theme_mod( 'theme_mode' )) {
            $out = get_theme_mod( 'theme_mode' );
        } else {
            $out = "light";
        }
    }
    return $out;
}

function osty_theme_mode_cookie() {
    if (empty($_COOKIE["theme-mode"])) {
        if(get_theme_mod( 'theme_mode' )) {
            $theme_mode = get_theme_mod( 'theme_mode' );
        } else {
            $theme_mode = 'light';
        }
        return $theme_mode;
    }
    
    if(!isset($_COOKIE["theme-mode"])) {
        $theme_mode = get_theme_mod( 'theme_mode' );
    } else {
        $theme_mode = $_COOKIE["theme-mode"];
    }
    return $theme_mode;

}
function osty_theme_mode_cheked() {

    $theme_mode = osty_theme_mode_cookie();
    if ($theme_mode === 'light') {
        $cheked = 'checked';
    } else {
        $cheked = '';
    }
    return $cheked;
    
}

// Menu Type
function osty_menu_type() {

    $menu_type = 'default';
    
    if ( class_exists('ACF') && get_field( 'choiсe_menu_page' ) && get_field( 'choiсe_menu_page' ) !== 'global_settings') {
        get_template_part( 'template-parts/menu/' . get_field( 'menu_type_page' ), get_post_format() );
    } else {
        if ( get_theme_mod( 'menu_type' ) ) {
            $menu_type = get_theme_mod( 'menu_type' );
            get_template_part( 'template-parts/menu/' . $menu_type, get_post_format() );
        } else {
            get_template_part( 'template-parts/menu/default', get_post_format() );
        }
    }

}

// Menu Widgets
function osty_menu_cart_widgets() {

    if ( get_theme_mod( 'cart_widget' ) === true ) {
        get_template_part( 'template-parts/menu/widgets/cart' );
    } 
    
}

function osty_search_woo() {

    if ( is_woocommerce() || is_cart() ) { 
        get_product_search_form(); 
    } else {
        get_search_form();
    }

}

// End Menu Widgest

function osty_page_transition() {

    if(get_theme_mod( 'page_transition' ) && get_theme_mod( 'page_transition' ) == '1') {
        $transition = '<div id="loaded"></div>';
        return $transition;
    }

}

// Elementor Templates List Footer
function ms_get_elementor_templates( $type = '' ) {

    $args = [
        'post_type' => 'elementor_library',
        'posts_per_page' => -1,
    ];

    if ( $type ) {

        $args[ 'tax_query' ] = [
            [
                'taxonomy' => 'elementor_library_type',
                'field' => 'slug',
                'terms' => $type,
            ],
        ];

    }

    $page_templates = get_posts( $args );

    $options[0] = esc_html__( 'Select a Template', 'osty' );

    if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ) {
        foreach ( $page_templates as $post ) {
            $options[$post->ID] = $post->post_title;
        }
    } else {

        $options[0] = esc_html__( 'Create a Template First', 'osty' );

    }

    return $options;

}

// Smooth Scroll
function osty_smooth_scroll() {
    if(get_theme_mod( 'smooth_scroll' ) && get_theme_mod( 'smooth_scroll' ) == '1') {
        $out = 'on';
    } else {
        $out = 'off';
    }
    return $out;
}

// Smooth Scroll BTT Button
function osty_bttb_target() {
    $out = '';
    if ( get_theme_mod('top_btn') && get_theme_mod('top_btn') == '1' ) {
        $out = '<div data-scroll-section id="top" class="home"></div>';
    }
    return $out;
}

function ms_render_elementor_template( $template ) {

    if ( ! $template ) {
      return;
    }

    if ( 'publish' !== get_post_status( $template ) ) {
      return;
    }
    if ( did_action( 'elementor/loaded' ) ) {
        $new_frontend = new Elementor\Frontend;
        return $new_frontend->get_builder_content_for_display( $template, false );        
    }

}

// Footer query
function osty_get_footer() {
    $args = array(
        'post_type' => 'elementor_library',
        'posts_per_page' => -1,
    );

    $ps = get_posts( $args );
    return $ps;
}

function osty_show_share_post() {

    if( get_theme_mod( 'share_post' ) && get_theme_mod( 'share_post' ) == '1') {
        echo osty_share_post();
    } 

}

// Sanitize Class
if ( ! function_exists( 'osty_sanitize_class' ) ) {
  function osty_sanitize_class( $class, $fallback = '' ) {

    if ( is_string( $class ) ) {
      $class = explode( ' ', $class );
    }

    if ( is_array( $class ) && count( $class ) > 0 ) {
      $class = array_map( 'sanitize_html_class', $class );
      return implode( ' ', $class );
    } else {
      return sanitize_html_class( $class, $fallback );
    }

  }
}

// Header Class
function osty_header_class() {

    if( class_exists('acf')) {
        if ( get_field( 'choiсe_menu_page' ) && get_field( 'choiсe_menu_page' ) !== 'global_settings') {
            $h_ac = osty_header_custom_page();
        } else {
            $h_ac = osty_header_global_settings();
        }
    } else {
        $h_ac = osty_header_global_settings();
    }

    $menu_class = 'main-header js-main-header auto-hide-header' . $h_ac;

    return osty_sanitize_class($menu_class);

}

// Header Global Settings
function osty_header_global_settings() {

    $menu_align_mod = get_theme_mod('menu_align');

    $menu_align = $menu_align_mod ? ' menu-' . $menu_align_mod : ' menu-right';

    $menu_class = 'main-header js-main-header auto-hide-header' . $menu_align . ' ' . $menu_align_mod;

    return $menu_class;
}

// Header Custom Settings
function osty_header_custom_page() {

    if( class_exists('acf')) {

        if ( get_field( 'choiсe_menu_page' ) && get_field( 'choiсe_menu_page' ) !== 'global_settings') {

            if (is_search()) {
                $h_transparent = $h_white = $full_width = '';
                $menu_align = ' menu-right';
            } else {
                $h_transparent = get_field('header_transparent') == '1' ? ' ms-nb--transparent' : '';
                $h_white = (get_field('header_white') == '1' && $h_transparent) ? ' ms-nb--white' : '';
                $full_width = get_field('full_width') ? ' full-width' : '';
                $menu_align = get_field('menu_align_page') ? ' menu-' . get_field('menu_align_page') : ' menu-right';
            }

            $h_ac = 'main-header js-main-header auto-hide-header' . $h_transparent . $full_width . $h_white . $menu_align;

        } else {
            $h_ac = '';
        }
    } else {
        $h_ac = '';
    }

    return $h_ac;
}

// Header Type
function osty_header_type() {
    $header_style = 'default';
    $default = 'default';

    if ( class_exists('acf') ) {
        $choiсe_menu_page = get_field('choiсe_menu_page');
        if ( $choiсe_menu_page && $choiсe_menu_page !== 'global_settings' ) {
            $header_style = get_field('menu_style');
        } else {
            if ( function_exists('get_theme_mod') ) {
                $header_style = get_theme_mod( 'type_header', $default );
            }
        }
    } else {
        if ( function_exists('get_theme_mod') ) {
            $header_style = get_theme_mod( 'type_header', $default );
        }
    }
    
    return $header_style;
}

// Posts Loop
function osty_posts_loop($items, $cat, $post_id, $order, $orderby) {

    $paged = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : 1;
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $paged,
            'posts_per_page' => $items,
            'category_name' => $cat,
            'post__in' => $post_id,
            'orderby' => $orderby,
            'order' => $order
        );
    $query = new WP_Query($args);
    return $query;
}

// Posts Pagination
function osty_posts_pagination( $new_query = '' ) {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if ( $new_query == '' ) {
        global $wp_query;
        $new_query = $wp_query;
    } 
    /* Stop the code if there is only a single page page */
    if( $new_query->max_num_pages <= 1 )
        return;
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $new_query->max_num_pages );
    /*Add current page into the array */
    if ( $paged >= 1 )
        $links[] = $paged;
    /*Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
    echo '<nav class="pagination" aria-label="Pagination"><ol class="pagination__list">' . "\n";
    /*Display Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="page-item prev">%s </li>' . "\n", get_previous_posts_link(esc_html__( 'Previous', 'osty' )) );
    /*Display Link to first page*/
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class=""' : '';
        printf( '<li%s class=""><a href="%s" class="pagination__item">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
        if ( ! in_array( 2, $links ) )
            echo '<li class=""><span>…</span></li>';
    }
    /* Link to current page */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="page-item active"' : '';
        printf( '<li%s><a href="%s" class="pagination__item">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
    /* Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="display--sm">…</li>' . "\n";
        $class = $paged == $max ? ' class="display--sm"' : '';
        printf( '<li%s class="display--sm"><a href="%s" class="pagination__item pagination__item--ellipsis">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link('Next', $max) )
        printf( '<li class="page-item next">%s </li>' . "\n", get_next_posts_link( esc_html__( 'Next', 'osty' ), $max) );
    echo '</ol></nav>' . "\n";
}

// Related Posts
function osty_related_posts() {

$post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category( $post_id );

    if(!empty($categories) && !is_wp_error($categories)):
        foreach ($categories as $category):
            array_push($cat_ids, $category->term_id);
        endforeach;
    endif;

    $current_post_type = get_post_type($post_id);

    $query_args = array( 
        'category__in'   => $cat_ids,
        'post_type'      => $current_post_type,
        'post__not_in'    => array($post_id),
        'posts_per_page'  => '3',
     );

    $related_cats_post = new WP_Query( $query_args );

    return $related_cats_post;
}

// Socials Custom Plugin
function osty_twitter_share() {
    $posttags = get_the_tags();
    if ($posttags) {
        foreach($posttags as $tag) {
            echo strtolower('#' . $tag->name . ', '); 
        }
    }
}

// Estimated reading time
function osty_reading_time($id) {

    $content = get_post_field( 'post_content', $id );
    $word_count = str_word_count( strip_tags( $content ) );
    $readingtime = ceil($word_count / 200);
    $timer = esc_html__( ' min read', 'osty' );

    $totalreadingtime = $readingtime . $timer;
    return $totalreadingtime;
    
}

// Custom Comments
function osty_comments( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :
		case 'pingback':
		case 'trackback':
		?>
        <li class="post pingback" id="comment-<?php comment_ID(); ?>">
        	<div class="pingback ms-author-name"><?php comment_author_link(); ?></div>
        	<div class="post-date"><?php comment_date(); ?></div>
        	<div class="ms-commentcontent"><?php comment_text();  ?></div>
        	<?php edit_comment_link( __( 'Edit', 'osty' ), '<span class="edit-link">', '</span>' ); ?></p>
    	</li>
		<?php 
		break;
		default: 
		?>
            <li id="comment-<?php comment_ID(); ?>">
            <div <?php comment_class(); ?>>
				<div class="ms-comment-body">
                    <div class="ms-author-vcard">
                        <figure class="avatar__figure" role="img" aria-label="Avatar">
                                <svg class="avatar__placeholder" aria-hidden="true" viewBox="0 0 20 20" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="6" r="2.5" stroke="currentColor"/><path d="M10,10.5a4.487,4.487,0,0,0-4.471,4.21L5.5,15.5h9l-.029-.79A4.487,4.487,0,0,0,10,10.5Z" stroke="currentColor"/></svg>
                            <div class="avatar__img"><?php echo get_avatar( $comment, 56 ); ?></div>
                        </figure>
                    </div>
					<div class="ms-author-vcard-content">
                        <div class="ms-author-vcard--info">
                            <div class="ms-author-name"><?php comment_author(); ?></div>
                            <span class="ms-comment-time"><?php comment_date(); ?></span>
                        </div>					
						<div class="ms-commentcontent">
							<?php comment_text(); ?>
                            <div class="ms-comment-footer">
							<div class="ms-comment-edit">
                                <?php edit_comment_link( $text = '<svg height="14px" version="1.1" viewBox="0 0 24 24" width="14px"><path d="M21.635,6.366c-0.467-0.772-1.043-1.528-1.748-2.229c-0.713-0.708-1.482-1.288-2.269-1.754L19,1C19,1,21,1,22,2S23,5,23,5  L21.635,6.366z M10,18H6v-4l0.48-0.48c0.813,0.385,1.621,0.926,2.348,1.652c0.728,0.729,1.268,1.535,1.652,2.348L10,18z M20.48,7.52  l-8.846,8.845c-0.467-0.771-1.043-1.529-1.748-2.229c-0.712-0.709-1.482-1.288-2.269-1.754L16.48,3.52  c0.813,0.383,1.621,0.924,2.348,1.651C19.557,5.899,20.097,6.707,20.48,7.52z M4,4v16h16v-7l3-3.038V21c0,1.105-0.896,2-2,2H3  c-1.104,0-2-0.895-2-2V3c0-1.104,0.896-2,2-2h11.01l-3.001,3H4z"/></svg>Edit' ); ?></div>
							<div class="ms-comment-reply">
								<?php comment_reply_link( array_merge( $args, array(
									'reply_text' => '<svg height="16px" version="1.1" viewBox="0 0 16 16" width="14px"><g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1"><g fill="none" class="group" transform="translate(0.000000, -336.000000)"><path d="M0,344 L6,339 L6,342 C10.5,342 14,343 16,348 C13,345.5 10,345 6,346 L6,349 L0,344 L0,344 Z M0,344"/></g></g></svg>Reply',
									'depth' => $depth,
									'max_depth' => $args['max_depth'] 
								) ) ); ?>
							</div>
						</div>
						</div>
					</div>
				</div>
            </div>
   	<?php
        break;
    endswitch;
}

// Blog Custom Comments
function osty_comments_number() {

	$comment_count = get_comments_number();
	printf(
	    '<span>' . esc_html__( _nx( '1 comment', '%1$s comments', get_comments_number(), 'comments title', 'osty' ) ) . '</span>',
	    number_format_i18n( get_comments_number() ),
        '<span>' . get_the_title() . '</span>'
	);	
}

// Pagination
function osty_link_pages() {
    wp_link_pages( array(
        'before'      => '<div class="page-links">' . __( 'Pages:', 'osty' ),
        'after'       => '</div>',
        'link_before' => '<span class="page-number">',
        'link_after'  => '</span>',
    ) );
}

// Portfolio Filter
function osty_filter_category() {
    if ( isset($_GET['category']) ) {
        $out = $_GET['category'];
    } else {
        $out = '';
    }
    return $out;
}

// Portfolio Loop
function osty_portfolio_loop($cat, $items, $post_id) {
    $paged = max(1, get_query_var('paged', 1), get_query_var('page', 1));

    $args = [
        'post_type'      => 'portfolios',
        'post_status'    => 'publish',
        'posts_per_page' => $items,
        'paged'          => $paged,
        'post__in'       => $post_id
    ];

    if (!empty($cat)) {
        $args['tax_query'] = [
            [
                'taxonomy'         => 'portfolios_categories',
                'field'            => 'slug',
                'terms'            => (array) $cat,
                'include_children' => false,
            ]
        ];
    }

    return new WP_Query($args);
}

// Get Works Taxonomy
if ( !function_exists( 'osty_works_category' ) ) {
    function osty_work_category($post_id) {
        $terms = wp_get_post_terms($post_id, 'portfolios_categories');
        $count = count($terms);
        $slug = '';
        $out = '';
        if ( $count > 1 ) {
            foreach ( $terms as $term ) {
                $out = implode(', ', array_map(function($term) { return $term->slug; }, $terms));
            }
        } else {
           foreach ( $terms as $term ) {
               $out = $term->name;
            } 
        }
        return $out;
    }
}

// Portfolio pagination
function osty_portfolio_pagination($total_pages, $btntext, $load_btn) {

    $total = $total_pages;
    $out = '<div class="btn-wrap ajax-area' . $load_btn . '" data-max="' . $total . '">';
    $out .= '<div class="btn btn-load-more btn--md">';
    $out .= '<div class="f-btn-l">
                <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                    <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                    <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                </svg>
                <span class="load-more-icon">
                    <svg viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                        <circle class="spin2" cx="400" cy="400" fill="none" r="200" stroke-width="50" stroke-dasharray="563 1400" stroke-linecap="round" />
                    </svg>
                </span>
            </div>';
    $out .= '<div class="f-btn-r">
                    <span>' . $btntext . '</span>
                    <div class="btn-r_icon">
                        <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                            <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                            <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                        </svg>
                    </div>
                </div>';
    $out .= '</div>';
    $out .= '</div>';
    return $out;

}

//Infinite next and previous post looping in WordPress
// Single Portfolio Page Next Link
function osty_portfolio_nav_prev() {

    $prev_post = get_adjacent_post(false, '', true);
    $next_post = get_adjacent_post(false, '', false);

    if ($next_post) { 
        echo '<div class="ms-spn--next">';
        echo '<a href="' . get_permalink($next_post->ID) . '"><span class="ms-spn--text">' . esc_html__( 'Previous', 'osty' ) . '</span></a>';
        echo '</div>';
        $next_title = get_the_title($next_post->ID);
    } else { 
        $last = new WP_Query([
            'post_type'      => 'portfolios',
            'posts_per_page' => 1,
            'order'          => 'ASC',
        ]);
        $last->the_post();
        echo '<div class="ms-spn--next">';
        echo '<a href="' . get_permalink() . '"><span class="ms-spn--text">' . esc_html__( 'Previous', 'osty' ) . '</span></a>';
        echo '</div>';
        $next_title = get_the_title();
        wp_reset_postdata();
    }

    if ($prev_post) { 
        echo '<div class="ms-spn--prev">';
        echo '<a href="' . get_permalink($prev_post->ID) . '"><span class="ms-spn--text">' . esc_html__( 'Next', 'osty' ) . '</span></a>';
        echo '</div>';
        $prev_title = get_the_title($prev_post->ID);
    } else { 
        $first = new WP_Query([
            'post_type'      => 'portfolios',
            'posts_per_page' => 1,
            'order'          => 'DESC',
        ]);
        $first->the_post();
        echo '<div class="ms-spn--prev">';
        echo '<a href="' . get_permalink() . '"><span class="ms-spn--text">' . esc_html__( 'Next', 'osty' ) . '</span></a>';
        echo '</div>';
        $prev_title = get_the_title();
        wp_reset_postdata();
    }
    
    // Nav Titles
    // echo '<div class="ms-spn--title">';
    // echo '<span class="ms-spn--prev-title">' . esc_html__($prev_title) . '</span>';
    // echo '<span class="ms-spn--next-title">' . esc_html__($next_title) . '</span>';
    // echo '</div>';

}


// Load More Button
if( !function_exists( 'osty_infinity_load' ) ){

    function osty_infinity_load($query) {
    
        $max_page = $query->max_num_pages;
        $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
        $display = false;
        $link_url = c_next_posts($max_page, $display);
        wp_localize_script( 'osty-main-script', 'infinity_load', array(
                'startPage' => $paged,
                'maxPages' => $max_page,
                'nextLink' => $link_url
        ) );

    }

    // Check link for php8.1
    function c_next_posts( $max_page, $display ) {
        $link = get_next_posts_page_link( $max_page );
    
        $output = '';
        if( $link ){
            $output = esc_url( $link );
        }
            
            if ( $display ) {
                    echo esc_html__($output);
            } else {
                    return $output;
            }
    }

}

// Custom Excertp
function osty_get_excerpt( $id, $count ){
   $permalink = get_permalink( $id );

   $excerpt = get_the_excerpt();
   $excerpt = strip_tags( $excerpt );
   $excerpt = mb_substr( $excerpt, 0, $count );
   $excerpt = mb_substr( $excerpt, 0, strripos( $excerpt, " " ) );
   $excerpt = rtrim( $excerpt, ",.;:- _!$&#" );
   $excerpt = '<p class="post-excerpt">' . $excerpt . '...' . '</p>';

   return $excerpt;
}

// Custom excerpt lenght
add_filter( 'excerpt_length', function($length) {
    return 24;
}, PHP_INT_MAX );

// WooCommerce

// Live cart-count
function osty_cart_count() {
    if ( WC()->cart->get_cart_contents_count() > 0 ) {
        $cart_count = '<span>' . WC()->cart->get_cart_contents_count() . '</span>';
    } else {
        $cart_count = '';
    }
    return $cart_count;
}
<?php

Class osty_recent_widget_custom extends WP_Widget {

    public function __construct() {
        $widget_details = array(
            'classname' => 'osty_recent_widget_custom',
            'description' => esc_html__('Display Recent Thumbnail Posts.', 'osty')
        );

        parent::__construct('osty_recent_widget_custom', esc_html__('osty: Recent Thumbnail Posts', 'osty'), $widget_details);
    }

    public function widget($args, $instance) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts', 'osty' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number ) {
            $number = 5;
        }
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        // Кэшируем результаты виджета
        $cache_key = 'osty_recent_widget_' . $args['widget_id'];
        $cache = wp_cache_get( $cache_key, 'widget' );

        if ( false !== $cache ) {
            echo $cache;
            return;
        }

        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );

        if ( ! $r->have_posts() ) {
            wp_reset_postdata();
            return;
        }

        ob_start();
        ?>
        <aside class="ms_widget_recent_posts">
        <?php echo $args['before_widget']; ?>
        <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        } ?>
        <ul>
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
            <li class="recent-post">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-image">
                        <?php the_post_thumbnail( 'osty-recent-post-thumb', array( 'alt' => get_the_title() ) ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="recent-post__info">
                        <?php get_the_title() ? the_title() : the_ID(); ?>
                        <?php if ( $show_date ) : ?>
                            <span class="post-date"><?php echo esc_html( get_the_date() ); ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            </li>
        <?php endwhile; ?>
        </ul>
        <?php echo $args['after_widget']; ?>
        </aside>
        <?php
        wp_reset_postdata();

        $cache_output = ob_get_clean();
        echo $cache_output;

        // Сохраняем в кэш на 12 часов
        wp_cache_set( $cache_key, $cache_output, 'widget', 12 * HOUR_IN_SECONDS );
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

        // Очищаем кэш при обновлении виджета
        $this->flush_widget_cache();

        return $instance;
    }

    public function flush_widget_cache() {
        wp_cache_delete( 'osty_recent_widget_' . $this->id, 'widget' );
    }

    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" style="width:50px;" />
        </p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
        <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php _e( 'Display post date?' ); ?></label>
        </p>
        <?php
    }

}

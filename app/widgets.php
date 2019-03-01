<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 01/12/18
 * Time: 23.36
 */

/* ESTENSIONE DEL WIDGET POST */
Class wppa_recent_posts_widget extends WP_Widget_Recent_Posts {
    function widget($args, $instance) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : _( 'Ultimi Articoli' );
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );
        if ($r->have_posts()) :
            ?>
            <?php echo $args['before_widget']; ?>
            <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        } ?>

            <div class="row widget_last_post">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <div class="col-3 widget_last_post_wrap">
                        <div class="widget_last_post_inner">
                            <!--<a href="<?php the_permalink(); ?>">-->
                            <!--  <?php the_post_thumbnail('thumbnail', array('class' => 'rounded float-right')); ?>-->
                            <!--</a>-->
                            <h5><strong>&#9679; <?php the_category( ', ' ); ?></strong></h5>
                            <h5><?php the_time( get_option( 'date_format' ) ); ?></h5>
                            <h4><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h4>
                            <p><?php the_excerpt(); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>



            <?php echo $args['after_widget']; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();
        endif;
    }
}

class Category_Posts extends WP_Widget {

    public function __construct()
    {
        parent::__construct(
            'widget_category_posts',
            _x( 'DesignItalia - Articoli per categoria', 'DesignItalia - Articoli per categoria' ),
            [ 'description' => __( 'Widget che visualizza gli articoli di una categoria selezionata in stile Masonry.' ) ]
        );
        $this->alt_option_name = 'widget_category_posts';

        add_action( 'save_post', [$this, 'flush_widget_cache'] );
        add_action( 'deleted_post', [$this, 'flush_widget_cache'] );
        add_action( 'switch_theme', [$this, 'flush_widget_cache'] );
    }

    public function widget( $args, $instance )
    {
        $cache = [];
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'widget_cat_posts', 'widget' );
        }

        if ( ! is_array( $cache ) ) {
            $cache = [];
        }

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();

        $title          = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Category Posts' );
        /** This filter is documented in wp-includes/default-widgets.php */
        $title          = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number         = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number ) {
            $number = 5;
        }
        $cat_id         = $instance['cat_id'];
        $random         = $instance['rand'] ? true : false;
        $excerpt        = $instance['excerpt'] ? true : false;
        $thumbnail      = $instance['thumbnail'] ? true : false;

        /**
         * Filter the arguments for the Category Posts widget.
         * @since 1.0.0
         * @see WP_Query::get_posts()
         * @param array $args An array of arguments used to retrieve the category posts.
         */
        if( true === $random ) {
            $query_args = [
                'posts_per_page'    => $number,
                'cat'               => $cat_id,
                'orderby'           => 'rand'
            ];
        }else{
            $query_args = [
                'posts_per_page'    => $number,
                'cat'               => $cat_id,
            ];
        }
        $q = new WP_Query( apply_filters( 'category_posts_args', $query_args ) );

        if( $q->have_posts() ) {

            echo '<div class="widget_category_mansory">';
            echo $args['before_widget'];
            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            echo '<div class="card-columns">';

            while( $q->have_posts() ) {
                $q->the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?> >
                    <?php
                    if ( has_post_thumbnail() && true === $thumbnail ) { ?>

                        <div class="card-img-top">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php the_post_thumbnail( 'large' ); ?>
                            </a>
                        </div><!--/.post-thumbnail-->
                        <?php
                    }
                    ?>
                    <div class="card-body">

                        <header class="entry-header">
                            <?php the_title( '<h4 class="card-title">', '</h4>' ); ?>
                        </header><!-- .entry-header -->

                        <?php if( true === $excerpt ) { ?>

                            <div class="card-text">
                                <?php the_excerpt(); ?>
                            </div><!-- .entry-summary -->
                        <?php } ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="btn btn-primary">Leggi tutto</a>
                    </div>

                </article><!-- #post-## -->

                <?php
            }

            echo '</div>';
            echo '</div>';

            wp_reset_postdata();
        }
        echo $args['after_widget'];

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_cat_posts', $cache, 'widget' );
        } else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance )
    {
        $instance                   = $old_instance;
        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['number']         = (int) $new_instance['number'];
        $instance['cat_id']         = (int) $new_instance['cat_id'];
        $instance['rand']           = $new_instance['rand'];
        $instance['excerpt']        = $new_instance['excerpt'];
        $instance['thumbnail']      = $new_instance['thumbnail'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_category_posts']) )
            delete_option('widget_category_posts');

        return $instance;
    }

    public function flush_widget_cache()
    {
        wp_cache_delete('widget_cat_posts', 'widget');
    }

    public function form( $instance )
    {

        $title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $cat_id     = isset( $instance['cat_id'] ) ? absint( $instance['cat_id'] ) : 1;
        $random     = isset( $instance['rand'] ) ? $instance['rand'] : false;
        $excerpt    = isset( $instance['excerpt'] ) ? $instance['excerpt'] : false;
        $thumbnail  = isset( $instance['thumbnail'] ) ? $instance['thumbnail'] : false;
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Numero di articoli da visualizzare:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>" size="3" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('cat_id'); ?>"><?php _e( 'Seleziona la categoria:' )?></label>
            <select id="<?php echo $this->get_field_id('cat_id'); ?>" name="<?php echo $this->get_field_name('cat_id'); ?>">
                <?php
                $this->categories = get_categories();
                foreach ( $this->categories as $cat ) {
                    $selected = ( $cat->term_id == esc_attr( $cat_id ) ) ? ' selected = "selected" ' : '';
                    $option = '<option '.$selected .'value="' . $cat->term_id;
                    $option = $option .'">';
                    $option = $option .$cat->name;
                    $option = $option .'</option>';
                    echo $option;
                }
                ?>
            </select>
        </p>

        <p>
            <?php $checked = ( $random ) ? ' checked=\"checked\" ' : ''; ?>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'rand' ); ?>" name="<?php echo $this->get_field_name( 'rand' ); ?>" value="true" <?php echo $checked; ?> />
            <label for="<?php echo $this->get_field_id('rand'); ?>"><?php _e( 'Visualizza articoli casualmente' ); ?></label>
        </p>

        <p>
            <?php $checked = ( $excerpt ) ? ' checked=\"checked\" ' : ''; ?>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" value="true" <?php echo $checked; ?> />
            <label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e( 'Visualizza estratto. Se deselezionato, visualizza solo il titolo dell\'articolo' ); ?></label>
        </p>

        <p>
            <?php $checked = ( $thumbnail ) ? ' checked=\"checked\" ' : ''; ?>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" value="true" <?php echo $checked; ?> />
            <label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e( 'Visualizza le thumbnails degli articoli' ); ?></label>
        </p>

        <?php
    }

}

add_action('widgets_init', function (){
    unregister_widget('WP_Widget_Recent_Posts');
    register_widget('wppa_recent_posts_widget');
    register_widget( 'Category_Posts' );
});


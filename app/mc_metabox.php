<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 19/02/19
 * Time: 15.20
 */

namespace App;


class mc_metabox
{
    public function __construct() {

        add_action( 'add_meta_boxes', array( $this, 'mc_meta_box' ) );

        add_action( 'save_post', array( $this, 'mc_field_data' ) );

    }

    public function mc_meta_box() {

        // Retrieve all post types and add meta box to all post types, including custom post types
        $post_types = get_post_types();

        foreach ( $post_types as $post_type ) {

            add_meta_box (
                'main_category',
                __( 'Categoria Principale', 'wpdi' ),
                array( $this, 'mc_meta_box_content' ),
                $post_type,
                'side',
                'high'
            );

        }

    }

    public function mc_meta_box_content() {

        global $post;

        $main_category = '';

        // Retrieve data from primary_category custom field
        $current_selected = get_post_meta( $post->ID, 'main_category', true );

        // Set variable so that select element displays the set primary category on page load
        if ( $current_selected != '' ) {
            $main_category = $current_selected;
        }

        // Get list of categories associated with post
        $post_categories = get_the_category();

        $html = '<select name="main_category" id="main_category">';

        // Load each associated category into select element and display set primary category on page load
        $html .= '<option value="">Nessuno</option>';
        foreach( $post_categories as $category ) {
            $html .= '<option value="' . $category->term_id . '" ' . selected( $main_category, $category->term_id, false ) . '>' . $category->name . '</option>';
        }

        $html .= '</select>';

        echo $html;

    }

    public function mc_field_data() {

        global $post;

        if ( isset( $_POST[ 'main_category' ] ) ) {

            $main_category = sanitize_text_field( $_POST[ 'main_category' ] );

            update_post_meta( $post->ID, 'main_category', $main_category );

        }

    }
}

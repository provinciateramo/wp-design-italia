<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 27/02/19
 * Time: 8.06
 */

namespace App\Metabox;


class MainCategoryMetabox extends BaseMetabox
{
    public function add_meta_box() {

        // Retrieve all post types and add meta box to all post types, including custom post types
        $post_types = get_post_types();

        foreach ( $post_types as $post_type ) {

            add_meta_box (
                'main_category',
                __( 'Categoria Principale', 'wpdi' ),
                array( $this, 'meta_box_content' ),
                $post_type,
                'side',
                'high'
            );

        }

    }

    public function meta_box_content($post) {

        global $post;

        $main_category = '';

        // Retrieve data from primary_category custom field
        $current_selected = get_post_meta( $post->ID, 'main_category', true );

        // Set variable so that select element displays the set primary category on page load
        if ( $current_selected != '' ) {
            $main_category = $current_selected;
        }
        wp_nonce_field( basename( __FILE__ ), 'mc_post_class_nonce' );
        // Get list of categories associated with post
        $post_categories = get_the_category();
        $html ='<div class="components-base-control editor-post-excerpt__textarea"><div class="components-base-control__field">';
        $html .= '<select name="main_category" id="main_category">';

        // Load each associated category into select element and display set primary category on page load
        $html .= '<option value="">Nessuno</option>';
        foreach( $post_categories as $category ) {
            $html .= '<option value="' . $category->term_id . '" ' . selected( $main_category, $category->term_id, false ) . '>' . $category->name . '</option>';
        }

        $html .= '</select></div></div>';

        echo $html;

    }

    public function save_field_data($post_id) {

        if ( isset( $_POST[ 'main_category' ] ) ) {

            $main_category = sanitize_text_field( $_POST[ 'main_category' ] );

            update_post_meta( $post_id, 'main_category', $main_category );

        }

    }
}

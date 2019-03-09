<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 27/02/19
 * Time: 8.12
 */

namespace App\Metabox;


class ShowSidebarMetabox extends BaseMetabox
{
    public function add_meta_box() {

        // Retrieve all post types and add meta box to all post types, including custom post types
        $post_types = get_post_types();

        foreach ( $post_types as $post_type ) {
            if (in_array($post_type, \App\WPDI_CPT\WpdiCpt::$wpdi_cpt)) {
                add_meta_box(
                    'sidebar_meta_box',
                    __( 'Barra laterale', 'sidebar_show_settings' ),
                    array( $this, 'meta_box_content' ),
                    $post_type,
                    'advanced',
                    'default'
                );
            }
        }

    }

    public function meta_box_content($post) {

        global $post;

        wp_nonce_field( basename( __FILE__ ), 'sidebar_meta_box_nonce' );
        // retrieve the _food_cholesterol current value
        $current_sidebar = get_post_meta( $post->ID, '_sidebar_current', true ) || 'primary-sidebar';
        // retrieve the _food_carbohydrates current value
        $show_sidebar = boolval(get_post_meta( $post->ID, '_sidebar_show', true )!='' ? get_post_meta( $post->ID, '_sidebar_show', true ) : 1);
        $sidebars = $GLOBALS['wp_registered_sidebars'];

        ?>
        <div class='inside'>

            <h3><?php _e( 'Mostra Sidebar', 'wpdi' ); ?></h3>
            <p>
                <input type="radio" name="sidebar_show" value="1" <?php checked( $show_sidebar, true ); ?> /> Si<br />
                <input type="radio" name="sidebar_show" value="0" <?php checked( $show_sidebar, false ); ?> /> No
            </p>

            <h3><?php _e( 'Sidebar da visualizzare', 'sage' ); ?></h3>
            <p>
                <select name="sidebar_current">
                    <?php
                    foreach ( $sidebars as $sidebar ) {
                        ?>
                        <option value="<?php echo $sidebar['id']; ?>" <?php selected($sidebar['id'],$current_sidebar)?>><?php echo $sidebar['name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>
            </p>
        </div>
        <?php

    }

    public function save_field_data($post_id) {

        if ( !isset( $_POST['sidebar_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['sidebar_meta_box_nonce'], basename( __FILE__ ) ) ){
            return;
        }
        // return if autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }
        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ){
            return;
        }
        // salvataggio preferenze sidebar
        if ( isset( $_REQUEST['sidebar_show'] ) ) {
            update_post_meta( $post_id, '_sidebar_show', sanitize_text_field( $_POST['sidebar_show']) );
        }
        if ( isset( $_REQUEST['sidebar_current'] ) ) {
            update_post_meta( $post_id, '_sidebar_current', sanitize_text_field( $_POST['sidebar_current'] ) );
        }


    }
}

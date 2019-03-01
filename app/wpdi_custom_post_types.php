<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 26/02/19
 * Time: 22.52
 */

namespace App;


class wpdi_custom_post_types
{
    public function __construct() {

        add_action( 'init', array( $this, 'add_comunicato' ), 0 );

    }

    public function add_comunicato() {
        $labels = array(
            'name'                  => _x( 'Comunicati', 'Post Type General Name', 'wpdi' ),
            'singular_name'         => _x( 'Comunicato', 'Post Type Singular Name', 'wpdi' ),
            'menu_name'             => __( 'Comunicati', 'wpdi' ),
            'name_admin_bar'        => __( 'Comunicato', 'wpdi' ),
            'archives'              => __( 'Archivio dei Comunicati', 'wpdi' ),
            'attributes'            => __( 'Item Attributes', 'wpdi' ),
            'parent_item_colon'     => __( 'Parent Item:', 'wpdi' ),
            'all_items'             => __( 'Tutti i Comunicati', 'wpdi' ),
            'add_new_item'          => __( 'Nuovo Comunicato', 'wpdi' ),
            'add_new'               => __( 'Aggiungi nuovo', 'wpdi' ),
            'new_item'              => __( 'Nuovo', 'wpdi' ),
            'edit_item'             => __( 'Modifica', 'wpdi' ),
            'update_item'           => __( 'Aggiorna', 'wpdi' ),
            'view_item'             => __( 'Visualizza', 'wpdi' ),
            'view_items'            => __( 'Mostra elementi', 'wpdi' ),
            'search_items'          => __( 'Cerca Comunicato', 'wpdi' ),
            'not_found'             => __( 'Not found', 'wpdi' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'wpdi' ),
            'featured_image'        => __( 'Featured Image', 'wpdi' ),
            'set_featured_image'    => __( 'Set featured image', 'wpdi' ),
            'remove_featured_image' => __( 'Remove featured image', 'wpdi' ),
            'use_featured_image'    => __( 'Use as featured image', 'wpdi' ),
            'insert_into_item'      => __( 'Insert into item', 'wpdi' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpdi' ),
            'items_list'            => __( 'Items list', 'wpdi' ),
            'items_list_navigation' => __( 'Items list navigation', 'wpdi' ),
            'filter_items_list'     => __( 'Filter items list', 'wpdi' ),
        );
        $args = array(
            'label'                 => __( 'Comunicato', 'wpdi' ),
            'description'           => __( 'Comunicato Stampa', 'wpdi' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky', 'page-attributes' ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'show_in_rest'          => true,
            'capability_type'       => 'post',
        );
        register_post_type( 'comunicato', $args );
    }
}

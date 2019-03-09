<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 07/03/19
 * Time: 7.47
 */

namespace App\WPDI_CPT;

global $default_cpt_labels, $default_cpt_settings;

$default_cpt_labels = array(
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

$default_cpt_settings = array(
    'label'                 => __( 'Comunicato', 'wpdi' ),
    'description'           => __( 'Comunicato Stampa', 'wpdi' ),
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

class WpdiCpt
{
    private $cpt_icon = '';
    private $cpt_name = '';
    private $use_metaboxes = false;
    private $custom_labels = array();
    private $custom_cpt_setting = array();
    public static $wpdi_cpt = array();

    public function __construct($name, $singular_name, $plural_name, $description, $icon, $use_metaboxes=false, $supports = false, $labels = false ) {

        global $default_cpt_labels, $default_cpt_settings;


        if ($labels)
            array_replace($this->custom_labels, $labels);
        else
            $this->custom_labels = $default_cpt_labels;

        $this->custom_labels['name'] =  _x( $plural_name, 'Post Type General Name', 'wpdi' );
        $this->custom_labels['singular_name'] =  _x( $singular_name, 'Post Type Singular Name', 'wpdi' );
        $this->custom_labels['menu_name'] =  __( $singular_name, 'wpdi' );
        $this->custom_labels['name_admin_bar'] =  __( $singular_name, 'wpdi' );
        $this->custom_labels['archives'] =  __( "Archivio dei $plural_name", 'wpdi' );
        $this->custom_labels['all_items'] =  __( "Tutti i $plural_name", 'wpdi' );
        $this->custom_labels['add_new_item'] =  __( "Nuovo $singular_name", 'wpdi' );
        $this->custom_labels['view_items'] =  __( "Visualizza $plural_name", 'wpdi' );
        $this->custom_labels['search_items'] =  __( "Cerca $singular_name", 'wpdi' );
        $this->use_metaboxes = $use_metaboxes;
        $this->cpt_icon = $icon;
        $this->cpt_name = $name;

        //array_replace($this->custom_cpt_setting, $default_cpt_settings);
        $this->custom_cpt_setting = $default_cpt_settings;
        $this->custom_cpt_setting = $default_cpt_settings;
        $this->custom_cpt_setting['label'] = __( $singular_name, 'wpdi' );
        $this->custom_cpt_setting['labels'] = $this->custom_labels;
        $this->custom_cpt_setting['description'] = __( $description, 'wpdi' );
        $this->custom_cpt_setting['supports'] = $supports ? $supports:$default_cpt_settings['supports'];

        add_action( 'init', array( $this, 'add_cpt' ), 0 );

    }

    public function add_cpt() {
        //echo var_dump($this->custom_cpt_setting);
        register_post_type( $this->cpt_name, $this->custom_cpt_setting );
        if ($this->use_metaboxes)
            array_push(self::$wpdi_cpt, $this->cpt_name);
    }
}


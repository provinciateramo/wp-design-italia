<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 07/03/19
 * Time: 7.47
 *
 * @package App\WPDI_CPT
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
	'label'               => __( 'Comunicato', 'wpdi' ),
	'description'         => __( 'Comunicato Stampa', 'wpdi' ),
	'supports'            => array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'trackbacks',
		'custom-fields',
		'comments',
		'revisions',
		'sticky',
		'page-attributes',
	),
	'taxonomies'          => array( 'category', 'post_tag' ),
	'hierarchical'        => false,
	'public'              => true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'menu_position'       => 5,
	'show_in_admin_bar'   => true,
	'show_in_nav_menus'   => true,
	'can_export'          => true,
	'has_archive'         => true,
	'exclude_from_search' => false,
	'publicly_queryable'  => true,
	'show_in_rest'        => false,
	'capability_type'     => 'post',
);

/**
 * Class Wpdi_CPT
 *
 * Classe generica per gestire i tipi di contenuto.
 *
 * @package App\WPDI_CPT
 */
class Wpdi_CPT {
	/**
	 * Icona del del tipo di contenuto.
	 *
	 * @var string
	 */
	private $cpt_icon = '';
	/**
	 * Nome breve del tipo di contenuto.
	 *
	 * @var string
	 */
	private $cpt_name = '';
	/**
	 * Abilita i metabox per questo tipo di contenuto.
	 *
	 * @var bool
	 */
	private $use_metaboxes = false;
	/**
	 * Etichette personalizzate per questo tipo di contenuto.
	 *
	 * @var array
	 */
	private $custom_labels = array();
	/**
	 * Tassonomia personalizzata per questo tipo di contenuto.
	 *
	 * @var array
	 */
	private $taxonomy = false;
	/**
	 * Impostazioni personalizzate per questo tipo di contenuto.
	 *
	 * @var array
	 */
	private $custom_cpt_setting = array();
	/**
	 * Array dei tipi di contenuto generati dal tema.
	 *
	 * @var array
	 */
	public static $wpdi_cpt = array( 'post', 'page' );

	/**
	 * WpdiCpt constructor.
	 *
	 * @param string $name Nome del tipo di contenuto.
	 * @param string $singular_name Nome al singolare del tipo di contenuto.
	 * @param string $plural_name Nome al plurale del tipo di contenuto.
	 * @param string $description Descrizione lunga del tipo di contenuto.
	 * @param string $icon Icona del tipo di contenuto.
	 * @param bool   $use_metaboxes Abilita uso dei metabox per questo tipo di contenuto.
	 * @param bool   $use_gutenberg Abilita editor Gutenberg per questo tipo di contenuto.
	 * @param array  $remove_supports Sezioni da disabilitare.
	 * @param array  $cpt_settings Impostazioni particolari per questo tipo di contenuto.
	 * @param array  $labels Etichette personalizzate per per questo tipo di contenuto.
	 * @param array  $taxonomy Tassonomia personalizzata per per questo tipo di contenuto.
	 */
	public function __construct( $name, $singular_name, $plural_name, $description, $icon, $use_metaboxes = false, $use_gutenberg = false, $remove_supports = array(), $cpt_settings = false, $labels = false, $taxonomy = false ) {

		global $default_cpt_labels, $default_cpt_settings;

		if ( $cpt_settings ) {
			$this->custom_cpt_setting = array_replace( $this->custom_cpt_setting, $cpt_settings );
		} else {
			$this->custom_cpt_setting                = $default_cpt_settings;
			$this->custom_cpt_setting['label']       = __( $singular_name, 'wpdi' );
			$this->custom_cpt_setting['description'] = __( $description, 'wpdi' );
		}
		$this->custom_cpt_setting['show_in_rest'] = $use_gutenberg;
		if ($remove_supports)
			$this->custom_cpt_setting['supports'] = array_diff($this->custom_cpt_setting['supports'], $remove_supports);

		if ( $labels ) {
			$this->custom_labels = array_replace( $this->custom_labels, $labels );
		} else {
			$this->custom_labels                 = $default_cpt_labels;
			$this->custom_labels['archives']     = __( 'Archivio dei ' . $plural_name, 'wpdi' );
			$this->custom_labels['all_items']    = __( 'Tutti i ' . $plural_name, 'wpdi' );
			$this->custom_labels['add_new_item'] = __( 'Nuovo ' . $singular_name, 'wpdi' );
			$this->custom_labels['view_items']   = __( 'Visualizza ' . $plural_name, 'wpdi' );
			$this->custom_labels['search_items'] = __( 'Cerca ' . $singular_name, 'wpdi' );
		}

		$this->custom_labels['name']           = _x( $plural_name, 'Post Type General Name', 'wpdi' );
		$this->custom_labels['singular_name']  = _x( $singular_name, 'Post Type Singular Name', 'wpdi' );
		$this->custom_labels['menu_name']      = __( $singular_name, 'wpdi' );
		$this->custom_labels['name_admin_bar'] = __( $singular_name, 'wpdi' );
		$this->use_metaboxes                   = $use_metaboxes;
		$this->cpt_icon                        = $icon;
		$this->cpt_name                        = $name;

		$this->custom_cpt_setting['labels'] = $this->custom_labels;
        $this->taxonomy = $taxonomy;
		add_action( 'init', array( $this, 'add_cpt' ), 0 );
	}

	/**
	 * Registra il tipo di contenuto in WordPress
	 */
	public function add_cpt() {
		register_post_type( $this->cpt_name, $this->custom_cpt_setting );
		if ( $this->use_metaboxes ) {
			array_push( self::$wpdi_cpt, $this->cpt_name );
		}
		if ($this->taxonomy) {
			register_taxonomy($this->taxonomy['name'], array( $this->cpt_name,), $this->taxonomy['data'], 10);
		}
	}
}

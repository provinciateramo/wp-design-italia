<?php

// namespace App;

/**
 * An example file demonstrating how to add all controls.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.12
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Theme customizer
 */

function kirki_update_url( $config ) {
	$config['url_path'] = plugins_url() . '/kirki/';

	return $config;
}

add_filter( 'kirki/config', 'kirki_update_url' );

add_action(
	'customize_register',
	function ( WP_Customize_Manager $wp_customize ) {
		// Add postMessage support.
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			[
				'selector'        => '.brand',
				'render_callback' => function () {
					bloginfo( 'name' );
				},
			]
		);

		$wp_customize->remove_control( 'display_header_text' );
		// TAGLINE: SHOW / HIDE SWITCH.
		$wp_customize->add_setting(
			'tagline_visibility',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'tagline_visibility',
				array(
					'label'    => __( 'Visibilità sottotitolo', 'wppa_teramo' ),
					'section'  => 'title_tagline',
					'settings' => 'tagline_visibility',
					'type'     => 'select',
					'choices'  => array(
						''  => 'Mostra',
						'0' => 'Nascondi',
					),
				)
			)
		);

		$wp_customize->add_setting(
			'wppa_head_color',
			array(
				'default'           => '#0066cc',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'wppa_custom_accent_color',
				array(
					'label'    => __( 'Colore della testata', 'wppa' ),
					'section'  => 'colors',
					'settings' => 'wppa_head_color',
				)
			)
		);

		$wp_customize->add_setting(
			'wppa_link_color',
			array(
				'default'           => '#0066cc',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'header_textcolor',
				array(
					'label'    => __( 'Colore dei link', 'wppa' ),
					'section'  => 'colors',
					'settings' => 'wppa_link_color',
				)
			)
		);

		$wp_customize->add_setting(
			'wppa_button_color',
			array(
				'default'           => '#65dde0',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'wppa_custom_button_color',
				array(
					'label'    => __( 'Colore dei pulsanti', 'wppa' ),
					'section'  => 'colors',
					'settings' => 'wppa_button_color',
				)
			)
		);

		$wp_customize->add_setting(
			'wppa_footer_color',
			array(
				'default'           => '#00264d',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'wppa_custom_footer_color',
				array(
					'label'    => __( 'Colore del footer', 'wppa' ),
					'section'  => 'colors',
					'settings' => 'wppa_footer_color',
				)
			)
		);

		$wp_customize->add_setting(
			'wppa_footer_link',
			array(
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'wppa_custom_footer_link',
				array(
					'label'    => __( 'Colore dei link nel footer', 'wppa' ),
					'section'  => 'colors',
					'settings' => 'wppa_footer_link',
				)
			)
		);
	}
);


// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * First of all, add the config.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/config.html
 */

Kirki::add_config(
	'teramo_settings',
	array(
		'capability'     => 'edit_theme_options',
		'option_type'    => 'theme_mod',
		'disable_output' => true,
	)
);

/**
 * Add a panel.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/panels.html
 */


$panels = array(
	'single_post_settings' => array(
		'priority'    => 99,
		'title'       => esc_html__( 'Impostazioni articolo', 'wppa' ),
		'description' => esc_html__( 'Permette di cambiare le impostazioni dei singoli articoli', 'wppa' ),
		'sections'    => array(),
	),
	'default'              => array( 'sections' => array() ),
);

$panels['single_post_settings']['sections'] = array(
	'blog'           => array(
		esc_html__( 'Metadati', 'wppa' ),
		esc_html__( 'Imposta la visibilità dei metadati.', 'wppa' ),
		1,
	),
	'featured_image' => array(
		esc_html__( 'Immagine in evidenza', 'wppa' ),
		esc_html__( 'Impostazioni per la gestione dell\'immagine in evidenaa del singolo post', 'wppa' ),
		2,
	),
);

$panels = array(
	'social_media' => array(
		'priority' => 99,
		'title'    => esc_html__( 'Social media', 'wppa' ),
		'sections' => array(),
	),
	'default'      => array( 'sections' => array() ),
);

$panels['social_media']['sections'] = array(
	'social_links'   => array(
		esc_html__( 'Link Social media', 'wppa' ),
		esc_html__( 'Inserisci l\'elenco dei link ai social media', 'wppa' ),
		1,
	),
	'social_sharing' => array(
		esc_html__( 'Condivisione dei contenuti', 'wppa' ),
		esc_html__( 'Configura i pulsanti per le condivisioni sui social media ', 'wppa' ),
		2,
	),
);

$panels['default']['sections'] = array(
	'footer' => array( __( 'Footer', 'customizer_footer_sections' ), '', 99 ),
);


foreach ( $panels as $panel_id => $panel ) {
	$k_panel_id = str_replace( '-', '_', $panel_id ) . 'panel';
	if ( 'default' !== $panel_id ) {
		Kirki::add_panel( $k_panel_id, $panel );
	}
	foreach ( $panel['sections'] as $section_id => $section ) {
		$section_args = array(
			'title'       => $section[0],
			'description' => $section[1],
			'priority'    => $section[2],
			'panel'       => 'default' === $panel_id ? '' : $k_panel_id,
		);
		if ( isset( $section[3] ) ) {
			$section_args['type'] = $section[3];
		}
		Kirki::add_section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
	}
}


/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function my_config_kirki_add_field( $args ) {
	Kirki::add_field( 'teramo_settings', $args );
}


my_config_kirki_add_field(
	array(
		'type'        => 'checkbox',
		'settings'    => 'single_post_show_author',
		'label'       => esc_html__( 'Mostra autore del contenuto', 'wppa' ),
		'description' => esc_html__( 'Se selezioni questa opzione, verrà mostrato l\'autore del singolo articolo.', 'wppa' ),
		'section'     => 'blog_section',
		'default'     => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'checkbox',
		'settings'    => 'single_post_hide_related_posts',
		'label'       => esc_html__( 'Nascondi articoli correlati?', 'wppa' ),
		'description' => esc_html__( 'Se selezioni questa opzione, gli articoli correlati non saranno visualizzati nel singolo articolo.', 'wppa' ),
		'section'     => 'blog_section',
		'default'     => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'number',
		'settings' => 'custom_excerpt_length',
		'label'    => esc_html__( 'Numero di parole per anteprima', 'wppa' ),
		'section'  => 'blog_section',
		'default'  => 30,
		'choices'  => [
			'min'  => 10,
			'max'  => 100,
			'step' => 5,
		],
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'checkbox',
		'settings'    => 'single_post_show_thumbnail',
		'label'       => esc_html__( 'Mostra immagine in evidenza sul singolo articolo?', 'wppa' ),
		'description' => esc_html__( 'Se selezioni questa opzione, l\'immagine in evidenza non sarà visualizzata nel singolo articolo.', 'wppa' ),
		'section'     => 'featured_image_section',
		'default'     => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'radio',
		'settings' => 'single_post_align_thumbnail',
		'label'    => esc_html__( 'Allineamento immagine in evidenza', 'wppa' ),
		'section'  => 'featured_image_section',
		'default'  => 'alignright',
		'priority' => 10,
		'choices'  => [
			'right'  => esc_html__( 'Destra', 'wppa' ),
			'left'   => esc_html__( 'Sinistra', 'wppa' ),
			'center' => esc_html__( 'Centro', 'wppa' ),
			'hero'   => esc_html__( 'Grande', 'wppa' ),
			'none'   => esc_html__( 'Nessun allineamento', 'wppa' ),
		],
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'switch',
		'settings' => 'single_post_show_caption',
		'label'    => esc_html__( 'Mostra didascalia', 'wpdi' ),
		'section'  => 'featured_image_section',
		'default'  => false,
		'choices'  => array(
			'on'  => esc_html__( 'Si', 'wppa' ),
			'off' => esc_html__( 'No', 'wppa' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'textarea',
		'settings' => 'footer_text',
		'label'    => esc_html__( 'Testo fondo pagina', 'wppa' ),
		'section'  => 'footer_section',
		'default'  => esc_html__( 'Provincia di Teramo Via G. Milli, 2 - CAP. 64100 - Teramo - Centr. 0861 3311 - Fax 0861 331206 - C.F. 80001070673', 'wppa' ),
		'priority' => 10,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'switch',
		'settings' => 'footer_show_main_menu',
		'label'    => esc_html__( 'Mostra menu principale', 'wppa' ),
		'section'  => 'footer_section',
		'default'  => true,
		'choices'  => array(
			'on'  => esc_html__( 'Si', 'wppa' ),
			'off' => esc_html__( 'No', 'wppa' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'radio-image',
		'settings' => 'footer_columns_schema',
		'label'    => esc_html__( 'Schema colonne del footer', 'wppa' ),
		'section'  => 'footer_section',
		'default'  => '4-8',
		'priority' => 10,
		'choices'  => [
			'0'       => get_template_directory_uri() . '/assets/images/customizer/0.png',
			// 'Disable Footer Widgets'.
			'12'      => get_template_directory_uri() . '/assets/images/customizer/12.png',
			// '1 Column'.
			'6-6'     => get_template_directory_uri() . '/assets/images/customizer/6-6.png',
			// '2 Columns: Equal Sizes',
			'4-8'     => get_template_directory_uri() . '/assets/images/customizer/4-8.png',
			// '2 Columns: 4-8',
			'8-4'     => get_template_directory_uri() . '/assets/images/customizer/8-4.png',
			// '2 Columns: 8-4',
			'4-4-4'   => get_template_directory_uri() . '/assets/images/customizer/4-4-4.png',
			// '3 Columns: Equal Sizes',
			'6-3-3'   => get_template_directory_uri() . '/assets/images/customizer/6-3-3.png',
			// '3 Columns: 6-3-3',
			'3-3-6'   => get_template_directory_uri() . '/assets/images/customizer/3-3-6.png',
			// '3 Columns: 3-3-6',
			'3-4-5'   => get_template_directory_uri() . '/assets/images/customizer/3-4-5.png',
			// '3 Columns: 3-4-5',
			'5-4-3'   => get_template_directory_uri() . '/assets/images/customizer/5-4-3.png',
			// '3 Columns: 5-4-3',
			'3-3-3-3' => get_template_directory_uri() . '/assets/images/customizer/3-3-3-3.png',
			// '4 Columns: Equal Sizes',

		],
	)
);

my_config_kirki_add_field(
	array(
		'type'        => 'switch',
		'settings'    => 'sl_replace_menu',
		'label'       => esc_html__( 'Mostra nel menu dell\'intestazione', 'wppa' ),
		'description' => esc_html__( 'Se attivo le icone verranno mostrate al posto del menu presente nell\'intestazione', 'kirki' ),
		'section'     => 'social_links_section',
		'default'     => true,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'switch',
		'settings' => 'sl_show_label',
		'label'    => esc_html__( 'Mostra etichetta', 'wppa' ),
		'section'  => 'social_links_section',
		'default'  => false,
		'choices'  => array(
			'on'  => esc_html__( 'Si', 'wppa' ),
			'off' => esc_html__( 'No', 'wppa' ),
		),
	)
);

my_config_kirki_add_field(
	array(
		'type'         => 'repeater',
		'label'        => esc_html__( 'Social media link', 'wppa' ),
		'section'      => 'social_links_section',
		'priority'     => 10,
		'row_label'    => [
			'type'  => 'field',
			'value' => esc_html__( 'Valore selezionato', 'wppa' ),
			'field' => 'link_text',
		],
		'button_label' => esc_html__( 'Nuovo link', 'wppa' ),
		'settings'     => 'social_links',
		'default'      => [
			[
				'icon_id'   => 'facebook',
				'link_text' => 'Facebook',
				'link_url'  => 'https://facebook.com/',
			],
			[
				'icon_id'   => 'twitter',
				'link_text' => 'Twitter',
				'link_url'  => 'https://twitter.com/',
			],
			[
				'icon_id'   => 'youtube',
				'link_text' => 'You Tube',
				'link_url'  => 'https://youtube.com/',
			],
			[
				'icon_id'   => 'instagram',
				'link_text' => 'Instagram',
				'link_url'  => 'https://instagram.com/',
			],

		],
		'fields'       => [
			'icon_id'   => [
				'type'    => 'select',
				'label'   => esc_html__( 'Nome del Social media', 'wppa' ),
				'default' => '',
				'choices' => [
					'facebook'  => esc_html__( 'Facebook', 'wppa' ),
					'twitter'   => esc_html__( 'Twitter', 'wppa' ),
					'youtube'   => esc_html__( 'YouTube', 'wppa' ),
					'instagram' => esc_html__( 'Instagram', 'wppa' ),
					'flickr'    => esc_html__( 'Flickr', 'wppa' ),
					'linkedin'  => esc_html__( 'Linkedin', 'wppa' ),
					'pinterest' => esc_html__( 'Pinterest', 'wppa' ),
					'reddit'    => esc_html__( 'Reddit', 'wppa' ),
					'telegram'  => esc_html__( 'Telegram', 'wppa' ),
					'vimeo'     => esc_html__( 'Vimeo', 'wppa' ),
					'whatsapp'  => esc_html__( 'WhatsApp', 'wppa' ),
				],
			],
			'link_text' => [
				'type'        => 'text',
				'label'       => esc_html__( 'Social media', 'wppa' ),
				'description' => esc_html__( 'Nome del social media (es. Faceboot, Twitter, Youtube, Instagram, etc)', 'wppa' ),
				'default'     => '',
			],
			'link_url'  => [
				'type'        => 'text',
				'label'       => esc_html__( 'Link del tuo account', 'wppa' ),
				'description' => esc_html__( 'Link completo del tuo profilo social', 'wppa' ),
				'default'     => 'https://',
			],
		],
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'multicheck',
		'settings' => 'social_sharing_link',
		'label'    => esc_html__( 'Social media da visualizzare', 'wppa' ),
		'section'  => 'social_sharing_section',
		'default'  => array( 'facebook', 'twitter', 'pinterest', 'linkedin', 'whatsapp', 'telegram' ),
		'choices'  => array(
			'facebook'  => esc_html__( 'Facebook', 'wppa' ),
			'twitter'   => esc_html__( 'Twitter', 'wppa' ),
			'pinterest' => esc_html__( 'Pinterest', 'wppa' ),
			'linkedin'  => esc_html__( 'Linkedin', 'wppa' ),
			'whatsapp'  => esc_html__( 'WhatsApp', 'wppa' ),
			'reddit'    => esc_html__( 'Reddit', 'wppa' ),
			'telegram'  => esc_html__( 'Telegram', 'wppa' ),
		),
		'priority' => 2,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'text',
		'settings' => 'social_sharing_label',
		'label'    => esc_html__( 'Etichetta condivisione', 'wppa' ),
		'section'  => 'social_sharing_section',
		'default'  => 'Condividi',
		'priority' => 1,
	)
);

my_config_kirki_add_field(
	array(
		'type'     => 'text',
		'settings' => 'social_sharing_twitter_username',
		'label'    => esc_html__( 'Twitter username', 'wppa' ),
		'section'  => 'social_sharing_section',
		'default'  => '',
		'priority' => 3,
	)
);

/**
 *
 * Choose featured image size.
 */
function customizer_imagesize_select() {
	if ( ! class_exists( 'Kirki' ) ) {
		return;
	}
	Kirki::add_field(
		'teramo_settings',
		array(
			'type'     => 'select',
			'settings' => 'single_post_thumbnail_size',
			'label'    => esc_html__( 'Dimensione immagine in evidenza', 'wpdi' ),
			'section'  => 'featured_image_section',
			'default'  => 'thumbnail',
			'choices'  => App\imagesize_list(),
			'priority' => 30,
		)
	);
}

add_action( 'init', 'customizer_imagesize_select', 999 );

/**
 * Example function that creates a control containing the available sidebars as choices.
 *
 * @return void
 */
function kirki_sidebars_select_example() {
	$sidebars = array();
	if ( isset( $GLOBALS['wp_registered_sidebars'] ) ) {
		$sidebars = $GLOBALS['wp_registered_sidebars'];
	}
	$sidebars_choices = array();
	foreach ( $sidebars as $sidebar ) {
		$sidebars_choices[ $sidebar['id'] ] = $sidebar['name'];
	}
	if ( ! class_exists( 'Kirki' ) ) {
		return;
	}
	Kirki::add_field(
		'teramo_settings',
		array(
			'type'        => 'select',
			'settings'    => 'sidebars_select',
			'label'       => esc_html__( 'Sidebars Select', 'kirki' ),
			'description' => esc_html__( 'An example of how to implement sidebars selection.', 'kirki' ),
			'section'     => 'select_section',
			'default'     => 'primary',
			'choices'     => $sidebars_choices,
			'priority'    => 30,
		)
	);
}

add_action( 'init', 'kirki_sidebars_select_example', 999 );

/**
 * Customizer JS
 */

add_action( 'customize_preview_init',
	function () {
		wp_enqueue_script( 'sage/customizer.js', App\asset_path( 'scripts/customizer.js' ), [ 'customize-preview' ], null, true );
	}
);

add_action(
	'wp_head',
	function () {
		?>
		<style type="text/css">
			.branding, .menu-main {
				background-color: <?php echo esc_html( get_theme_mod( 'wppa_head_color', '#0066cc' ) ); ?>;
			}

			a, a:hover {
				color: <?php echo esc_html( get_theme_mod( 'wppa_link_color', '#0066cc' ) ); ?>;
			}

			button, input[type="submit"] {
				background-color: <?php echo esc_html( get_theme_mod( 'wppa_button_color', '#65dde0' ) ); ?>;
			}

			html, #footer {
				background-color: <?php echo esc_html( get_theme_mod( 'wppa_footer_color', '#00264d' ) ); ?>;
			}

			#footer a {
				color: <?php echo esc_html( get_theme_mod( 'wppa_footer_link', '#65dcdf' ) ); ?>;
			}

			.bg-footer {
				background-color: <?php echo esc_html( get_theme_mod( 'wppa_footer_color', '#00264d' ) ); ?>;
			}
		</style>
		<?php
	}
);

/**
 *
 * Add new field to add new product category page.
 */
function icon_cat_meta_field() {
	// this will add the custom meta field to the add new term page.
	?>
	<div class="form-field">
		<label for="icon_cat_id"><?php esc_html_e( 'Icona ID', '' ); ?></label>
		<input type="text" name="icon_cat_id" id="icon_cat_id" value="">
		<?php esc_html_e( 'Assegna una icona di Bootstrap Italia a questa cateogoria', '' ); ?>
	</div>
	<?php
}

add_action( 'category_add_form_fields', 'icon_cat_meta_field', 10, 2 );

/**
 *
 * Add new field to existing category edit page.
 *
 * @param object $term reference term.
 */
function icon_edit_cat_meta_field( $term ) {
	// retrieve the existing value(s) for this meta field. This returns an array.
	$term_meta = get_term_meta( $term->term_id );
	$icon_id   = isset( $term_meta['icon_cat_id'] ) ? $term_meta['icon_cat_id'][0] : '';
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="icon_cat_id"><?php esc_attr_e( 'Icona ID', '' ); ?></label>
		</th>
		<td>
			<input type="text" name="icon_cat_id" id="icon_cat_id"
				value="<?php echo esc_attr( $icon_id ) ? esc_attr( $icon_id ) : ''; ?>">
			<?php esc_html_e( 'Assegna una icona di Bootstrap Italia a questa cateogoria', '' ); ?>
		</td>
	</tr>
	<?php
}

add_action( 'category_edit_form_fields', 'icon_edit_cat_meta_field', 10, 2 );


/**
 *
 * Save additional field data callback function.
 *
 * @param int $term_id term id.
 */
function save_icon_cat_custom_meta( $term_id ) {
	if ( isset( $_POST['icon_cat_id'] ) && wp_verify_nonce( sanitize_key( $_POST['icon_cat_id'] ), basename( __FILE__ ) ) ) {
		$term_meta = get_term_meta( $term_id );
		// Save the taxonomy value.
		update_term_meta( $term_id, 'icon_cat_id', sanitize_key( $_POST['icon_cat_id'] ) );
	}
}

add_action( 'edited_category', 'save_icon_cat_custom_meta', 10, 2 );
add_action( 'create_category', 'save_icon_cat_custom_meta', 10, 2 );


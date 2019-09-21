<?php
/**
 * PHP version 5
 * Created by PhpStorm.
 * User: gianluca
 * Date: 25/03/19
 * Time: 15.36
 */

namespace App;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Define custom fields
 * Docs: https://carbonfields.net/docs/
 */
function crb_attach_theme_options() {
	$basic_options_container = Container::make( 'theme_options', __( 'Basic Options' ) )->add_fields(
		array(
			Field::make( 'header_scripts', 'crb_header_script', __( 'Header Script' ) ),
			Field::make( 'footer_scripts', 'crb_footer_script', __( 'Footer Script' ) ),
		)
	);

	// Add second options page under 'Basic Options'.
	Container::make( 'theme_options', __( 'Social Links' ) )->set_page_parent( $basic_options_container ) // reference to a top level container.
			->add_fields(
				array(
					Field::make( 'text', 'crb_facebook_link', __( 'Facebook Link' ) ),
					Field::make( 'text', 'crb_twitter_link', __( 'Twitter Link' ) ),
				)
			);

	// Add third options page under "Appearance".
	Container::make( 'theme_options', __( 'Customize Background' ) )->set_page_parent( 'themes.php' ) // identificator of the "Appearance" admin section.
			->add_fields(
				array(
					Field::make( 'color', 'crb_background_color', __( 'Background Color' ) ),
					Field::make( 'image', 'crb_background_image', __( 'Background Image' ) ),
				)
			);
	Container::make( 'post_meta', __( 'Contatti' ) )
				->where( 'post_type', '=', 'persona' )
				->add_fields(
					array(
						Field::make( 'text', 'crb_nome', 'Nome' ),
						Field::make( 'text', 'crb_cognome', 'Cognome' ),
						Field::make( 'text', 'crb_email', 'Email' )
							->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$' )
							->set_attribute( 'placeholder', 'm.rossi@provincia.teramo.it' ),
						Field::make( 'text', 'crb_interno', 'Numero interno' )
							->set_attribute( 'pattern', '[0-9].[2,3]' )
							->set_attribute( 'placeholder', '999' )
							->set_attribute( 'maxLength', 3 ),
						Field::make( 'text', 'crb_cellulare', 'Cellulare' )
							->set_attribute( 'pattern', '[0-9].[8,10]' )
							->set_attribute( 'placeholder', '3219873321' ),
					)
				);
};

add_action( 'carbon_fields_register_fields', __NAMESPACE__ . '\\crb_attach_theme_options' );

/**
 * Boot Carbon Fields
 */
function crb_load() {
	require_once( get_template_directory() . '/../vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\crb_load' );

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
				->set_context( 'normal' )
				->add_fields(
					array(
						Field::make( 'text', 'crb_nome', 'Nome' )
							->set_required( true ),
						Field::make( 'text', 'crb_cognome', 'Cognome' )
							->set_required( true ),
						Field::make( 'text', 'crb_email', 'Email' )
							->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$' )
							->set_attribute( 'placeholder', 'm.rossi@provincia.teramo.it' )
							->set_required( true ),
						Field::make( 'text', 'crb_interno', 'Numero interno' )
							->set_attribute( 'pattern', '[0-9].[2,3]' )
							->set_attribute( 'placeholder', '999' )
							->set_attribute( 'maxLength', 3 ),
						Field::make( 'text', 'crb_cellulare', 'Cellulare' )
							->set_attribute( 'pattern', '[0-9].[8,10]' )
							->set_attribute( 'placeholder', '3219873321' ),
					)
				);
	Container::make( 'post_meta', __( 'Ruolo' ) )
				->where( 'post_type', '=', 'persona' )
				->set_context( 'normal' )
				->add_fields(
					array(
						Field::make( 'text', 'crb_ruolo', 'Ruolo' )
							->set_help_text( 'descrizione testuale del ruolo (Es. Consigliere con delega alla innovazione, Presidente del Consiglio Comunale, direttore sistemi informativi)' )
							->set_required( true ),
						Field::make( 'association', 'crb_organizzazione', 'Organizzazione di riferimento' )
							->set_help_text( 'organizzazione di cui fa parte (es. Consiglio Comunale; es. Sistemi informativi) link alla struttura' )
							->set_required( true )
							->set_types(
								array(
									array(
										'type'      => 'post',
										'post_type' => 'organo',
									),
									array(
										'type'      => 'post',
										'post_type' => 'ufficio',
									),
								)
							)
							->set_max( 1 ),
						Field::make( 'association', 'crb_responsabile', 'Responsabile di' )
							->set_help_text( 'Organizzazione di cui è responsabile (Responsabile del Consiglio Comunale; es. responsabile dell\'area sistemi informativi) (link all\'area)' )
							->set_required( false )
							->set_types(
								array(
									array(
										'type'      => 'post',
										'post_type' => 'organo',
									),
									array(
										'type'      => 'post',
										'post_type' => 'ufficio',
									),
								)
							)
							->set_max( 1 ),
						Field::make( 'date', 'crb_data_conclusione_incarico', 'Data conclusione incarico' )
							->set_help_text( 'Se il campo viene compilato, tutti i campi relativi al ruolo non sono più visibili ad eccezione dei campi "foto" e "biografia" e compare la frase "ha fatto parte dell\'organizzazione comunale fino al 31/07/2016"' )
							->set_input_format( 'd/m/Y', 'd/m/Y' )
							->set_storage_format( 'd/m/Y' ),
						Field::make( 'radio', 'crb_tipo', 'Tipologia' )
							->set_help_text( 'Specificare la tipologia di persona: politica, amminsitrativa o altro tipo' )
							->set_required( true )
							->add_options(
								array(
									0 => 'Dipendente',
									1 => 'Politico',
								)
							),
						Field::make( 'textarea', 'crb_compentenze', 'Competenze' )
							->set_help_text( 'Se Persona Politica, descrizione testuale del ruolo, comprensiva delle deleghe OPPURE se Persona Amministrativa, descrizione dei compiti di cui si occupa la persona' )
							->set_rows( 4 ),
						Field::make( 'text', 'crb_altre_cariche', 'Altre cariche' )
							->set_conditional_logic(
								array(
									'relation' => 'AND', // Optional, defaults to "AND".
									array(
										'field'   => 'crb_tipo',
										'value'   => 1, // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
										'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN.
									),
								)
							),
						Field::make( 'complex', 'crb_delege', 'Deleghe' )
							->set_help_text( 'Elenco delle deleghe a capo della persona' )
							->set_layout( 'grid' )
							->add_fields(
								array(
									Field::make( 'text', 'delega', 'Delega' ),
								)
							),
						Field::make( 'date', 'crb_data_insediamento', 'Data di insediamento' )
							->set_help_text( 'Solo per Persona Politica: specificare la data di insediamento' )
							->set_input_format( 'd/m/Y', 'd/m/Y' )
							->set_storage_format( 'd/m/Y' )
							->set_conditional_logic(
								array(
									'relation' => 'AND', // Optional, defaults to "AND".
									array(
										'field'   => 'crb_tipo',
										'value'   => 1, // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
										'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN.
									),
								)
							),
						Field::make( 'media_gallery', 'crb_foto_attivita', 'Foto attività politica' )
							->set_help_text( 'Solo per Persona Politica: gallery dell\'attività politica e istituzionale della persona. Le foto sono corredate da didascalia' )
							->set_type(
								array( 'image', 'video' )
							)
							->set_duplicates_allowed( false )
							->set_conditional_logic(
								array(
									'relation' => 'AND', // Optional, defaults to "AND".
									array(
										'field'   => 'crb_tipo',
										'value'   => 1, // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
										'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN.
									),
								)
							),
					)
				);
	Container::make( 'post_meta', __( 'Documenti' ) )
				->where( 'post_type', '=', 'persona' )
				->set_context( 'normal' )
				->add_fields(
					array(
						Field::make( 'file', 'crb_curricula', 'Curriculum vitae' )
						->set_type(
							array( 'application/pdf', 'application/p7m' )
						),
						Field::make( 'complex', 'crb_compensi' )
						->add_fields(
							array(
								Field::make( 'text', 'title' ),
								Field::make( 'text', 'importo' ),
								Field::make( 'documento', 'file' ),
							)
						),
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

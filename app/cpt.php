<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 26/02/19
 * Time: 22.52
 * PHP version 5
 */

namespace App\WPDI_CPT;

global $default_cpt_settings;
$taxonomy_servizi = array(
	'name'   => 'servizi',
	'data'   => array(
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu'      => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'topic' ),
		'capabilities'      => array(
			'assign_terms' => 'manage_options',
			'edit_terms'   => 'manage_options',
			'manage_terms' => 'manage_options',
		),
		'labels' => array(
			'name'              => _x( 'Tipo di servzio', 'wppa' ),
			'singular_name'     => _x( 'Sezione di pubblicazione', 'wppa' ),
			'search_items'      => __( 'Cerca sezioni di pubblicazioni', 'wppa' ),
			'all_items'         => __( 'Tutte le sezioni di pubblicazione', 'wppa' ),
			'parent_item'       => __( 'Sezione genitore', 'wppa' ),
			'parent_item_colon' => __( 'Sezione genitore:', 'wppa' ),
			'edit_item'         => __( 'Modifica Sezione di pubblicazione', 'wppa' ),
			'update_item'       => __( 'Aggiorna  Sezione di pubblicazione', 'wppa' ),
			'add_new_item'      => __( 'Aggiungi nuova Sezione di pubblicazione', 'wppa' ),
			'new_item_name'     => __( 'Nuova Sezione di pubblicazione', 'wppa' ),
			'menu_name'         => __( 'Sezioni di pubblicazione', 'wppa' ),
		),
	),
);

$cpt_comunicati = new Wpdi_CPT(
	'comunicato',
	'Comunicato',
	'Comunicati',
	'Comunicato Stampa',
	'it-file',
	true,
	true
);

$cpt_servizio = new Wpdi_CPT(
	'servizio',
	'Servizio',
	'Servizi',
	'Servizio amministrativo',
	'it-file',
	true,
	false,
	array(),
	false,
	false,
	$taxonomy_servizi
);

$cpt_documento = new Wpdi_CPT(
	'documento',
	'Documento',
	'Documenti',
	'Documento informativo / amministrativo',
	'it-file',
	true
);

$cpt_ufficio = new Wpdi_CPT(
	'ufficio',
	'Ufficio',
	'Uffici',
	'Ufficio / Struttura dell\'Ente',
	'it-file',
	true
);

$cpt_persona = new Wpdi_CPT(
	'persona',
	'Persona',
	'Persone',
	'Persona / Dipendente dell\'Ente',
	'it-file',
	true,
	false,
	array( 'title', 'excerpt' )
);

$cpt_organo = new Wpdi_CPT(
	'organo',
	'Organo',
	'Organi',
	'Organi Politici dell\'Ente',
	'it-file',
	true,
	false
);
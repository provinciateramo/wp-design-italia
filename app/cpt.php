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
	true
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
	false, array('title', 'excerpt')
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

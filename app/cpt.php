<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 26/02/19
 * Time: 22.52
 */

namespace App;
namespace App\WPDI_CPT;

$cpt_comunicati = new WpdiCpt('comunicato','Comunicato', 'Comunicati',
    'Comunicato Stampa','it-file', true);

$cpt_organigramma = new WpdiCpt('organigramma','Organigramma', 'Organigrammi',
    'Organigramma dell\'ente','it-pa');

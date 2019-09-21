<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 27/02/19
 * Time: 8.07
 * PHP version 7.0
 *
 * @package App\Metabox
 */

namespace App\Metabox;

/**
 * Class BaseMetabox
 * Classe base per la gestione dei Metabox
 * Aggiunge due metodi per semplifcare l'aggiunta e il salvataggio dei dati
 *
 * @category PHP
 * @package  App\Metabox
 * @author   Gianluca Di Carlo <g.dicarlo@provincia.teramo.it>
 */
abstract class Base_Metabox {

	/**
	 * BaseMetabox constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_field_data' ) );
	}

	/**
	 * Da implementare per attivare il metabox
	 *
	 * @return mixed
	 */
	abstract public function add_meta_box();

	/**
	 * Funzione da implementare per aggiornare i dati del metabox
	 *
	 * @param int $post_id identificativo del post.
	 *
	 * @return mixed     *
	 */
	abstract public function save_field_data( $post_id );
}

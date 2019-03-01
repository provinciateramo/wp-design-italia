<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 27/02/19
 * Time: 8.07
 */

namespace App\Metabox;


abstract class BaseMetabox {

    public function __construct() {

        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

        add_action( 'save_post', array( $this, 'save_field_data' ) );

    }

    abstract function add_meta_box();

    abstract function save_field_data($post_id);

}

<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 17/01/19
 * Time: 21.59
 */

namespace app\Controllers;

use Sober\Controller\Controller;

class Search extends Controller
{
    public static function main_category() {
        $terms = get_categories(array('parent'=>0,'orderby'=>'term_id'));
        foreach ( $terms as $term ) {
           $term->icon_cat_id = get_term_meta($term->term_id,'icon_cat_id', true);
        }
        return $terms;
    }
    
    public static function all_category() {
        $main_cats = Search::main_category();
        $items = array();
        foreach ($main_cats as $main_cat) {
               $main_cat->sub = get_terms('category',array('child_of' => $main_cat->term_id));
        }
        return $main_cats;
    }

    public static function all_terms() {
        $items = get_terms( array(
            'taxonomy' => 'post_tag',
            'hide_empty' => false,
        ) );

        return $items;
    }

}

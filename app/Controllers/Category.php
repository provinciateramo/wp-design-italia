<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 06/03/19
 * Time: 10.46
 */

namespace app\Controllers;

use Sober\Controller\Controller;

class Category extends Controller
{
    public static function category_links($post_id=false, $css_class='badge border border-primary mr-1 mb-1') {
        $html = '';
        foreach (get_the_category($post_id) as $cat) {
            $html .= '<a href="'.get_category_link($cat->term_id).'" class="'.$css_class.'">'.$cat->name.'</a>';
        }
        return $html;
    }
}

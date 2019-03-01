<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 17/01/19
 * Time: 21.59
 */

namespace app\Controllers;

use Sober\Controller\Controller;

class Single extends Controller
{
    public static function archive_featured_image() {
        $post_id = get_the_ID();
        if ( !has_post_thumbnail($post_id) ) return 'https://via.placeholder.com/310x190/ebebeb/00cc00/?text=Immagine';
        $thumbmail_id = get_post_thumbnail_id($post_id);
        $medium_image_url = wp_get_attachment_image_src( $thumbmail_id, 'large');
        return $medium_image_url[0];
    }

    public function featured_image()
    {
        $html = '';
        if ( !has_post_thumbnail() ) return '';
        $post_id = get_the_ID();
        $featured_image_config = app::feautured_image_config($post_id);
        $single_post_show_thumbnail = $featured_image_config['featured_image_show'];
        if ( $single_post_show_thumbnail  ) {
            $single_post_align_thumbnail = $featured_image_config['featured_image_align'];
            $single_post_thumbnail_size = $featured_image_config['featured_image_size'];
            $single_post_show_caption = get_theme_mod('single_post_show_caption',false);
            $thumbmail_id = get_post_thumbnail_id($post_id);
            $large_image_url = wp_get_attachment_image_src( $thumbmail_id, 'large');
            if ($single_post_align_thumbnail!='hero') {
                $html = $html . '<div class="entry-media"><figure class="figure '.'rounded float-lg-'.$single_post_align_thumbnail.' img-thumbnail'.'">';
                $html = $html . '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
                $html = $html . get_the_post_thumbnail($post_id,$single_post_thumbnail_size, array('class' => 'figure-img img-fluid rounded mb-0'));
                $html = $html . '</a>';

                if ($single_post_show_caption && get_post($thumbmail_id)->post_excerpt) {
                    $html = $html . '<figcaption class="figure-caption wp-caption-text">'.get_post($thumbmail_id)->post_excerpt.'</figcaption>';
                }
                $html = $html . '</figure></div>';
            }
            else {
                $image_title = get_post($thumbmail_id)->post_excerpt;
                /*$html = $html . '<div class="it-hero-wrapper it-hero-small-size it-primary it-overlay">';
                $html = $html . '<div class="img-responsive-wrapper"><div class="img-responsive"><div class="img-wrapper">'.
                                '<img src="'.$large_image_url[0].'" title="'.$image_title.'" alt="'.$image_title.'"></div></div></div>';
                $html = $html . '<div class="container"><div class="row"><div class="col-12"><div class="it-hero-text-wrapper p-2 bg-dark">'.
                                '<span class="it-category">Category</span><h1 class="no_toc">'.get_the_title().'</h1>'.
                                '<p class="d-none d-lg-block"></p></div></div></div></div></div>';
                */
                $html = $html . \App\template('partials.entry-hero', array('image' => $large_image_url[0], 'image_title' => $image_title) );
            }
        }
        return $html;
    }

    /* AGGIUNGI BREADCRUMP NEI POST */
    public function wp_breadcrumb() {
        $bc ='';
        $bc .= '<nav aria-label="breadcrumb">';
        $bc .= '<ol class="breadcrumb">';
        $bc .= '<li class="breadcrumb-item"><a href="'.home_url().'" rel="nofollow">Home</a></li>';

        if (is_category() || is_single() || is_page()) {
            $bc .= '<li class="breadcrumb-item">';
            $mc = App::get_main_category();

            if ('' != $mc)
                $bc .= $mc;
            else
                $bc .= get_the_category_list('<li class="breadcrumb-item">');
            //$bc .= '</li>';
            //the_category('<li class="breadcrumb-item">');
            if (is_single()) {
                //$bc .= '<li class="breadcrumb-item">';
                $bc .= get_the_title();
                $bc .= '</li>';
            }
            $bc .= '</li>';

        } elseif (is_search()) {
            $bc .= '&nbsp;&nbsp;&#187;&nbsp;&nbsp;Cerca risultati per... ';
            $bc .= '"<em>';
            $bc .= get_the_search_query();
            $bc .= '</em>"';
        }
        $bc .= '</ol>';
        $bc .= '</nav>';
        return $bc;
    }

    public function use_hero()
    {
        return app::feautured_image_align(get_the_ID()) == 'hero';
    }

}

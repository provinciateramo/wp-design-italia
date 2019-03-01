<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function feautured_image_show($post_id) {
        return get_post_meta( $post_id, '_featured_image_show', true)!='' ?
            get_post_meta( $post_id, '_featured_image_show', true)
            : get_theme_mod( 'single_post_show_thumbnail',true );
    }

    public static function feautured_image_align($post_id) {
        return get_post_meta( $post_id, '_featured_image_align', true)!='' ?
            get_post_meta( $post_id, '_featured_image_align', true)
            : get_theme_mod( 'single_post_align_thumbnail',true );
    }

    public static function feautured_image_config($post_id) {
        $data = array();
        $data['featured_image_show'] = get_post_meta( $post_id, '_featured_image_show', true)!='' ? get_post_meta( $post_id, '_featured_image_show', true) : get_theme_mod( 'single_post_show_thumbnail',true );
        $data['featured_image_align'] = get_post_meta( $post_id, '_featured_image_align', true) ?: get_theme_mod('single_post_align_thumbnail','right');
        $data['featured_image_size'] = get_post_meta( $post_id, '_featured_image_size', true) ?: get_theme_mod('single_post_thumbnail_size','thumbnail');
        return $data;
    }

    public static function social_links() {
        if (!get_theme_mod( 'sl_replace_menu',false ))
            return '';
        $sl_values = get_theme_mod( 'social_links', [] );
        if (count($sl_values)==0)
            return '';
        $html = '<span hidden="true" class="visuallyhidden">'.esc_html__('Seguici su', 'wppa' ).'</span>';
        $html .= '<ul>';
        $icon_path = \App\asset_path('bootstrap-italia/svg/sprite.svg');
        foreach( $sl_values as $sl_value ) {
            $html .= '<li>';
            $link_icon = sprintf('<span hidden="true" class="visuallyhidden">%s</span><svg class="icon"><use xlink:href="%s#it-%s"></use></svg>', $sl_value['link_text'], $icon_path, $sl_value['icon_id']);
            $link_url = sprintf('<a href="%s" title="%s">%s</a>', $sl_value['link_url'],  $sl_value['link_text'],  $link_icon);
            $html .= $link_url;
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
   }

    public static function wpdi_the_custom_logo( $blog_id = 0 ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        if ( has_custom_logo() ) {
            echo '<img class="icon logosite" src="'. esc_url( $logo[0] ) .'">';
        } else {
            echo '<img class="icon logosite" src="'. \App\asset_path('images/custom-logo.png') .'">';
        }
    }

    public static function create_footer_menu( $theme_location ) {
        if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
            
            $menu_list  = "\n";
            
            $menu = get_term( $locations[$theme_location], 'nav_menu' );
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            $section_tag = '<div class="col-footer col-lg-3 col-md-3 col-sm-6">';
            
            foreach( $menu_items as $menu_item ) {
                if( $menu_item->menu_item_parent == 0 ) {
                    
                    $parent = $menu_item->ID;
                    
                    $menu_array = array();
                    foreach( $menu_items as $submenu ) {
                        if( $submenu->menu_item_parent == $parent ) {
                            $bool = true;
                            $menu_array[] = '<li><a class="list-item" href="' . $submenu->url . '">' . $submenu->title . '</a></li>' ."\n";
                        }
                    }
                    $menu_list .= $section_tag ."\n";
                    $menu_list .= '<h4><a href="' . $menu_item->url . '" title="'. $menu_item->title .'"><svg class="icon"><use xlink:href="'.\App\asset_path('bootstrap-italia/svg/sprite.svg').'#it-pa"></use></svg>' . $menu_item->title . '</a></h4>' ."\n";
                    if( $bool == true && count( $menu_array ) > 0 ) {
                        
                        
                        $menu_list .= '<div class="link-list-wrapper"><ul class="footer-list link-list clearfix">' ."\n";
                        $menu_list .= implode( "\n", $menu_array );
                        $menu_list .= '</div></ul>' ."\n";
                        
                    }
                    $menu_list .= '</div>' ."\n";
                    
                }
                
            }
            
        
    
        } else {
            $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
        }
        
        echo $menu_list;
    }

    public static function get_main_category($post_id=false, $parent = false)
    {
        global $wp_rewrite;
        if (!$post_id)
            $post_id = get_the_ID();
        $main_category_id = get_post_meta( $post_id, 'main_category', true );
        if ('' != $main_category_id) {
            return get_category_parents($main_category_id,true, '</li><li class="breadcrumb-item">');
            $main_category = get_term($main_category_id);
            $rel = (is_object($wp_rewrite) && $wp_rewrite->using_permalinks()) ? 'rel="category tag"' : 'rel="category"';
            return '<a href="' . esc_url(get_category_link($main_category->term_id)) . '" ' . $rel . '>' . $main_category->name . '</a>';
        }
        return '';
    }

    public static function show_author()
    {
        return get_theme_mod( 'single_post_show_author' )!='';
    }

}

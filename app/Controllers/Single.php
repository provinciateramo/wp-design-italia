<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 17/01/19
 * Time: 21.59
 * PHP Version 5.6
 *
 * @package app\Controllers
 */

namespace app\Controllers;

use Sober\Controller\Controller;
use function App\asset_path;
use function App\template;

class SocialLink {
	public $social_id = '';
	public $social_name = '';
	public $social_icon = '';
	public $social_url_structure = '';
	public $use_media = false;

	public function __construct( $id, $name, $icon, $url, $use_media=false ) {
		$this->social_id = $id;
		$this->social_name = $name;
		$this->social_icon = $icon;
		$this->social_url_structure = $url;
		$this->use_media = $use_media;
	}

	public function sharing_url($url, $title, $media = false) {
		$temp_url = sprintf( $this->social_url_structure, $url, $title) ;
		if ( $this->use_media && $media ) {
			$temp_url .= $temp_url . '&amp;media=' . $media;
		}
		return $temp_url;
	}

	public function sharing_icon() {
		return $this->social_icon;
	}
}

global $social_links_def;

$social_links_def = array();
$social_links_def['facebook']  = new SocialLink('facebook','Facebook', 'facebook', 'https://www.facebook.com/sharer/sharer.php?u=%s&amp;title=%s');
$social_links_def['twitter']   = new SocialLink('twitter','Twitter', 'twitter', 'https://twitter.com/intent/tweet?url=%s&amp;text=%s');
$social_links_def['linkedin']  = new SocialLink('linkedin','Linkedin', 'linkedin2', 'https://www.linkedin.com/shareArticle?mini=true&url=%s&amp;title=%s');
$social_links_def['pinterest'] = new SocialLink('pinterest','Pinterest', 'pinterest', 'https://pinterest.com/pin/create/button/?url=%s&amp;description=%s', true);
$social_links_def['telegram']  = new SocialLink('telegram','Telegram', 'telegram', 'https://telegram.me/share/url?url=%s&amp;text=%s');
$social_links_def['reddit']    = new SocialLink('reddit','Reddit', 'reddit', 'https://reddit.com/submit?url=%s&amp;title=%s');
$social_links_def['whatsapp']  = new SocialLink('whatsapp','WhatsApp', 'whatsapp', 'https://api.whatsapp.com/send?text=%s %s');



/**
 * Class Single
 *
 * @package AppControllers
 */
class Single extends Controller {
	/**
	 * Estra l'immagine per l'archivio.
	 *
	 * @return string
	 */
	public static function archive_featured_image() {
		$post_id = get_the_ID();
		if ( ! has_post_thumbnail( $post_id ) ) {
			return 'https://via.placeholder.com/310x190/ebebeb/00cc00/?text=Immagine';
		}
		$thumbnail_id     = get_post_thumbnail_id( $post_id );
		$medium_image_url = wp_get_attachment_image_src( $thumbnail_id, 'large' );
		return $medium_image_url[0];
	}

	/**
	 * Estrae l'immagine principale del contenuto
	 *
	 * @return string
	 */
	public function featured_image() {
		$html = '';
		if ( ! has_post_thumbnail() ) {
			return '';
		}
		$post_id                    = get_the_ID();
		$featured_image_config      = app::feautured_image_config( $post_id );
		$single_post_show_thumbnail = $featured_image_config['featured_image_show'];
		if ( $single_post_show_thumbnail ) {
			$single_post_align_thumbnail = $featured_image_config['featured_image_align'];
			$single_post_thumbnail_size  = $featured_image_config['featured_image_size'];
			$single_post_show_caption    = get_theme_mod( 'single_post_show_caption', false );
			$thumbmail_id                = get_post_thumbnail_id( $post_id );
			$image_caption               = wp_get_attachment_caption( $thumbmail_id );
			$image_caption               = ( '' === strval( $image_caption ) ) ? get_post( $thumbmail_id )->post_excerpt : $image_caption;
			$large_image_url             = wp_get_attachment_image_src( $thumbmail_id, 'post-thumbnail-hero' );
			if ( 'hero' !== $single_post_align_thumbnail ) {
				$html = $html . '<div class="entry-media"><figure class="figure rounded float-lg-' . $single_post_align_thumbnail . ' img-thumbnail">';
				$html = $html . '<a href="' . $large_image_url[0] . '" title="' . esc_html( the_title_attribute( 'echo=0' ) ) . '" >';
				$html = $html . get_the_post_thumbnail( $post_id, $single_post_thumbnail_size, array( 'class' => 'figure-img img-fluid rounded mb-0' ) );
				$html = $html . '</a>';

				if ( $single_post_show_caption && get_post( $thumbmail_id )->post_excerpt ) {
					$html = $html . '<figcaption class="figure-caption wp-caption-text">' . get_post( $thumbmail_id )->post_excerpt . '</figcaption>';
				}
				$html = $html . '</figure></div>';
			} else {
				$image_title = get_post( $thumbmail_id )->post_excerpt;
				$html        = $html . template(
					'partials.entry-hero-fullwidth',
					array(
						'image'         => $large_image_url[0],
						'image_title'   => $image_title,
						'image_caption' => $image_caption,
					)
				);
			}
		}
		return $html;
	}

	/**
	 * Specifica se usare l'impaginazione hero nei contenuti.
	 *
	 * @return bool
	 */
	public function use_hero() {
		return app::feautured_image_align( get_the_ID() ) === 'hero';
	}

	/**
	 * Return categories assigned to content.
	 * @param bool $id
	 *
	 * @return array
	 */
	public static function current_categories( $id = false ) {
		if ( !$id) {
			$id = get_the_ID();
		}
		$categories = wp_get_post_terms( $id, 'category', array( 'orderby' => 'term_order' ) );
		if ( ! $categories || is_wp_error( $categories ) ) {
			$categories = array();
		}
		return $categories;
	}

	/**
	 * Inserisce il codice per generare i pulsanti di condivisione sui social
	 */
	public function show_social_link() {
        global $social_links_def;
		// Get current page URL.
		$post_url = get_permalink();
		// Get current page title.
		$post_title   = str_replace( '%', '%25', get_the_title() );
		$social_title = rawurlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) );

		// Get Post Thumbnail for pinterest.

		$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

		// Open link in Popup.
		$openpopup = 'window.open(this.href,\'\', \'left=20,top=20,width=550,height=320\');return false;';


		// Twitter URL with Username.
		$twitter_url      = 'https://twitter.com/intent/tweet?text=' . $social_title . '&amp;url=' . $post_url;
		$twitter_username = get_theme_mod( 'social_sharing_twitter_username', false );
		if (!empty($twitter_username)) {
			$twitter_url .= '&amp;via=' . $twitter_username;
		}

		// Social share button URLs
		$facebook_url  = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
		$linkedIn_url  = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_url . '&amp;title=' . $post_title;
		$pinterest_url = 'https://pinterest.com/pin/create/button/?url=' . $post_url . '&amp;media=' . $post_thumbnail[0] . '&amp;description=' . $post_title;
		$telegram_url  = 'https://telegram.me/share/url?url=' . $post_url . '&text=' . $post_title;
		$reddit__url   = 'https://reddit.com/submit?url=' . $post_url . '&title=' . $post_title;
		$whatsapp_url  = 'https://api.whatsapp.com/send?text=' . $post_title . ' ' . $post_url;

		// Nofollow tags
		$rel_nofollow = 'rel="nofollow"';
		if (!is_singular()) {
			return;
		}
		$content = '<ul class="link-list">';
		$icon_base_path = asset_path( 'images/socialmedia.svg');
		foreach (get_theme_mod( 'social_sharing_link', array() ) as $sl) {
			$slc = $social_links_def[$sl];
			$content .= '<li><a class="list-item" rel="nofollow" href="' . $slc->sharing_url( $post_url, $post_title, $post_thumbnail[0] ) .'" onclick="' . $openpopup . '"><svg class="icon icon-sm"><use xlink:href="' . $icon_base_path .'#icon-' . $slc->sharing_icon() . '"></use></svg><span class="ml-1">' . $slc-> social_name . '</span></a></li>';
		}
		$content .= '</ul>';
		return $content;
	}


	/**
	 * @param bool $id
	 *
	 * @return string
	 */
	public function chip_categories( $id = false ) {
		$html = '';
		foreach ( $this::current_categories() as $category ) {
			//$html .= '<a href="#" ><div class="chip chip-simple chip-primary"><span class="chip-label">' .$category->name . '</span></div></a>';
			$html .= '<a class="badge badge-primary mr-1" href="' . esc_url( get_category_link( $category->term_id ) ) . '" >' .$category->name . '</a>';
		}
		return $html;
	}

	/**
	 * @param bool $id
	 *
	 * @return string
	 */
	public function get_toc( $id = false ) {
		if ( !$id) {
			$id = get_the_ID();
		}
		$html = '';
		require_once (WP_PLUGIN_DIR. '/easy-table-of-contents/includes/class.options.php');
		require_once (WP_PLUGIN_DIR. '/easy-table-of-contents/includes/class.post.php');
		require_once (WP_PLUGIN_DIR. '/easy-table-of-contents/includes/inc.functions.php');
		//$ezPost = new \ezTOC_Post( get_post( $id ) );
		//$ezPost->process();
		//echo var_dump($ezPost->getPages());

		return get_ez_toc_block($id);
	}
}

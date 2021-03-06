<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 27/02/19
 * Time: 14.56
 *
 * @package App\Metabox
 */

namespace App\Metabox;

use App\WPDI_CPT\Wpdi_CPT;
use function App\imagealign_list;
use function App\imagesize_list;

/**
 * Class FeaturedImageMetabox
 *
 * @package App\Metabox
 */
class Featured_Image_Metabox extends Base_Metabox {
	/**
	 * Implementazione per le immagini in evidenza
	 *
	 * @return mixed|void
	 */
	public function add_meta_box() {

		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type, Wpdi_CPT::$wpdi_cpt, true ) ) {
				add_meta_box(
					'featured_image_meta_box',
					__( 'Immagine in evidenza', 'wpdi' ),
					array( $this, 'meta_box_content' ),
					$post_type,
					'advanced',
					'low'
				);
			}
		}
	}

	/**
	 * Renderizza il modulo per la gestione delle immagini in evidenza
	 *
	 * @param object $post riferimento al post.
	 *
	 * @return mixed|void
	 */
	public function meta_box_content( $post ) {
		global $post;

		wp_nonce_field( basename( __FILE__ ), 'featured_image_meta_box_nonce' );
		$featured_image_show = boolval(
			get_post_meta( $post->ID, '_featured_image_show', true ) !== '' ?
			get_post_meta( $post->ID, '_featured_image_show', true ) :
			get_theme_mod( 'single_post_show_thumbnail', true )
		);

		$featured_image_align = get_post_meta( $post->ID, '_featured_image_align', true ) ?: get_theme_mod( 'single_post_align_thumbnail', 'right' );

		$featured_image_size = get_post_meta( $post->ID, '_featured_image_size', true ) ?: get_theme_mod( 'single_post_thumbnail_size', 'thumbnail' );

		$featured_image_show_caption = boolval(
			get_post_meta( $post->ID, '_featured_image_show_caption', true ) !== '' ?
				get_post_meta( $post->ID, '_featured_image_show_caption', true ) :
				get_theme_mod( 'single_post_show_caption', true )
		);
		?>
		<div class='inside'>

			<h3><?php esc_attr_e( 'Mostra immagine in evidenza', 'wpdi' ); ?></h3>
			<p>
				<label>
					<input type="radio" name="featured_image_show" value="1" <?php checked( $featured_image_show, true ); ?> />
					Si
				</label><br/>
				<label>
					<input type="radio" name="featured_image_show" value="0" <?php checked( $featured_image_show, false ); ?> />
					No
				</label>
			</p>

			<h3><?php esc_attr_e( 'Dimensione immagine in evidenza', 'wpdi' ); ?></h3>
			<p>
				<label>
					<select name="featured_image_size">
						<?php
						foreach ( imagesize_list() as $image_size => $image ) {
							?>
							<option value="<?php echo esc_attr( $image_size ); ?>" <?php selected( $image_size, $featured_image_size ); ?>>
								<?php echo esc_html( $image ); ?>
							</option>
							<?php
						}
						?>
					</select>
				</label>
			</p>
			<h3><?php esc_html_e( 'Allineamento immagine in evidenza', 'wpdi' ); ?></h3>
			<p>
				<label>
					<select name="featured_image_align">
						<?php
						foreach ( imagealign_list() as $image_align => $image_align_label ) {
							?>
							<option value="<?php echo esc_attr( $image_align ); ?>" <?php selected( $image_align, $featured_image_align ); ?>>
								<?php echo esc_html( $image_align_label ); ?>
							</option>
							<?php
						}
						?>
					</select>
				</label>
			</p>
			<h3><?php esc_html_e( 'Mostra didascalia immagine in evidenza', 'wpdi' ); ?></h3>
			<p>
				<input type="radio" name="featured_image_show_caption" value="1" <?php checked( $featured_image_show_caption, true ); ?> />Si<br />
				<input type="radio" name="featured_image_show_caption" value="0" <?php checked( $featured_image_show_caption, false ); ?> /> No
			</p>

		</div>
		<?php
	}

	/**
	 * Memorizza le impostazioni
	 *
	 * @param int $post_id identificativo del post.
	 *
	 * @return mixed|void
	 */
	public function save_field_data( $post_id ) {

		if ( ! isset( $_POST['featured_image_meta_box_nonce'] )
			|| ! wp_verify_nonce( sanitize_key( $_POST['featured_image_meta_box_nonce'] ), basename( __FILE__ ) )
		) {
			return;
		}
		// return if autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		// salvataggio preferenze immagine.
		if ( isset( $_POST['featured_image_show'] ) ) {
			update_post_meta(
				$post_id,
				'_featured_image_show',
				sanitize_text_field( wp_unslash( $_POST['featured_image_show'] ) )
			);
		}
		if ( isset( $_POST['featured_image_size'] ) ) {
			update_post_meta(
				$post_id,
				'_featured_image_size',
				sanitize_text_field( wp_unslash( $_POST['featured_image_size'] ) )
			);
		}
		if ( isset( $_POST['featured_image_align'] ) ) {
			update_post_meta(
				$post_id,
				'_featured_image_align',
				sanitize_text_field(
					wp_unslash( $_POST['featured_image_align'] )
				)
			);
		}
		if ( isset( $_POST['featured_image_show_caption'] ) ) {
			update_post_meta(
				$post_id,
				'_featured_image_show_caption',
				sanitize_text_field(
					wp_unslash( $_POST['featured_image_show_caption'] )
				)
			);
		}
	}
}

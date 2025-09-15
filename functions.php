<?php
namespace Poker_Strategy;

/*
 * Poker_Strategy class.
 */
class Poker_Strategy {
	/*
	 * Theme version number.
	 *
	 * @since 1.0
	 */
	private $version;

	/*
	 * Class constructor.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->version = wp_get_theme()->get( 'Version' );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'after_setup_theme', array( $this, 'add_theme_features' ) );

		add_action( 'show_user_profile', array( $this, 'extra_user_profile_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'extra_user_profile_fields' ) );
		add_action( 'personal_options_update', array( $this, 'save_extra_user_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_extra_user_profile_fields' ) );
		add_action( 'user_edit_form_tag', array( $this, 'enctype' ) );

		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
	}

	/*
	 * Enqueues scripts and styles.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'poker-strategy-style', get_theme_file_uri( '/assets/css/index.css' ), array(), $this->version );
		wp_enqueue_script( 'poker-strategy-script', get_theme_file_uri( '/assets/js/index.js' ), array(), $this->version, true );
	}

	/*
	 * Adds various theme features.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function add_theme_features() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'latest_posts_thumb', 177, 119, false );
		add_image_size( 'latest_news_thumb', 50, 34, false );
	}

	/*
	 * Adds additional user fields to the add/edit user and user profile WP Admin pages.
	 *
	 * @since 1.0
	 *
	 * @param  object $user WP_User object.
	 * @return void
	 */
	public function extra_user_profile_fields( $user ) {
		$image_url = wp_get_attachment_image_src( get_user_meta( $user->ID, 'profile_picture', true ), 'latest_posts_thumb' );
		?>
		<h3>Profile Picture</h3>
		<table class="form-table">
			<?php if ( isset( $image_url[0] ) ) : ?>
				<tr>
					<th><label for="profile_picture">Current Profile Picture</label></th>
					<td>
						<img src="<?php echo esc_url( $image_url[0] ); ?>" width="177" height="119"><br>
						<label><input type="checkbox" value="1" name="delete_profile_picture">Delete current picture</label>
					</td>
				</tr>
			<?php endif; ?>
			<tr>
				<th><label for="profile_picture">Upload Profile Picture</label></th>
				<td>
					<p><input type="file" name="profile_picture" id="profile_picture"></p>
				</td>
			</tr>
		</table>
		<h3>Profession</h3>
		<table class="form-table">
			<tr>
				<th><label for="profession">Edit Profession</label></th>
				<td>
					<input type="text" name="profession" id="profession" value="<?php echo esc_attr( get_the_author_meta( 'profession', $user->ID ) ); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
		<h3>Social Links</h3>
		<table class="form-table">
		<tr>
			<th><label for="facebook">Facebook</label></th>
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="x">X</label></th>
			<td>
				<input type="text" name="x" id="x" value="<?php echo esc_attr( get_the_author_meta( 'x', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
		<th><label for="youtube">Youtube</label></th>
			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
		<th><label for="instagram">Instagram</label></th>
			<td>
				<input type="text" name="instagram" id="instagram" value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
		<th><label for="linkedin">LinkedIn</label></th>
			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		</table>
	<?php
	}

	/*
	 * Updates user meta fields when saving a user profile.
	 *
	 * @since 1.0
	 *
	 * @param  int  $user_id User id.
	 * @return void
	 */
	public function save_extra_user_profile_fields( $user_id ) {
		update_user_meta( $user_id, 'profession', $_POST['profession'] );
		update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
		update_user_meta( $user_id, 'x', $_POST['x'] );
		update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
		update_user_meta( $user_id, 'instagram', $_POST['instagram'] );
		update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );

		if ( isset( $_POST['delete_profile_picture'] ) && $_POST['delete_profile_picture'] ) {
			$attachment_id = get_user_meta( $user_id, 'profile_picture', true );
			if ( $attachment_id ) {
				wp_delete_attachment( $attachment_id, true );
			}

			delete_user_meta( $user_id, 'profile_picture' );
		}

		if ( ! empty( $_FILES['profile_picture']['name'] ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';

			$attachment_id = media_handle_upload( 'profile_picture', 0 );

			if ( is_wp_error( $attachment_id ) ) {
				return;
			}

			update_user_meta( $user_id, 'profile_picture', $attachment_id );
		}
	}

	/*
	 * Adds the enctype attribute to the profile form so that we can upload a profile picture.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function enctype() {
		echo ' enctype="multipart/form-data"';
	}

	/*
	 * Overrides the excerpt length.
	 *
	 * @since 1.1
	 *
	 * @param  int  $length Existing excerpt length value.
	 * @return int
	 */
	public function excerpt_length( $length ) {
		return 20;
	}

	/*
	 * Overrides the excerpt_more filter.
	 *
	 * @since 1.1
	 *
	 * @param  string $more Existing excerpt more value.
	 * @return void
	 */
	public function excerpt_more( $more ) {
		return '...';
	}
}

new Poker_Strategy();

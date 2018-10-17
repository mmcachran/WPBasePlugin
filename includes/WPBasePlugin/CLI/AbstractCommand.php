<?php
/**
 * An abstract command for WP CLI scripts to implement.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\CLI;

/**
 * Abstract class for CLI scripts.
 */
abstract class AbstractCommand extends \WP_CLI_Command {
	/**
	 * Arguments for the command.
	 *
	 * @var array
	 */
	protected $args = [];

	/**
	 * Associative arguments for the command.
	 *
	 * @var array
	 */
	protected $assoc_args = [];

	/**
	 * Holds the WP CLI progress bar.
	 *
	 * @var \WP_CLI\Progress\Bar
	 */
	protected $progress_bar = null;

	/**
	 * Ensure a run method exists in classes that extend this one.
	 *
	 * @return void
	 */
	abstract public function run();

	/**
	 * Returns the ID of a random author to assign the post_author to.
	 *
	 * @return int User ID of a random author to attribute the post to.
	 */
	protected function get_random_user_id() {
		// Get a user from the site that is an admin or author.
		$users = get_users(
			[
				'role__in' => [ 'administrator', 'author' ],
				'number'   => 10,
				'fields'   => [ 'id' ],
			]
		);

		// Bail early if no users.
		if ( empty( $users ) || ! is_array( $users ) ) {
			return false;
		}

		// Get a random user.
		$random_user = $users[ mt_rand( 0, count( $users ) - 1 ) ];

		return ! empty( $random_user->id ) ? absint( $random_user->id ) : false;
	}

	/**
	 * Gets random content for a post.
	 *
	 * @return string Random content for the post.
	 */
	protected function get_random_post_content() {
		$paragraphs = mt_rand( 1, 10 );

		// Parameters for the API.
		$params = implode(
			'/',
			[
				'link',
				'decorate',
			]
		);

		// Compile the URL and fetch the file.
		$url     = sprintf( 'http://loripsum.net/api/%1$d/medium/%2$s', $paragraphs, $params );
		$request = wp_safe_remote_get( $url );

		// Log an error and bail early if request wasn't successful.
		if ( is_wp_error( $request ) ) {
			self::log(
				sprintf(
					'Received an error when trying to create content: %1$s',
					$request->get_error_message()
				),
				'warning'
			);

			return '';
		}

		// Format content for Gutenberg.
		$content = wp_remote_retrieve_body( $request );
		$content = array_filter( explode( PHP_EOL, $content ) );
		$content = '<!-- wp:paragraph -->' . implode( '<!-- /wp:paragraph --><!-- wp:paragraph -->', $content ) . '<!-- /wp:paragraph -->';

		return $content;
	}

	/**
	 * Downloads the images from lorempixel.com and inserts it into the media library.
	 *
	 * @param int   $post_id     The post ID to attach the image to.
	 * @param array $sizes       Sizes for the image.
	 * @return int               The ID for the new image.
	 */
	protected function get_random_image( int $post_id, array $sizes = [] ) {
		// Set the URL.
		$url = 'https://loremflickr.com/' . implode( '/', array_filter( $sizes ) ) . '/moutains';

		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		// Upload the file to a temporary directory.
		$temp_file = download_url( $url );

		// Bail early if there was an error in the download.
		if ( is_wp_error( $temp_file ) ) {
			self::log(
				sprintf(
					'Got an error uploading temp file: %1$s',
					$temp_file->get_error_message()
				),
				'warning'
			);
			return;
		}

		// Get the file's extension.
		$extension = mime_content_type( $temp_file );
		$extension = substr( $extension, strrpos( $extension, '/' ) + 1 );

		// Information for the attachment.
		$file_array = [
			'name'     => 'placeholderImage_' . mt_rand( 30948, 40982 ) . '.' . $extension,
			'tmp_name' => $temp_file,
		];

		// Sideload the media into WordPress.
		$attachment_id = media_handle_sideload( $file_array, $post_id );

		// Display an error if the image wasn't successfully imported.
		if ( is_wp_error( $attachment_id ) ) {
			self::log(
				sprintf(
					'Got an error uploading attachment: %1$s',
					$attachment_id->get_error_message()
				),
				'warning'
			);
		}

		return ! is_wp_error( $attachment_id ) ? absint( $attachment_id ) : 0;
	}

	/**
	 * Log output to the console.
	 *
	 * @param  string $string String to log.
	 * @param  string $type   Type to log it as.
	 * @return void
	 */
	protected static function log( $string, $type = 'success' ) {
		// Bail early if not a string.
		if ( ! is_string( $string ) ) {
			self::log( 'Attempting to log a non-string.', 'warning' );
			return;
		}

		switch ( $type ) {
			case 'error':
				\WP_CLI::error( $string );
				break;

			case 'warning':
				\WP_CLI::warning( $string );
				break;

			case 'success':
				\WP_CLI::success( $string );
				break;

			case 'line':
				\WP_CLI::line( $string );
				break;

			case 'debug':
				\WP_CLI::debug( $string );
				break;

			default:
				\WP_CLI::log( $string );
				break;
		}
	}
}

<?php
/**
 * Example CLI command.
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\CLI;

/**
 * Example CLI command.
 *
 * [--dry-run]
 * : Whethor or not to run the command on all sites.
 */
class ExampleCommand extends AbstractCommand {
	/**
	 * Main function to run the command.
	 *
	 * @param  array $args        Command arguments.
	 * @param  array $assoc_args  Command associative arguments.
	 * @return void
	 */
	public function run( array $args = [], array $assoc_args = [] ) {
		// Save arguments in class properties (defined in the abstract class).
		$this->args       = $args;
		$this->assoc_args = $assoc_args;

		// Fetch all posts.
		$posts = $this->get_posts();

		// Bail early if no posts.
		if ( empty( $posts ) ) {
			$this->log(
				sprintf(
					esc_html__(
						'No posts found.',
						'wpbaseplugin'
					)
				),
				'error'
			);
		}

		// Create the progress bar.
		$this->progress_bar = \WP_CLI\Utils\make_progress_bar(
			sprintf(
				'Updating %1$d Posts.',
				count( $posts )
			),
			count( $posts )
		);

		// Loop through the posts and parse each one.
		array_map( [ $this, 'parse_post' ], $posts );

		// Finish the progress bar.
		$this->progress_bar->finish();
	}

	/**
	 * Parses a post and update content.
	 *
	 * @param int $post_id  The ID of the post.
	 * @return void
	 */
	protected function parse_post( int $post_id ) {
		// Fetch the post.
		$post = get_post( $post_id );

		// Bail early if no post content.
		if ( ! ( $post instanceof \WP_Post ) || empty( $post->post_content ) ) {
			$this->log(
				sprintf(
					esc_html__(
						'No content for: %1$d - Skipping.',
						'wpbaseplugin'
					),
					$post_id
				),
				'warning'
			);

			return;
		}

		// Parse post content.
		$post_content = $this->parse_post_for_content( $post );

		// Update the content.
		wp_update_post(
			[
				'ID'           => $post_id,
				'post_content' => $post_content,
			]
		);

		// Increment the progress bar.
		$this->progress_bar->tick();
	}

	/**
	 * Modifies a post's content.
	 *
	 * @param \WP_Post $post The post object.
	 * @return string        The modified post content.
	 */
	protected function parse_post_for_content( \WP_Post $post ) {
		// Do something with post content and return the modified content.
		return $post->post_content;
	}

	/**
	 * Get all posts posts.
	 *
	 * @return array IDs of all posts posts.
	 */
	protected function get_posts() {
		// Query arguments.
		$args = [
			'post_type'              => WPBASEPLUGIN_POST_POST_TYPE,
			'post_status'            => 'all',
			'fields'                 => 'ids',
			'posts_per_page'         => 1000,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		];

		// Fetch all posts.
		$posts = new \WP_Query( $args );

		return $posts->have_posts() ? $posts->posts : [];
	}

}

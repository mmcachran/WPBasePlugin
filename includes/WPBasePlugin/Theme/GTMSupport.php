<?php
/**
 * Provides support for Google Tag Manager
 *
 * @package WPBasePlugin
 */

namespace WPBasePlugin\Theme;

/**
 * Class for GTM Support.
 */
class GTMSupport {
	/**
	 * Options for GTM Support.
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Determines whether or not to register these hooks.
	 *
	 * @return bool True if class hooks should be registered, false otherwise.
	 */
	public function can_register() {
		return true;
	}

	/**
	 * Registers the any custom functionality for GTM.
	 *
	 * @return void
	 */
	public function register() {
		// Fetch options before registering hooks.
		$this->options = get_option( 'gtm_support' );

		// Bail early if no options.
		if ( empty( $this->options ) ) {
			return;
		}

		// Add actions for dynamic scripts.
		add_action( 'wp_head', array( $this, 'render_head_tag' ) );
		add_action( 'wpbaseplugin_body', array( $this, 'render_body_tag' ) );
	}

	/**
	 * Renders Google Tag Manager <head> tags.
	 *
	 * @return void.
	 */
	public function render_head_tag() {
		// Add dynamic header tags (must come before static script embed).
		$this->get_dynamic_head_tag();
	}

	/**
	 * Renders Google Tag Manager <body> tags.
	 *
	 * @return void
	 */
	public function render_body_tag() {
		// Add dynamic body tags (must come before static script embed).
		$this->get_dynamic_body_tag();
	}

	/**
	 * Gets the dynamic head tag.
	 *
	 * @return void
	 */
	protected function get_dynamic_head_tag() {
		?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-<?php echo esc_attr( $this->get_container_id() ); ?>');</script>
		<!-- End Google Tag Manager -->
		<?php
	}

	/**
	 * Gets the dynamic body tag.
	 *
	 * @return void
	 */
	protected function get_dynamic_body_tag() {
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-<?php echo esc_attr( $this->get_container_id() ); ?>"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	}

	/**
	 * Returns the dynamic container ID.
	 *
	 * @return string The dynamic container ID.
	 */
	protected function get_container_id() {
		// Bail early if the option is available.
		if ( isset( $this->options['container_id'] ) ) {
			return $this->options['container_id'];
		}

		// Fallback to the constant if defined.
		return defined( 'GTM_CONTAINER_ID' ) ? GTM_CONTAINER_ID : false;
	}
}

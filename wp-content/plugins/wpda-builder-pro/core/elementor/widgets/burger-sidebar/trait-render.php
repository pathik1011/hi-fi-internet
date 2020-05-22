<?php

namespace WPDaddy\Builder\Elementor\Widgets\Burger_Sidebar;

if(!defined('ABSPATH')) {
	exit;
}

use Elementor\Plugin;
use Elementor\Utils;

trait Trait_Render {
	protected $body_render = '';

	protected function render_widget(){
		$settings = array(
			'sidebar' => '',
		);

		$settings = wp_parse_args($this->get_settings(), $settings);

		$this->add_render_attribute(
			'wrapper', 'class', array(
				'wpda-builder-burger_sidebar',
			)
		);
		$editor = Plugin::$instance->editor->is_edit_mode();
		if(!$editor) {
			add_action('wp_footer', array( $this, 'render_wrapper' ), PHP_INT_MAX);
		}

		if(!empty($settings['sidebar']) && is_active_sidebar($settings['sidebar'])) {
			ob_start();
			echo '<aside class="sidebar">';
			dynamic_sidebar($settings['sidebar']);
			echo '</aside>';
			$this->body_render = ob_get_clean();
		}
		$this->add_render_attribute('wrapper', 'data-id', $this->get_id())

		?>
		<div <?php $this->print_render_attribute_string('wrapper') ?>>
			<?php echo apply_filters( 'wpda_burger_sidebar_icon', '<i class="burger_sidebar_icon"></i>' ) ?>
		</div>
		<?php
	}

	public function render_wrapper(){
		if (!empty($this->body_render)) {
			echo '<div class="wpda-builder__burger_sidebar burger-id-'.$this->get_id().'"><div class="wpda-builder__burger_sidebar-cover"></div><div class="wpda-builder__burger_container">'.$this->body_render.'</div></div>';
		}
	}

}


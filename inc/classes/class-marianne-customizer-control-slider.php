<?php
/**
 * Custom Slider Class.
 *
 * This class is in charge of customization with range sliders via the Customizer.
 *
 * Based on the work of Anthony Hortin.
 *
 * @link https://github.com/maddisondesigns
 *
 * @package Marianne
 * @since Marianne 1.3
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Instantiate the object.
	 */
	class Marianne_Customizer_Control_Slider extends WP_Customize_Control {
		/**
		 * The control type.
		 *
		 * @access public
		 * @var    string
		 */
		public $type = 'marianne_slider';

		/**
		 * Renders the control content.
		 *
		 * This simply prints the notice we need.
		 *
		 * @access public
		 * @return void
		 */
		public function render_content() {
			?>
				<div class="slider-custom-control">
					<span class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</span>

					<input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />

					<span class="customize-control-description">
						<?php echo esc_html( $this->description ); ?>
					</span>

					<div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div>

					<span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->settings['default']->default ); ?>"></span>
				</div>
			<?php
		}
	}
}

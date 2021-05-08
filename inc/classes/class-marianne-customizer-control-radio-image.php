<?php
/**
 * Custom Radio Image Class.
 *
 * This class is in charge of customization with radio images via the Customizer.
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
	class Marianne_Customizer_Control_Radio_Image extends WP_Customize_Control {
		/**
		 * The control type.
		 *
		 * @access public
		 * @var    string
		 */
		public $type = 'marianne_radio_image';

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
				<div class="image_radio_button_control">
					<?php if ( ! empty( $this->label ) ) { ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php } ?>

					<?php if ( !empty( $this->description ) ) { ?>
						<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
					<?php } ?>

					<?php foreach ( $this->choices as $key => $value ) { ?>
						<label class="radio-button-label">
							<input type="radio" id="<?php echo esc_attr( $this->id . '_' . $key ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>

							<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
						</label>
					<?php } ?>
				</div>
			<?php
		}
	}
}

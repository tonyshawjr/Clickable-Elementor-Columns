<?php
/**
 * Main Class
 *
 * @author   Tony Shaw
 * @since    1.0.0
 * @package  Clickable_Elementor_columns
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( 'Clickable_Elementor_Columns_Setup' ) ) :

  /**
   * The main Clickable_Elementor_Columns_Setup class
   */
  class Clickable_Elementor_Columns_Setup {
    public function __construct() {
      add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

      add_action( 'elementor/element/column/layout/before_section_end', array( $this, 'widget_extensions' ), 10, 2 );
      add_action( 'elementor/frontend/column/before_render', array( $this, 'before_render_options' ), 10 );
    }


    /**
     * After layout callback
     *
     * @param  object $element
     * @param  array $args
     * @return void
     */
    public function widget_extensions( $element, $args ) {
      $element->add_control(
        'column_link',
        [
          'label'       => __( 'Column Link', 'Clickable_Elementor_columns' ),
          'type'        => Elementor\Controls_Manager::URL,
          'dynamic'     => [
            'active' => true,
          ],
          'placeholder' => __( 'https://column-link.com', 'elementor' ),
          'selectors'   => [
        ],
        ]
      );
    }


    public function before_render_options( $element ) {
      $settings  = $element->get_settings_for_display();

      if ( isset( $settings['column_link'], $settings['column_link']['url'] ) && ! empty( $settings['column_link']['url'] ) ) {
        wp_enqueue_script( 'Clickable_Elementor_columns' );

        $element->add_render_attribute( '_wrapper', 'class', 'Clickable_Elementor_columns' );
        $element->add_render_attribute( '_wrapper', 'style', 'cursor: pointer;' );
        $element->add_render_attribute( '_wrapper', 'data-column-clickable', $settings['column_link']['url'] );
        $element->add_render_attribute( '_wrapper', 'data-column-clickable-blank', $settings['column_link']['is_external'] ? '_blank' : '_self' );
      }
    }


    public function frontend_scripts() {
      wp_register_script( 'Clickable_Elementor_columns', plugins_url( 'assets/js/clickable_elementor_columns.js', plugin_dir_path( __FILE__ ) ), array( 'jquery' ), Clickable_Elementor_Columns::VERSION, true );
    }
  }

endif;

new Clickable_Elementor_Columns_Setup();

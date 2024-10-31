<?php
/**
 * This class displays the nutritional facts widget of a recipe.
 *
 * @link    https://wzymedia.com
 * @since   2.12.0
 *
 * @package Recipepress
 * @author  wzyMedia <wzy@outlook.com>
 */

namespace Recipepress\Inc\Frontend\Widgets;

use Recipepress\Inc\Core\Options;
use Recipepress\Inc\Frontend\Template;

/**
 * The nutritional facts widget class.
 *
 * @since   2.12.0
 *
 * @package Recipepress
 * @author  wzyMedia <wzy@outlook.com>
 */
class Recipe_Nutritional_Facts extends \WP_Widget {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   2.12.0
	 */
	public function __construct() {

		$this->set_widget_options();

		// Create the widget.
		parent::__construct(
			'rpr-nutritional-facts',
			__( 'RPR Nutritional Facts', 'recipepress-reloaded' ),
			$this->widget_options,
			$this->control_options
		);
	}

	private function set_widget_options() {

		// Set up the widget options.
		$this->widget_options = array(
			'classname'   => 'rpr-nutritional-facts',
			'description' => esc_html__( 'A widget to dynamically display the nutritional facts label of a recipe.', 'recipepress-reloaded' ),
		);

		// Set up the widget control options.
		$this->control_options = array(
			'width'  => 325,
			'height' => 350,
		);
	}

	/**
	 * Register our widget, un-register the builtin widget.
	 */
	public function register_widget() {

		if ( Options::get_option( 'rpr_nutritional_facts_widget', true ) ) {
			register_widget( $this );
		}
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {

		// If there is an error, stop and return.
		if ( ! empty( $instance['error'] ) ) {
			return;
		}

        // If we are not on a single recipe page, stop and return.
        if ( ! is_singular( 'rpr_recipe' ) ) {
            return;
        }

		// Output the theme's $before_widget wrapper.
		echo $args['before_widget'];

		// Begin frontend output.
		$recipe = get_post( get_the_ID() );


        if ( ! $recipe ) {
            return;
        }

		$metadata = Template::get_the_recipe_meta( $recipe->ID );
        ob_start();
		?>

            <div class="rpr nutritional-facts">
                <div class="rpr nutritional-facts--header">
                    <h3><?php _e( 'Nutritional Facts', 'recipepress-reloaded' ); ?></h3>
                    <h4><?php echo esc_html( $recipe->post_title ); ?> </h4>
                    <p>
                        <?php _e( 'Serving Size', 'recipepress-reloaded' ); ?>:
                        <?php echo esc_html( $metadata[ 'rpr_recipe_servings' ] ); ?> <?php echo esc_html( $metadata[ 'rpr_recipe_servings_type' ] ); ?>
                    </p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th colspan="3" class="small-info">
                                Amount Per Serving: <span>1 piece</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="2"><strong><?php _e( 'Calories', 'recipepress-reloaded' ); ?></strong></th>
                            <td><?php echo esc_html( $metadata[ 'rpr_recipe_calorific_value' ] ); ?> kcal</td>
                        </tr>
                        <tr class="thick-row">
                            <td colspan="3" class="small-info"><strong><?php echo esc_html( '% Daily Value*' ); ?></strong></td>
                        </tr>
                        <tr>
                            <th colspan="2"><strong><?php _e( 'Total fat', 'recipepress-reloaded' ); ?></strong> <span><?php echo esc_html( $metadata[ 'rpr_recipe_fat' ] ); ?> g</span></th>
                            <td><strong><?php echo esc_html( '32%' ); ?></strong></td>
                        </tr>
                        <tr>
                            <td class="spacer-cell"></td>
                            <th><strong><?php _e( 'Saturated fat', 'recipepress-reloaded' ); ?></strong> <span><?php echo esc_html( $metadata[ 'rpr_recipe_transfatcontent' ] ); ?> g</span></th>
                            <td><strong><?php echo esc_html( '40%' ); ?></strong></td>
                        </tr>
                        <tr>
                            <td class="spacer-cell"></td>
                            <th><strong><?php _e( 'Trans fat', 'recipepress-reloaded' ); ?></strong> <span><?php echo esc_html( $metadata[ 'rpr_recipe_unsaturatedfatcontent' ] ); ?> g</span></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2"><strong><?php _e( 'Cholesterol', 'recipepress-reloaded' ); ?></strong> <span><?php echo esc_html( $metadata[ 'rpr_recipe_cholesterolcontent' ] ); ?> mg</span></th>
                            <td><strong><?php echo esc_html( '6%' ); ?></strong></td>
                        </tr>
                        <tr>
                            <th colspan="2"><strong><?php _e( 'Sodium', 'recipepress-reloaded' ); ?></strong> <span><?php echo esc_html( $metadata[ 'rpr_recipe_sodiumcontent' ] ); ?> mg</span></th>
                            <td><strong><?php echo esc_html( '22%' ); ?></strong></td>
                        </tr>
                        <tr>
                            <th colspan="2"><strong><?php _e( 'Total carbohydrates', 'recipepress-reloaded' ); ?></strong> <span><?php echo esc_html( $metadata[ 'rpr_recipe_carbohydrate' ] ); ?> mg</span></th>
                            <td><strong><?php echo esc_html( '12%' ); ?></strong></td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <style>
                .rpr-nutritional-facts {border:1px solid #000; padding:10px;}
                .rpr.nutritional-facts {font-family:sans-serif; font-weight:lighter;}
                .rpr.nutritional-facts--header h3, .rpr.nutritional-facts--header h4 {margin:0;}
                .rpr.nutritional-facts--header h3 {font-size:1.5em; font-weight:bold;}
                .rpr.nutritional-facts table {width:100%; border:0; border-spacing:0; border-collapse:collapse; font-size:0.9rem; table-layout:initial;}
                .rpr.nutritional-facts table th, .rpr.nutritional-facts table td {font-weight:normal; text-align:left; padding:4px 0; border:0; border-top:1px solid black;white-space:nowrap; font-size:12px;}
                .rpr.nutritional-facts table td {text-align:right;}
                .rpr.nutritional-facts table td.spacer-cell {width:16px; border-top:0;}
                .rpr.nutritional-facts table td.empty-cell {width:0; border-top:0;}
                .rpr.nutritional-facts table tr.thick-row > td {border-top-width:5px; text-align:right;}
            </style>

        <?php
		// Print out output.
		echo ob_get_clean();

		// Close the theme's widget wrapper.
		echo $args['after_widget'];
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 2.12.0
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {

		// Fill current state with old data to be sure we not loose anything
		$instance = $old_instance;

		// Check and sanitize all inputs.
		$instance['title'] = strip_tags( $new_instance['title'] );

		// Now we return new values and WordPress do all work for you.
		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 2.12.0
	 *
	 * @param object $instance
	 *
	 * @return void
	 *
	 */
	public function form( $instance ) {
		// Set up the default form values.
		$defaults = array(
			'title'         => '',
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( $instance, $defaults );
		$title   = sanitize_text_field( $instance['title'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?> ">
				<?php _e( 'Title (optional)', 'recipepress-reloaded' ); ?>:
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}
}

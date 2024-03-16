<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * @since 1.0.0
 */
class Elementor_CdQ_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'cdq';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve cdq widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Canvas Questionaire CDQ', 'hz-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-price-table';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'cdq', 'canvas', 'canvas drawing', 'custom', 'questionaire' ];
	}

    public function get_script_depends() {
		return [ 'cdq-canvas' ];
	}


	/**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'hz-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__( 'Title', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'hz-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Questions List', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'Write your first name using your finger.', 'hz-widgets' ),
					],
					[
						'list_title' => esc_html__( 'Write your date of birth using your finger.', 'hz-widgets' ),
					],
                    [
						'list_title' => esc_html__( 'Sign your signature using your finger.', 'hz-widgets' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'hz-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 390,
				]
			]
		);

        $this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 490,
				]
			]
		);

        $this->add_control(
			'pad',
			[
				'label' => esc_html__( 'Canvas Image', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => CDQ_PLUGIN_ASSETS_FILE . 'images/pad.webp',
				],
			]
		);

		$this->add_control(
			'add_gif',
			[
				'label' => esc_html__( 'Add Gif', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Gif', 'hz-widgets' ),
				'label_off' => esc_html__( 'Lottie', 'hz-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);


        $this->add_control(
			'animation',
			[
				'label' => esc_html__( 'Animation Image', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => CDQ_PLUGIN_ASSETS_FILE . 'images/Animation_1-min_V1-min-ezgif.com-gif-to-webp-converter.webp',
				],
				'condition' => [
					'add_gif' => 'yes',
				],
			]
		);

		$this->add_control(
			'lottie',
			[
				'label' => esc_html__( 'Lottie Json', 'hz-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['application/json'],
				'default' => [
					'url' => CDQ_PLUGIN_ASSETS_FILE . 'images/Version-1.json',
				],
				'condition' => [
					'add_gif!' => 'yes',
				],
			]
		);


		$this->end_controls_section();
	}



	/**
	 * Render list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
        $idint = $this->get_id();
        $id = 'canvas-' . $idint;

        $list = [];
        if ( $settings['list'] ) {
            foreach($settings['list'] as $key => $item){
                $list[$key] = $item['list_title'];
            }
		}


        ?>
        <style>

                .elementor-element-<?php echo $idint; ?>.elementor-invisible{
                    visibility: visible;
                }

                #<?php echo $id; ?> .draw-canvas, #<?php echo $id; ?> .overlay_canvas {
					touch-action: none;
					background-repeat: no-repeat;
					background-size: contain;
                }

                #<?php echo $id; ?> .buttons {
					position: absolute;
					bottom: 40px;
					padding: 0 30px;
					display: flex;
					justify-content: space-between;
					width: 100%;
					align-items: center;
					left: 0px;
					right: 0;
                }

                #<?php echo $id; ?> .canvas {
                    position: relative;
                    width: fit-content;                
                }
			
				#<?php echo $id; ?> .canvas p{
					text-align: center;
					font-size: 17px;
					line-height: 1.1em;
					color: #6E1414;
					font-family: "Abhaya Libre", Sans-serif;
					font-weight: bold;
					position: absolute;
					top: 35px;
					left: 0;
					right: 0;
					padding: 0 20px;
				}

                #<?php echo $id; ?> button {
					display: block;
					background: #174257;
					color: white;
					font-weight: normal;
					border: none;
					font-size: 20px;
					border: none;
					font-family: "Abhaya Libre", Sans-serif;
					padding: 2px 12px;
                }
			
			.op-0{
				opacity: 0;
			}

            .questions{
                position: relative;
            }

        </style>

		<div class="cdq_container" id="<?php echo $id; ?>" >
            <div class="questions">
                <div class="canvas op-0">
					<p><?php echo $list[0]; ?></p>
                    <canvas class="draw-canvas" style="background-image: url(<?php echo $settings['pad']['url']; ?>);"  width="<?php echo $settings['width']['size'] ?>" height="<?php echo $settings['height']['size'] ?>"></canvas>
                    <div class="buttons">
                        <button class="reset">ERASE</button>
                        <button class="next saveBtn">NEXT</button>
                    </div>
                </div>
				<div class="overlay_canvas" style="text-align: center; background-image: url(<?php echo $settings['pad']['url']; ?>);width: <?php echo $settings['width']['size'] ?>px; height: <?php echo $settings['height']['size'] ?>px; position: absolute; top: 0;">
					<?php if($settings['add_gif'] === 'yes') : ?>
					<img style="height: 50%;" src="<?php echo $settings['animation']['url']; ?>" />
					<?php else : ?>
						<tgs-player style="height: 50%;width: 100%;" autoplay loop mode="normal" src="<?php echo $settings['lottie']['url']; ?>">
						</tgs-player>
					<?php endif; ?>
					<button class="tap_to_start" style="margin:auto;" >
						TAP TO START
					</button>
				</div>
            </div>
        </div>

        <?php  //   if ( \Elementor\Plugin::$instance->editor->is_edit_mode()) : ?>
		<script>
            window.initializationFunctions.push(() => {
                const instance<?php echo $idint; ?> = new CanvasInitializer(<?php echo json_encode($list); ?>, <?php echo json_encode($id); ?>);
            });
        </script>
        <?php // endif; ?>
		<?php
	}

}
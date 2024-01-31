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

    // public function get_script_depends() {
	// 	return [ 'cdq-card' ];
	// }


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
						'list_title' => esc_html__( 'Title #1', 'hz-widgets' ),
					],
					[
						'list_title' => esc_html__( 'Title #2', 'hz-widgets' ),
					],
                    [
						'list_title' => esc_html__( 'Title #3', 'hz-widgets' ),
					],
                    [
						'list_title' => esc_html__( 'Title #4', 'hz-widgets' ),
					],
                    [
						'list_title' => esc_html__( 'Title #5', 'hz-widgets' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
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

        $list = [];
        if ( $settings['list'] ) {
            foreach($settings['list'] as $key => $item){
                $list[$key] = $item['list_title'];
            }
		}


        ?>
        <style>
                #canvas {
                    border: 4px solid black;
                    touch-action: none;
                    border-radius: 12px;
                }

                .cdq_container .buttons {
                    position: absolute;
                    bottom: 12px;
                    display: flex;
                    justify-content: space-between;
                    width: 100%;
                    align-items: center;
                    left: 0;
                    right: 0;
                }

                .cdq_container .canvas {
                    position: relative;
                    max-width: 352px;
                }

                .cdq_container button {
                    display: block;
                    background: transparent;
                    color: black;
                    font-weight: bold;
                    border: none;
                    font-size: 25px;
                    border: none;
                    outline: none;
                }

        </style>

        <div class="cdq_container">
            <div class="questions">
                <h2><?php echo $list[0]; ?></h2>
                <div class="canvas">
                    <canvas id="canvas" width="350" height="450"></canvas>
                    <div class="buttons">
                        <button class="reset">Reset</button>
                        <button id="saveBtn" class="next">Next</button>
                    </div>
                </div>
            </div>
            <div class="results">

            </div>
        </div>

        <?php  //   if ( \Elementor\Plugin::$instance->editor->is_edit_mode()) : ?>
            <script>
                const canvas = document.getElementById('canvas');
                const ctx = canvas.getContext('2d');

                    let isDrawing = false;
                    let lastX = 0;
                    let lastY = 0;

                    // Function to start drawing
                    function startDrawing(e) {
                        isDrawing = true;
                        [lastX, lastY] = [e.offsetX, e.offsetY];
                    }

                    // Function to draw when mouse is moved
                    function draw(e) {
                        if (!isDrawing) return;
                        ctx.beginPath();
                        ctx.moveTo(lastX, lastY);
                        ctx.lineTo(e.offsetX, e.offsetY);
                        ctx.strokeStyle = 'black';
                        ctx.lineWidth = 2;
                        ctx.stroke();
                        [lastX, lastY] = [e.offsetX, e.offsetY];
                    }

                    // Function to stop drawing
                    function stopDrawing() {
                        isDrawing = false;
                    }

                    // Function to start drawing with touch
                    function startDrawingTouch(e) {
                        e.preventDefault(); // Prevent scrolling on touch devices
                        isDrawing = true;
                        const rect = canvas.getBoundingClientRect(); // Get canvas bounding rectangle
                        const touch = e.touches[0];
                        [lastX, lastY] = [touch.clientX - rect.left, touch.clientY - rect.top];
                    }

                    // Function to draw with touch
                    function drawTouch(e) {
                        if (!isDrawing) return;
                        const rect = canvas.getBoundingClientRect(); // Get canvas bounding rectangle
                        const touch = e.touches[0];
                        const x = touch.clientX - rect.left;
                        const y = touch.clientY - rect.top;
                        ctx.beginPath();
                        ctx.moveTo(lastX, lastY);
                        ctx.lineTo(x, y);
                        ctx.strokeStyle = 'black';
                        ctx.lineWidth = 2;
                        ctx.stroke();
                        lastX = x;
                        lastY = y;
                    }

                    // Function to reset the canvas
                    function resetCanvas() {
                        ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas
                    }

                    // Event listeners for mouse
                    canvas.addEventListener('mousedown', startDrawing);
                    canvas.addEventListener('mousemove', draw);
                    canvas.addEventListener('mouseup', stopDrawing);
                    canvas.addEventListener('mouseout', stopDrawing);

                    canvas.addEventListener('touchstart', startDrawingTouch);
                    canvas.addEventListener('touchmove', drawTouch);
                    canvas.addEventListener('touchend', stopDrawing);
                    canvas.addEventListener('touchcancel', stopDrawing);

                    const questions = <?php echo json_encode($list); ?>;

                    const results = [];
                    let indx = 0;

                // Function to save drawing
                document.getElementById('saveBtn').addEventListener('click', function() {
                    const image = canvas.toDataURL(); // Get image data URL

                    const next = {question: questions[indx], url: image};
                    results.push(next);
                    indx++;
                    if(indx === questions.length){
                        let items = '';
                        results.forEach(element => {
                            const img = document.createElement('img'); // Create a link element
                            img.src = element.url; // Set href attribute to image data URL
                            const heading = document.createElement('h2'); // Create a link element
                            heading.innerHTML = element.question;
                            const item = document.createElement('div'); // Create a link element
                            item.classList.add("item");
                            item.appendChild(heading)
                            item.appendChild(img)
                            document.querySelector(".results").appendChild(item)
                        });
                        document.querySelector(".questions").style.display = "none";
                    }else{
                        document.querySelector(".cdq_container h2").innerHTML = questions[indx];
                        resetCanvas();
                    }
                });



                // Event listener for the reset button
                document.querySelector('.reset').addEventListener('click', resetCanvas);

            </script>
        <?php // endif; ?>
		<?php
	}

}
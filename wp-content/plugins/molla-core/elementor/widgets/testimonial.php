<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Countdown Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use ELementor\Group_Control_Background;
use ELementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class Molla_Elementor_Testimonial_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_testimonial';
	}

	public function get_title() {
		return esc_html__( 'Molla Testimonial', 'molla-core' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'rating', 'comment', 'review', 'customer' );
	}

	public function get_script_depends() {
		$scripts = array();
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'testimonial_content',
			array(
				'label' => esc_html__( 'Testimonial', 'molla-core' ),
			)
		);

			$this->add_control(
				'name',
				array(
					'label'   => esc_html__( 'Name', 'molla-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'John Doe',
				)
			);

			$this->add_control(
				'job',
				array(
					'label'   => esc_html__( 'Job', 'molla-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'Customer',
				)
			);

			$this->add_control(
				'title',
				array(
					'label'   => esc_html__( 'Title', 'molla-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => '',
				)
			);

			$this->add_control(
				'content',
				array(
					'label'   => esc_html__( 'Content', 'molla-core' ),
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => '10',
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'molla-core' ),
				)
			);

			$this->add_control(
				'content_line',
				array(
					'label'     => esc_html__( 'Maximum Content Line', 'molla-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '4',
					'selectors' => array(
						'{{WRAPPER}} .testimonial .comment' => '-webkit-line-clamp: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'avatar',
				array(
					'label' => esc_html__( 'Choose Avatar', 'molla-core' ),
					'type'  => Controls_Manager::MEDIA,
				)
			);

			$this->add_control(
				'link',
				array(
					'label'       => esc_html__( 'Link', 'molla-core' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'molla-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'avatar',
					'default'   => 'full',
					'separator' => 'none',
				)
			);

			$this->add_control(
				'rating',
				array(
					'label'   => esc_html__( 'Rating', 'molla-core' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 0,
					'max'     => 5,
					'step'    => 0.1,
					'default' => '',
				)
			);

			$this->add_control(
				'show_numeric_rating',
				array(
					'label' => esc_html__( 'Show Numeric Rating', 'molla-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'star_icon',
				array(
					'label'   => esc_html__( 'Star Icon', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''        => 'Theme',
						'fa-icon' => 'Font Awesome',
					),
				)
			);

			$this->add_control(
				'star_shape',
				array(
					'label'   => esc_html__( 'Star Style', 'molla-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						''        => array(
							'title' => esc_html__( 'Solid', 'molla-core' ),
							'icon'  => 'eicon-star',
						),
						'outline' => array(
							'title' => esc_html__( 'Outline', 'molla-core' ),
							'icon'  => 'eicon-star-o',
						),
					),
				)
			);

			$this->add_responsive_control(
				'max_width',
				array(
					'label'      => esc_html__( 'Max Width', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'em',
					),
					'selectors'  => array(
						'{{WRAPPER}} .testimonial' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'tesimonial_layout',
			array(
				'label' => esc_html__( 'Layout & Position', 'molla-core' ),
			)
		);

			$this->add_control(
				'avatar_pos',
				array(
					'label'   => esc_html__( 'Avatar Position', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'top',
					'options' => array(
						'aside'      => esc_html__( 'Aside', 'molla-core' ),
						'top'        => esc_html__( 'Top', 'molla-core' ),
						'bottom'     => esc_html__( 'Bottom', 'molla-core' ),
						'aside_info' => esc_html__( 'Aside Commenter', 'molla-core' ),
						'top_info'   => esc_html__( 'Top Commenter', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'commenter_pos',
				array(
					'label'   => esc_html__( 'Commenter Position', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'after',
					'options' => array(
						'before' => esc_html__( 'Before Comment', 'molla-core' ),
						'after'  => esc_html__( 'After Comment', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'rating_pos',
				array(
					'label'   => esc_html__( 'Rating Position', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'before',
					'options' => array(
						'before' => esc_html__( 'Before Comment', 'molla-core' ),
						'after'  => esc_html__( 'After Comment', 'molla-core' ),
					),
				)
			);

			$this->add_control(
				'v_align',
				array(
					'label'     => esc_html__( 'Horizontal Alignment', 'molla-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'molla-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'molla-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'molla-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .testimonial' => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'h_align',
				array(
					'label'     => esc_html__( 'Vertical Alignment', 'molla-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Top', 'molla-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'molla-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Bottom', 'molla-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .testimonial' => 'align-items: {{VALUE}};',
						'{{WRAPPER}} .commenter'   => 'align-items: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'avatar_style',
			array(
				'label' => esc_html__( 'Avatar', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'avatar_sz',
				array(
					'label'      => esc_html__( 'Size', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'em',
					),
					'selectors'  => array(
						'{{WRAPPER}} img'             => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .avatar::before' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'avatar_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .avatar::before' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'avatar_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .avatar' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'avatar_shadow',
					'selector' => '{{WRAPPER}} .avatar',
				)
			);

			$this->add_control(
				'avatar_divider',
				array(
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				)
			);

			$this->add_control(
				'avatar_pd',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .avatar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'avatar_mg',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => 'avatar_border',
					'selector' => '{{WRAPPER}} .avatar',
				)
			);

			$this->add_control(
				'avatar_br',
				array(
					'label'      => esc_html__( 'Border Radius', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			array(
				'label' => esc_html__( 'Title', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .comment-title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typography',
					'label'    => esc_html__( 'Typography', 'molla-core' ),
					'selector' => '{{WRAPPER}} .comment-title',
				)
			);

			$this->add_control(
				'title_mg',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .comment-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'comment_style',
			array(
				'label' => esc_html__( 'Comment', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'comment_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .comment' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'comment_typography',
					'label'    => esc_html__( 'Comment', 'molla-core' ),
					'selector' => '{{WRAPPER}} .comment',
				)
			);

			$this->add_control(
				'comment_pd',
				array(
					'label'      => esc_html__( 'Padding', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .comment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'comment_mg',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'name_style',
			array(
				'label' => esc_html__( 'Name', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'name_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .name' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'name_typography',
					'label'    => esc_html__( 'Name', 'molla-core' ),
					'selector' => '{{WRAPPER}} .name',
				)
			);

			$this->add_control(
				'name_mg',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'job_style',
			array(
				'label' => esc_html__( 'Job', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'job_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .job' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'job_typography',
					'label'    => esc_html__( 'Job', 'molla-core' ),
					'selector' => '{{WRAPPER}} .job',
				)
			);

			$this->add_control(
				'job_mg',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'rating_style',
			array(
				'label' => esc_html__( 'Rating', 'molla-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'numeric_rating_heading',
				array(
					'label' => esc_html__( 'Numeric Rating', 'molla-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_control(
				'numeric_rating_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .numeric:before' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'numeric_rating_typography',
					'label'    => esc_html__( 'Typography', 'molla-core' ),
					'selector' => '{{WRAPPER}} .numeric:before',
				)
			);

			$this->add_control(
				'numeric_rating_mg',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .numeric:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'star_rating_heading',
				array(
					'label'     => esc_html__( 'Star Icons', 'molla-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'rating_sz',
				array(
					'label'      => esc_html__( 'Size', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .star-rating' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'rating_sp',
				array(
					'label'      => esc_html__( 'Star Spacing', 'molla-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
					),
				)
			);

			$this->add_control(
				'rating_color',
				array(
					'label'     => esc_html__( 'Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .star-rating span' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'rating_blank_color',
				array(
					'label'     => esc_html__( 'Blank Color', 'molla-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .star-rating' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'rating_mg',
				array(
					'label'      => esc_html__( 'Margin', 'molla-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'{{WRAPPER}} .ratings-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_testimonial.php';
	}

	/**
	 * Render testimonial widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 */
	protected function content_template() {
		?><#
		var avatar_image = {
				id: settings.avatar.id,
				url: settings.avatar.url,
				size: settings.avatar_size,
				dimension: settings.avatar_custom_dimension,
				model: view.getEditModel()
			};

		var image = '',
			image_info;

		if ( '' !== settings.avatar.url ) {
			var imageHtml = '<img src="' + elementor.imagesManager.getImageUrl( avatar_image ) + '" alt="testimonial" />';
			if ( settings.link.url ) {
				imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
			}
			image = '<div class="avatar">' + imageHtml + '</div>';
		} else {
			image = '<div class="avatar icon"></div>';
		}

		if ( 'top' === settings.avatar_pos || 'bottom' == settings.avatar_pos || 'aside' === settings.avatar_pos ) {
			image_info = '';
		} else {
			image_info = image;
			image = '';
		}

		view.addRenderAttribute( 'content', 'class', 'comment' );
		view.addInlineEditingAttributes( 'content' );
		view.addRenderAttribute( 'name', 'class', 'name' );
		view.addInlineEditingAttributes( 'name' );
		view.addRenderAttribute( 'job', 'class', 'job' );
		view.addInlineEditingAttributes( 'job' );

		var commentor = '<cite><span ' + view.getRenderAttributeString( 'name' ) + '>' + settings.name +
			'</span><span ' + view.getRenderAttributeString( 'job' ) + '>' + settings.job + '</span></cite>';
		#>
		<blockquote class="testimonial {{ settings.avatar_pos }}">
			<#
			if ( 'bottom' !== settings.avatar_pos ) { #>
				{{{ image }}}
			<# }
			
			if ( 'aside' === settings.avatar_pos ) { #>
				<div class="content">
			<# }

			if ( 'before' === settings.commenter_pos ) { #>
				<div class="commenter">{{{ image_info }}}{{{ commentor }}}</div>
			<# }
			
			var rating_wrap_class = 'ratings-container';
			if ('yes' == settings.show_numeric_rating) {
				rating_wrap_class += ' numeric';
			}
			if ( '' !== settings.rating && 'before' == settings.rating_pos ) {
				var rating_cls = '';
				if ( settings.star_icon ) {
					rating_cls += ' ' + settings.star_icon;
				}
				if ( settings.star_shape ) {
					rating_cls += ' ' + settings.star_shape;
				}

				view.addRenderAttribute( 'rating', 'style', 'width: calc(' + ( 20 * settings.rating ) + '% - ' + ( settings.rating_sp.size * ( settings.rating - Math.floor( settings.rating ) ) ) + 'px);' );
				view.addInlineEditingAttributes( 'rating' );
				#>
				<div class="{{{rating_wrap_class}}}" data-rating="{{{settings.rating}}} / 5.0"><div class="star-rating{{ rating_cls }}" style="letter-spacing: {{ settings.rating_sp.size }}px;"><span {{{ view.getRenderAttributeString( 'rating' ) }}}></span></div></div>
			<#
			}

			if ( '' !== settings.title ) {
				view.addRenderAttribute( 'title', 'class', 'comment-title' );
				view.addInlineEditingAttributes( 'title' );
				#>
				<h5 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h5>
				<#
			}

			#>
			<p {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</p>
			<#

			if ( '' !== settings.rating && 'after' == settings.rating_pos ) {
				var rating_cls = '';
				if ( settings.star_icon ) {
					rating_cls += ' ' + settings.star_icon;
				}
				if ( settings.star_shape ) {
					rating_cls += ' ' + settings.star_shape;
				}
				view.addRenderAttribute( 'rating', 'style', 'width: calc(' + ( 20 * settings.rating ) + '% - ' + ( settings.rating_sp.size * ( settings.rating - Math.floor( settings.rating ) ) ) + 'px);' );
				view.addInlineEditingAttributes( 'rating' );
				#>
				<div class="{{{rating_wrap_class}}}" data-rating="{{{settings.rating}}} / 5.0"><div class="star-rating{{ rating_cls }}" style="letter-spacing: {{ settings.rating_sp.size }}px;"><span {{{ view.getRenderAttributeString( 'rating' ) }}}></span></div></div>
			<#
			}

			if ( 'after' === settings.commenter_pos ) { #>
				<div class="commenter">{{{ image_info }}}{{{ commentor }}}</div>
			<# }

			if ( 'aside' === settings.avatar_pos ) { #>
				</div>
			<# }
			
			if ( 'bottom' === settings.avatar_pos ) { #>
				{{{ image }}}
			<# } #>
		</blockquote>
		<?php
	}
}

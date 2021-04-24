/**
 * Molla Gutenberg blocks
 *
 * 1. Molla Carousel
 * 2. Molla Banner
 * 3. Molla Product
 * 4. Molla Product Category
 * 5. Molla Blog
 * 6. Molla Heading
 * 7. Molla Icon-Box
 * 8. Molla Button
 * 9. Molla Section
 * /

/**
 * 1. Molla Carousel
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		el = wpElement.createElement,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		SelectControl = wpComponents.SelectControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl;

	class Molla_Carousel extends Component {
		constructor() {
			super(...arguments);
		}

		componentDidMount() { }

		componentDidUpdate(prevProps, prevState) { }

		render() {
			var props = this.props,
				attrs = props.attributes,
				clientId = props.clientId;

			var inspectorControls = el(InspectorControls, {},

				el(PanelBody, {
					title: __('Carousel Options'),
					initialOpen: false,
				},
					el(RangeControl, {
						label: __('Columns'),
						value: attrs.slider_col_cnt,
						min: 1,
						max: 8,
						onChange: (value) => { props.setAttributes({ slider_col_cnt: value }); },
					}),
					el(RangeControl, {
						label: __('Spacing'),
						value: attrs.slider_spacing,
						min: 0,
						max: 40,
						onChange: (value) => { props.setAttributes({ slider_spacing: value }); },
					}),
					el(SelectControl, {
						label: __('Nav & Dot Position'),
						value: attrs.slider_nav_pos,
						options: [{ label: __('Inner'), value: 'owl-nav-inside' }, { label: __('Outer'), value: '' }],
						onChange: (value) => { props.setAttributes({ slider_nav_pos: value }); },
					}),
					el(SelectControl, {
						label: __('Nav Type'),
						value: attrs.slider_nav_type,
						options: [{ label: __('Type 1'), value: '' }, { label: __('Type 2'), value: 'owl-full' }],
						onChange: (value) => { props.setAttributes({ slider_nav_type: value }); },
					}),
					el(ToggleControl, {
						label: __('Enable Nav'),
						checked: attrs.slider_nav,
						onChange: (value) => { props.setAttributes({ slider_nav: value }); },
					}),
					el(ToggleControl, {
						label: __('Enable Dots'),
						checked: attrs.slider_dot,
						onChange: (value) => { props.setAttributes({ slider_dot: value }); },
					}),
					el(ToggleControl, {
						label: __('Enable Loop'),
						checked: attrs.slider_loop,
						onChange: (value) => { props.setAttributes({ slider_loop: value }); },
					}),
				),
			);


			let owl_class = '';
			let owl_option_ary = {};

			owl_class += 'owl-carousel owl-simple col-' + attrs.slider_col_cnt;
			if (attrs.slider_nav_pos) {
				owl_class += ' ' + attrs.slider_nav_pos;
			}
			if (attrs.slider_nav_type) {
				owl_class += ' ' + attrs.slider_nav_type;
			}
			owl_option_ary = {
				margin: '' !== attrs.slider_spacing ? attrs.slider_spacing : 20,
				loop: 'yes' == attrs.slider_loop ? true : false,
				responsive: {
					0: {
						items: 2,
					},
					768: {
						items: '' !== attrs.slider_col_cnt ? Number(attrs.slider_col_cnt) : 2,
					},
					992: {
						items: '' !== attrs.slider_col_cnt ? Number(attrs.slider_col_cnt) : 4,
					},
					1200: {
						items: '' !== attrs.slider_col_cnt ? Number(attrs.slider_col_cnt) : 4,
					}
				}
			};
			owl_option_ary = JSON.stringify(owl_option_ary);

			var renderControls = el(
				'div',
				{ className: 'molla-carousel' },
				el(
					'style',
					{ 'type': 'text/css' },
					'#block-' + clientId + ' .block-editor-block-list__layout>div { ' + 'padding-left: ' + attrs.slider_spacing / 2 + 'px; padding-right: ' + attrs.slider_spacing / 2 + 'px; }' +
					'#block-' + clientId + ' .block-editor-block-list__layout { ' + 'margin-left: -' + attrs.slider_spacing / 2 + 'px; margin-right: -' + attrs.slider_spacing / 2 + 'px; }',
				),
				el(
					'div',
					{ className: owl_class, 'data-toggle': 'owl', 'data-owl-options': owl_option_ary },
					el(InnerBlocks),
				),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	}

	registerBlockType('molla/molla-carousel', {
		title: 'Molla Carousel',
		icon: 'molla',
		category: 'molla',
		attributes: {
			slider_col_cnt: {
				type: 'int',
				default: 3,
			},
			slider_spacing: {
				type: 'int',
				default: 20,
			},
			slider_nav_pos: {
				type: 'string',
				default: '',
			},
			slider_nav_type: {
				type: 'string',
				default: '',
			},
			slider_nav: {
				type: 'boolean',
				default: false,
			},
			slider_dot: {
				type: 'boolean',
				default: true,
			},
			slider_loop: {
				type: 'boolean',
				default: false,
			}
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Carousel,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash);


/**
 * 2. Molla Banner
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		MediaUpload = wpEditor.MediaUpload,
		el = wpElement.createElement,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		TextControl = wpComponents.TextControl,
		SelectControl = wpComponents.SelectControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl,
		IconButton = wpComponents.IconButton;

	class Molla_Banner extends Component {

		constructor() {
			super(...arguments);
		}

		componentDidMount() { }

		componentDidUpdate(prevProps, prevState) { }

		render() {
			var props = this.props,
				attrs = props.attributes;

			var inspectorControls = el(InspectorControls, {},

				el(PanelBody, {
					title: __('Banner Options'),
					initialOpen: false,
				},
					el(MediaUpload, {
						label: __('Background Image'),
						allowedTypes: ['image'],
						value: attrs.banner_img,
						onSelect: (img) => { props.setAttributes({ banner_img_url: img.url, banner_img: img.id }); },
						render: function render(_ref) {
							var open = _ref.open;
							return el(IconButton, {
								className: 'components-toolbar__control',
								label: __('Banner Image'),
								icon: 'edit',
								onClick: open
							});
						}
					}),
					el(IconButton, {
						className: 'components-toolbar__control',
						label: __('Remove image'),
						icon: 'no',
						onClick: function onClick() {
							return props.setAttributes({ banner_img_url: undefined, banner_img: undefined });
						}
					}),
					el(ToggleControl, {
						label: __('Use image as background style'),
						checked: attrs.fixed_img,
						onChange: (value) => { props.setAttributes({ fixed_img: value }); },
					}),
					attrs.fixed_img && el(ToggleControl, {
						label: __('Background Parallax'),
						checked: attrs.parallax,
						onChange: (value) => { props.setAttributes({ parallax: value }); },
					}),
					attrs.fixed_img && attrs.parallax && el(RangeControl, {
						label: __('Parallax Speed'),
						value: attrs.parallax_speed,
						min: 1,
						max: 10,
						onChange: (value) => { props.setAttributes({ parallax_speed: value }); },
					}),
					!attrs.fixed_img && el(TextControl, {
						label: __('Image min-height(px)'),
						type: 'number',
						value: attrs.min_height,
						onChange: (value) => { props.setAttributes({ min_height: value }); },
					}),
					!attrs.fixed_img && el(RangeControl, {
						label: __('Width(%)'),
						value: attrs.width,
						min: 0,
						max: 100,
						onChange: (value) => { props.setAttributes({ width: value }); },
					}),
					!attrs.fixed_img && el(RangeControl, {
						label: __('Content Position X(%)'),
						value: attrs.x_pos,
						min: 0,
						max: 100,
						onChange: (value) => { props.setAttributes({ x_pos: value }); },
					}),
					!attrs.fixed_img && el(RangeControl, {
						label: __('Content Position Y(%)'),
						value: attrs.y_pos,
						min: 0,
						max: 100,
						onChange: (value) => { props.setAttributes({ y_pos: value }); },
					}),
					!attrs.fixed_img && el(SelectControl, {
						label: __('Origin X Pos'),
						value: attrs.t_x_pos,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ t_x_pos: value }); },
					}),
					!attrs.fixed_img && el(SelectControl, {
						label: __('Origin Y Pos'),
						value: attrs.t_y_pos,
						options: [{ label: __('Top'), value: 'top' }, { label: __('Center'), value: 'center' }, { label: __('Bottom'), value: 'bottom' }],
						onChange: (value) => { props.setAttributes({ t_y_pos: value }); },
					}),
					attrs.fixed_img && el(TextControl, {
						label: __('Padding Top(px)'),
						type: 'number',
						value: attrs.pd_top,
						onChange: (value) => { props.setAttributes({ pd_top: value }); },
					}),
					attrs.fixed_img && el(TextControl, {
						label: __('Padding Right(px)'),
						type: 'number',
						value: attrs.pd_right,
						onChange: (value) => { props.setAttributes({ pd_right: value }); },
					}),
					attrs.fixed_img && el(TextControl, {
						label: __('Padding Bottom(px)'),
						type: 'number',
						value: attrs.pd_bottom,
						onChange: (value) => { props.setAttributes({ pd_bottom: value }); },
					}),
					attrs.fixed_img && el(TextControl, {
						label: __('Padding Left(px)'),
						type: 'number',
						value: attrs.pd_left,
						onChange: (value) => { props.setAttributes({ pd_left: value }); },
					}),
				),
			);

			let content_class = 'banner-content';
			let content_style = '';
			let img_style = '';

			if (!attrs.fixed_img) {
				content_class += ' fixed';
				if (attrs.x_pos) {
					content_class += ' b-x-' + attrs.x_pos;
				}
				if (attrs.y_pos) {
					content_class += ' b-y-' + attrs.y_pos;
				}
				content_class += ' b-t-x-' + attrs.t_x_pos;
				content_class += ' b-t-y-' + attrs.t_y_pos;

				if (attrs.min_height) {
					img_style = 'min-height:' + Number(attrs.min_height) + 'px;';
				}
				content_style = 'width: ' + attrs.width + '%;';
			} else {
				content_style = 'padding: ' + Number(attrs.pd_top) + 'px '
					+ Number(attrs.pd_right) + 'px '
					+ Number(attrs.pd_bottom) + 'px '
					+ Number(attrs.pd_left) + 'px;';
				if (attrs.banner_img_url) {
					content_style += ' background-image: url("' + attrs.banner_img_url + '"); background-repeat: no-repeat; background-size: cover; background-position: center;';
				}
			}

			var renderControls = el(
				'div',
				{ className: 'banner' },
				!attrs.fixed_img && attrs.banner_img_url && el(
					'img',
					{ className: 'fixed-img', src: attrs.banner_img_url, Style: img_style },
				),
				el(
					'div',
					{ className: content_class, Style: content_style },
					el(InnerBlocks),
				),
			);


			return [
				inspectorControls,
				renderControls,
			];
		}
	}

	registerBlockType('molla/molla-banner', {
		title: 'Molla Banner',
		icon: 'molla',
		category: 'molla',
		attributes: {
			banner_img: {
				type: 'int',
			},
			banner_img_url: {
				type: 'string',
			},
			fixed_img: {
				type: 'boolean',
				default: false,
			},
			parallax: {
				type: 'boolean',
				default: false,
			},
			parallax_speed: {
				type: 'int',
				default: 4,
			},
			width: {
				type: 'int',
			},
			min_height: {
				type: 'int',
			},
			x_pos: {
				type: 'int',
				default: 50,
			},
			y_pos: {
				type: 'int',
				default: 50,
			},
			t_x_pos: {
				type: 'string',
				default: 'left',
			},
			t_y_pos: {
				type: 'string',
				default: 'center',
			},
			pd_top: {
				type: 'int',
				default: 20,
			},
			pd_right: {
				type: 'int',
				default: 20,
			},
			pd_bottom: {
				type: 'int',
				default: 20,
			},
			pd_left: {
				type: 'int',
				default: 20,
			}
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Banner,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash);

/**
 * 3. Molla Product
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash, apiFetch) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		MediaUpload = wpEditor.MediaUpload,
		el = wpElement.createElement,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		TextControl = wpComponents.TextControl,
		SelectControl = wpComponents.SelectControl,
		CheckboxControl = wpComponents.CheckboxControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl,
		IconButton = wpComponents.IconButton;

	class Molla_Products extends Component {
		constructor() {
			super(...arguments);

			this.state = {
				categoriesList: [],
				products: [],
				categories_loaded: false,
			};
		}

		componentDidMount() {
			var _this = this;
			this.fetchProducts();
			this.productSlideCtrl();
		}

		componentDidUpdate(prevProps, prevState) {
			var _this = this,
				attrs = this.props.attributes,
				prevAttrs = prevProps.attributes,
				categoriesList = this.state.categoriesList;

			if (!this.state.categories_loaded && categoriesList.length === 0) {
				wp.apiFetch({ path: '/wc/v2/products/categories' }).then(function (obj) {
					_this.setState({ categoriesList: obj, categories_loaded: true });
				});
			}

			if (attrs.layout_mode == 'slider') {

				if (prevAttrs.layout_mode == 'creative') {
					this.destroyIsotope('.products');
				}

				if (_this.state.products != prevState.products ||
					attrs.layout_mode != prevAttrs.layout_mode ||
					attrs.spacing != prevAttrs.spacing ||
					attrs.columns != prevAttrs.columns ||
					attrs.product_slider_nav_pos != prevAttrs.product_slider_nav_pos ||
					attrs.product_slider_nav_type != prevAttrs.product_slider_nav_type ||
					attrs.slider_nav != prevAttrs.slider_nav ||
					attrs.slider_dot != prevAttrs.slider_dot) {

					this.initSlider();

				}

			} else if (attrs.layout_mode == 'grid') {

				if (prevAttrs.layout_mode == 'slider') {
					this.destroySlider();
				} else if (prevAttrs.layout_mode == 'creative') {
					this.destroyIsotope('.products');
				}

			} else if (attrs.layout_mode == 'creative') {

				if (prevAttrs.layout_mode == 'slider') {
					this.destroySlider();
					this.initIsotope('.products', '.product-col');
				}

				if (_this.state.products != prevState.products ||
					attrs.layout_mode != prevAttrs.layout_mode ||
					attrs.spacing != prevAttrs.spacing ||
					attrs.columns != prevAttrs.columns) {

					this.initIsotope('.products', '.product-col');

				}
			}

			if (this.getQuery() !== this.state.query) {
				if (attrs.layout_mode == 'slider') {
					this.destroySlider();
				}
				this.fetchProducts();
			}
		}

		getQuery() {
			var attrs = this.props.attributes,
				columns = attrs.columns,
				status = attrs.status;

			var query = {
				per_page: attrs.count
			};


			if (attrs.categories_op === 'selected') {
				query.ids = attrs.categories.join(',')
			}
			if (status == 'featured') {
				query.featured = 1;
			}
			if (status == 'on_sale') {
				query.on_sale = 1;
			}
			query.orderby = attrs.orderby;
			query.order = attrs.order;

			var query_string = '?';
			var _iteratorNormalCompletion = true;
			var _didIteratorError = false;
			var _iteratorError = undefined;

			for (var _iterator = Object.keys(query)[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
				var key = _step.value;

				query_string += key + '=' + query[key] + '&';
			}

			var endpoint = '/mollawc/v1/products' + query_string;
			return endpoint;
		}

		initSlider() {
			var attrs = this.props.attributes;
			this.destroySlider();
			jQuery('.products').owlCarousel({
				items: attrs.columns,
				nav: attrs.slider_nav,
				dots: attrs.slider_dot,
				margin: attrs.spacing,
			}).removeClass('c-lg-' + attrs.columns);
		}

		destroySlider() {
			var attrs = this.props.attributes;
			var $products = jQuery('.products');
			$products.trigger('destroy.owl.carousel').addClass(' c-lg-' + attrs.columns);;
		}

		initIsotope($container, $selector) {
			var _this = this;

			_this.destroyIsotope($container);

			jQuery($container).imagesLoaded(function () {
				jQuery($container).isotope({
					itemSelector: $selector,
					percentPosition: true,
					masonry: {
						horizontalOrder: true
					}
				});
			});

			jQuery('body').on('click', '.product-filter a', function (e) {
				var $this = jQuery(this),
					filter = $this.attr('data-filter');

				// Remove active class
				jQuery('.product-filter').find('.active').removeClass('active');

				// Init filter
				var $container = jQuery('.product-filter').closest('.toolbox').siblings($container);
				$container.isotope({
					filter: filter,
					transitionDuration: '0.35s'
				});

				// Add active class
				$this.closest('li').addClass('active');
				e.preventDefault();
			});
			jQuery('.filter-toggler').on('click', function (e) {
				e.preventDefault();
			})
		}

		destroyIsotope($container) {

			if (jQuery($container).data('isotope')) {
				jQuery($container).isotope('destroy');
			}
		}

		setCategories(catID, isAdd) {
			var props = this.props,
				attrs = props.attributes,
				setAttributes = props.setAttributes;
			var categories = attrs.categories;

			if (isAdd) {
				categories = [].concat(categories, [catID]);
			} else {
				categories = categories.filter(function (cat) {
					return cat !== catID;
				});
			}
			setAttributes({ category: categories.join(','), categories: categories });
		}

		fetchProducts() {
			var _this = this;
			var query = this.getQuery();

			_this.setState({
				query: query
			});

			apiFetch({ path: query }).then(function (products) {
				_this.setState({
					products: products,
				});
			});
		}

		// View sections
		sectionFigure(product) {
			var attrs = this.props.attributes;
			return el(
				'figure',
				{ className: 'product-media' },
				product.images.length && el(
					'a',
					{ href: '#' },
					el(
						'img',
						{ src: product.images[0].src },
					),
				),
				attrs.product_style != 'list' && this.sectionActionVertical(),
				(attrs.product_style == 'default' || attrs.product_style == 'light' || attrs.product_style == 'dark') && this.sectionAction(),
			);
		}

		sectionActionVertical() {
			var attrs = this.props.attributes;
			return el(
				'div',
				{ className: 'product-action-vertical' },
				attrs.product_style != 'classic' && el(
					'div',
					{ className: 'yith-wcwl-add-to-wishlist' },
					el(
						'a',
						{ className: 'btn-product-icon add_to_wishlist' },
					),
				),
				attrs.product_style != 'popup' && attrs.product_style != 'no-overlay' && el(
					'a',
					{ className: 'btn-product-icon btn-quickview' },
					el(
						'span',
						{},
						__('Quick view'),
					),
				),
			);
		}

		sectionAction() {
			var attrs = this.props.attributes;
			return el(
				'div',
				{ className: 'product-action' + (attrs.icon_hidden ? ' icon-hidden' : '') },
				el(
					'a',
					{ className: 'btn-product btn-cart add_to_cart_button' },
					el(
						'span',
						{},
						__('Add to cart'),
					),
				),
				(attrs.product_style == 'popup' || attrs.product_style == 'no-overlay') && el(
					'a',
					{ className: 'btn-product btn-quickview' },
					el(
						'span',
						{},
						__('Quick view'),
					),
				),
				attrs.product_style == 'classic' && el(
					'div',
					{ className: 'yith-wcwl-add-to-wishlist' },
					el(
						'a',
						{ className: 'add_to_wishlist' },
						el(
							'span',
							{},
							__('Add to wishlist'),
						),
					),
				),
			);
		}

		sectionBody(product, categories) {
			var attrs = this.props.attributes;
			return el(
				'div',
				{ className: 'product-body' },
				attrs.product_style == 'slide' && this.sectionAction(),
				el(
					'div',
					{ className: 'product-cat' },
					categories,
				),
				el(
					'h3',
					{ className: 'product-title' },
					product.name,
					attrs.product_style == 'list' && el(
						'div',
						{ className: 'yith-wcwl-add-to-wishlist' },
						el(
							'a',
							{ className: 'add_to_wishlist' },
							el(
								'span',
								{},
							),
						),
					),
				),
				attrs.product_style != 'list' && this.sectionPrice(product),


				attrs.product_style == 'classic' && this.sectionFooter(product),
				attrs.product_style == 'simple' && this.sectionAction(),

			);
		}

		sectionPrice(product) {

			return el(
				'div',
				{ className: 'price', dangerouslySetInnerHTML: { __html: product.price_html } }
			);
		}

		sectionFooter(product) {
			var attrs = this.props.attributes;
			return el(
				'div',
				{ className: 'product-footer' },
				attrs.product_style != 'slide' && this.sectionAction(),
			);
		}

		sectionListedAction(product) {
			var attrs = this.props.attributes;
			return el(
				'div',
				{ className: 'product-list-action' + (attrs.icon_hidden ? ' icon-hidden' : '') },
				this.sectionPrice(product),
				el(
					'div',
					{ className: 'product-action' },
					el(
						'a',
						{ className: 'btn-product btn-quickview' },
						el(
							'span',
							{},
							__('Quick view'),
						),
					),
				),
				el(
					'a',
					{ className: 'btn-product btn-cart add_to_cart_button' },
					el(
						'span',
						{},
						__('Add to cart'),
					),
				),
			);
		}

		productSlideCtrl() {
			// Product hover
			jQuery('body').on('mouseenter', '.product-popup', function () {
				var $this = jQuery(this),
					animDiff = ($this.outerHeight() - ($this.find('.product-body').outerHeight() + $this.find('.product-media').outerHeight())),
					animDistance = ($this.find('.product-footer').outerHeight() - animDiff);
				if ($this.hasClass('product-slide')) {
					animDistance = $this.find('.product-footer').outerHeight();
					$this.find('.product-body').css('transform', 'translateY(calc(-100% - ' + animDistance + 'px))');
					animDistance = $this.find('.product-body').outerHeight();
					$this.find('.product-footer').css({ 'visibility': 'visible', 'transform': 'translateY(' + -animDistance + 'px)' });
				}
				else {
					$this.find('.product-footer').css({ 'visibility': 'visible', 'transform': 'translateY(0)' });
					$this.find('.product-body').css('transform', 'translateY(' + -animDistance + 'px)');
				}

			});
			jQuery('body').on('mouseleave', '.product-popup', function () {
				var $this = jQuery(this);

				$this.find('.product-footer').css({ 'visibility': 'hidden', 'transform': 'translateY(100%)' });
				$this.find('.product-body').css('transform', 'translateY(0)');
			});
		}

		render() {
			var _this = this,
				props = this.props,
				attrs = props.attributes,
				categoriesList = this.state.categoriesList;

			var inspectorControls = el(InspectorControls, {},
				el(PanelBody, {
					title: __('Products Selector'),
					initialOpen: true,
				},
					el(TextControl, {
						label: __('Title'),
						value: attrs.title,
						onChange: (value) => { props.setAttributes({ title: value }); },
					}),
					el(SelectControl, {
						label: __('Title Align'),
						value: attrs.title_align,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ title_align: value }); },
					}),
					el(SelectControl, {
						label: __('Product Status'),
						value: attrs.status,
						options: [{ label: __('All'), value: '' }, { label: __('Featured'), value: 'featured' }, { label: __('On Sale'), value: 'on_sale' }],
						onChange: (value) => { props.setAttributes({ status: value }); },
					}),
					el(SelectControl, {
						label: __('Category'),
						value: attrs.categories_op,
						options: [{ label: __('All'), value: '' }, { label: __('Select Mode'), value: 'selected' }],
						onChange: (value) => { props.setAttributes({ categories_op: value }); },
					}),
					attrs.categories_op === 'selected' && el(
						'div',
						{ className: 'molla-check-list' },
						categoriesList.map(function (cat, index) {
							return el(CheckboxControl, {
								key: index,
								label: [cat.name, el(
									'span',
									{ key: 'cat-count', style: { fontSize: 'small', color: '#888', marginLeft: 5 } },
									'(',
									cat.count,
									')'
								)],
								checked: jQuery.inArray(cat.id, attrs.categories) > -1,
								onChange: function onChange(checked) {
									return _this.setCategories(cat.id, checked);
								}
							});
						})
					),
					el(RangeControl, {
						label: __('Product Count'),
						value: attrs.count,
						min: 1,
						max: 100,
						onChange: (value) => { props.setAttributes({ count: value }); },
					}),
					el(SelectControl, {
						label: __('Order By'),
						value: attrs.orderby,
						options: [{ label: '', value: '' }, { label: __('Title'), value: 'title' }, { label: __('ID'), value: 'ID' }, { label: __('Date'), value: 'date' }, { label: __('Modified'), value: 'modified' }, { label: __('Random'), value: 'rand' }, { label: __('Comment Count'), value: 'comment_count' }, { label: __('Popularity'), value: 'popularity' }, { label: __('Rating'), value: 'rating' }, { label: __('Total Sales'), value: 'total_sales' }],
						onChange: (value) => { props.setAttributes({ orderby: value }); },
					}),
					el(SelectControl, {
						label: __('Order'),
						value: attrs.order,
						options: [{ label: '', value: '' }, { label: __('Descending'), value: 'desc' }, { label: __('Ascending'), value: 'asc' }],
						onChange: (value) => { props.setAttributes({ order: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Products Layout'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Layout Mode'),
						value: attrs.layout_mode,
						options: [{ label: __('Grid'), value: 'grid' }, { label: __('Grid Creative'), value: 'creative' }, { label: __('Slider'), value: 'slider' }],
						onChange: (value) => { props.setAttributes({ layout_mode: value }); },
					}),
					el(RangeControl, {
						label: __('Spacing(px)'),
						value: attrs.spacing,
						min: 0,
						max: 40,
						onChange: (value) => { props.setAttributes({ spacing: value }); },
					}),
					el(SelectControl, {
						label: __('Columns'),
						value: attrs.columns,
						options: [{ label: __('1'), value: '1' }, { label: __('2'), value: '2' }, { label: __('3'), value: '3' }, { label: __('4'), value: '4' }, { label: __('5'), value: '5' }, { label: __('6'), value: '6' }, { label: __('7'), value: '7' }, { label: __('8'), value: '8' }],
						onChange: (value) => { props.setAttributes({ columns: value }); },
					}),
					'creative' == attrs.layout_mode && el(ToggleControl, {
						label: __('Show Category Filter'),
						checked: attrs.filter,
						onChange: (value) => { props.setAttributes({ filter: value }); },
					}),
					'slider' == attrs.layout_mode && el(SelectControl, {
						label: __('Nav & Dot Position'),
						value: attrs.product_slider_nav_pos,
						options: [{ label: __('Inner'), value: 'owl-nav-inside' }, { label: __('Outer'), value: '' }, { label: __('Top'), value: 'owl-nav-top' }],
						onChange: (value) => { props.setAttributes({ product_slider_nav_pos: value }); },
					}),
					'slider' == attrs.layout_mode && el(SelectControl, {
						label: __('Nav Type'),
						value: attrs.product_slider_nav_type,
						options: [{ label: __('Type 1'), value: '' }, { label: __('Type 2'), value: 'owl-full' }, { label: __('Type 3'), value: 'owl-nav-rounded' }],
						onChange: (value) => { props.setAttributes({ product_slider_nav_type: value }); },
					}),
					'slider' == attrs.layout_mode && el(ToggleControl, {
						label: __('Show navigation?'),
						checked: attrs.slider_nav,
						onChange: (value) => { props.setAttributes({ slider_nav: value }); },
					}),
					'slider' == attrs.layout_mode && el(ToggleControl, {
						label: __('Show slider dots?'),
						checked: attrs.slider_dot,
						onChange: (value) => { props.setAttributes({ slider_dot: value }); },
					}),
					el(ToggleControl, {
						label: __('View More'),
						checked: attrs.view_more,
						onChange: (value) => { props.setAttributes({ view_more: value }); },
					}),
					attrs.view_more && el(TextControl, {
						label: __('Button Label'),
						value: attrs.view_more_label,
						onChange: (value) => { props.setAttributes({ view_more_label: value }); },
					}),
					attrs.view_more && el(TextControl, {
						label: __('Button Icon'),
						value: attrs.view_more_icon,
						onChange: (value) => { props.setAttributes({ view_more_icon: value }); },
					}),
					attrs.view_more && el(RangeControl, {
						label: __('More Products Count'),
						value: attrs.view_more_count,
						min: 1,
						max: 20,
						onChange: (value) => { props.setAttributes({ view_more_count: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Products Style'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Product Type'),
						value: attrs.product_style,
						options: [{ label: __('Default'), value: 'default' }, { label: __('Classic'), value: 'classic' }, { label: __('List'), value: 'list' }, { label: __('Simple'), value: 'simple' }, { label: __('Popup 1'), value: 'popup' }, { label: __('Popup 2'), value: 'no-overlay' }, { label: __('Slide Over'), value: 'slide' }, { label: __('Light'), value: 'light' }, { label: __('Dark'), value: 'dark' }],
						onChange: (value) => { props.setAttributes({ product_style: value }); },
					}),
					el(SelectControl, {
						label: __('Align Content'),
						value: attrs.product_align,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ product_align: value }); },
					}),
					el(ToggleControl, {
						label: __('Enable border'),
						checked: attrs.product_border,
						onChange: (value) => { props.setAttributes({ product_border: value }); },
					}),
					el(ToggleControl, {
						label: __('Hide Icon'),
						checked: attrs.icon_hidden,
						onChange: (value) => { props.setAttributes({ icon_hidden: value }); },
					}),
				),

			);

			var wrapper_class = 'products columns-' + attrs.columns;
			if (attrs.layout_mode == 'slider') {
				wrapper_class += ' owl-carousel owl-simple' + (attrs.product_slider_nav_pos ? ' ' + attrs.product_slider_nav_pos : '') + (attrs.product_slider_nav_type ? ' ' + attrs.product_slider_nav_type : '');
				if (attrs.product_style == 'classic') {
					wrapper_class += ' block-wrapper';
				}
			}
			wrapper_class += (attrs.product_border ? ' split-line' : '');

			var renderControls = el(
				'div',
				{ className: 'products-wrapper' },
				attrs.title && el(
					'h2',
					{ className: 'title text-' + attrs.title_align },
					attrs.title,
				),
				(attrs.layout_mode == 'creative' && attrs.filter) && el(
					'div',
					{ className: 'toolbox toolbox-filter' },
					el(
						'div',
						{ className: 'toolbox-left' },
						el(
							'a',
							{ href: '#', className: 'filter-toggler' },
							__('Filter'),
						),
					),
					el(
						'div',
						{ className: 'toolbox-right' },
						el(
							'ul',
							{ className: 'nav-filter product-filter' },
							el(
								'li',
								{ className: 'nav-item active' },
								el(
									'a',
									{ href: '#', className: 'cat', 'data-filter': '*' },
									__('All'),
								),
							),
							_this.state.categoriesList.map(function (cat) {
								return el(
									'li',
									{ className: 'nav-item' },
									el(
										'a',
										{ href: '#', className: 'cat', 'data-filter': '.' + cat.slug },
										cat.name,
									),
								);
							}),
						),
					),
				),
				el(
					'div',
					{ className: wrapper_class, style: { marginLeft: (attrs.layout_mode != 'slider' && attrs.product_style != 'list') ? -attrs.spacing / 2 : 0, marginRight: (attrs.layout_mode != 'slider' && attrs.product_style != 'list') ? -attrs.spacing / 2 : 0 } },
					this.state.products.map(function (product) {

						var categories = '';
						var cat_slugs = '';
						for (var i = 0; i < product.categories.length; i++) {
							if (i) {
								categories += ', ' + product.categories[i].name;
								cat_slugs += ' ' + product.categories[i].slug;
							} else {
								categories += product.categories[i].name;
								cat_slugs += product.categories[i].slug;
							}
						}
						return el(
							'div',
							{ className: 'product-col' + (attrs.layout_mode == 'creative' ? ' ' + cat_slugs : ''), style: { paddingLeft: (attrs.layout_mode != 'slider' && attrs.product_style != 'list') ? attrs.spacing / 2 : 0, paddingRight: (attrs.layout_mode != 'slider' && attrs.product_style != 'list') ? attrs.spacing / 2 : 0 } },
							el(
								'div',
								{ className: 'product product-' + attrs.product_style + ((attrs.product_style == 'no-overlay' || attrs.product_style == 'slide') ? ' product-popup' : '') + ' ' + attrs.product_align + '-mode' },
								attrs.product_style == 'list' && el(
									'div',
									{ className: 'media-col' },
									_this.sectionFigure(product),
								),
								attrs.product_style != 'list' && _this.sectionFigure(product),
								attrs.product_style == 'list' && el(
									'div',
									{ className: 'body-col' },
									_this.sectionBody(product, categories),
								),
								attrs.product_style != 'list' && _this.sectionBody(product, categories),
								(attrs.product_style == 'popup' || attrs.product_style == 'no-overlay' || attrs.product_style == 'slide') && _this.sectionFooter(product),
								attrs.product_style == 'list' && el(
									'div',
									{ className: 'action-col' },
									_this.sectionListedAction(product),
								),
							),
						);
					})
				),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	}
	registerBlockType('molla/molla-product', {
		title: 'Molla Product',
		icon: 'molla',
		category: 'molla',
		attributes: {
			title: {
				type: 'string',
			},
			title_align: {
				type: 'string',
				default: 'left',
			},
			categories_op: {
				type: 'string',
			},
			category: {
				type: 'string',
			},
			categories: {
				type: 'array',
				default: [],
			},
			count: {
				type: 'int',
				default: 4,
			},
			orderby: {
				type: 'string',
				default: 'date',
			},
			order: {
				type: 'string',
				default: 'desc',
			},
			layout_mode: {
				type: 'string',
				default: 'grid',
			},
			spacing: {
				type: 'int',
				default: 20,
			},
			columns: {
				type: 'int',
				default: 4,
			},
			filter: {
				type: 'boolean',
				default: false,
			},
			product_slider_nav_pos: {
				type: 'string',
				default: '',
			},
			product_slider_nav_type: {
				type: 'string',
				default: '',
			},
			slider_nav: {
				type: 'boolean',
				default: false,
			},
			slider_dot: {
				type: 'boolean',
				default: true,
			},
			view_more: {
				type: 'boolean',
				default: false,
			},
			view_more_label: {
				type: 'string',
			},
			view_more_icon: {
				type: 'string',
			},
			view_more_count: {
				type: 'int',
				default: 6,
			},
			product_style: {
				type: 'string',
				default: 'default',
			},
			product_border: {
				type: 'boolean',
			},
			product_align: {
				type: 'string',
				default: 'center',
			},
			icon_hidden: {
				type: 'boolean',
			},
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Products,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash, wp.apiFetch);

/**
 * 4. Molla Product Category
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash, apiFetch) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		MediaUpload = wpEditor.MediaUpload,
		el = wpElement.createElement,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		TextControl = wpComponents.TextControl,
		SelectControl = wpComponents.SelectControl,
		CheckboxControl = wpComponents.CheckboxControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl,
		IconButton = wpComponents.IconButton;

	class Molla_Product_Cats extends Component {

		constructor() {
			super(...arguments);

			this.state = {
				categoriesList: [],
				categories: [],
				categories_loaded: false,
			};

			this.cat_grid_type = [
				[
					{
						'w': '1-2',
						'h': '1-2',
						'w-l': '3-4',
						'w-m': '1',
					},
					{
						'w': '1-4',
						'h': '1-4',
						'w-l': '1-4',
						'w-m': '1-2',
					},
					{
						'w': '1-4',
						'h': '1-4',
						'w-l': '1-4',
						'w-m': '1-2',
					},
					{
						'w': '1-2',
						'h': '1-2',
						'w-l': '1-2',
						'w-m': '1',
					},
					{
						'w': '1-2',
						'h': '1-4',
						'w-l': '1-4',
						'w-m': '1-2',
					},
					{
						'w': '1-4',
						'h': '1-4',
						'w-l': '1-2',
					},
					{
						'w': '1-2',
						'h': '1-4',
						'w-l': '1-2',
					},
					{
						'w': '1-4',
						'h': '1-4',
						'w-l': '1-2',
					},
				],
				[
					{
						'w': '2-3',
						'h': '1-3',
						'w-l': '1',
					},
					{
						'w': '1-3',
						'h': '1-3',
						'w-l': '1-2',
					},
					{
						'w': '1-3',
						'h': '2-3',
						'w-l': '1-2',
					},
					{
						'w': '2-3',
						'h': '2-3',
						'w-l': '1',
					},
				],
				[
					{
						'w': '2-3',
						'h': '2-3',
						'w-l': '1',
					},
					{
						'w': '1-3',
						'h': '1-3',
						'w-l': '1-2',
					},
					{
						'w': '2-3',
						'h': '1-3',
						'w-l': '1-2',
					},
					{
						'w': '1-3',
						'h': '2-3',
						'w-l': '1',
					},
				],
				[
					{
						'w': '1-2',
						'h': '1',
						'w-m': '1',
					},
					{
						'w': '1-2',
						'h': '1-2',
						'w-m': '1',
					},
					{
						'w': '1-2',
						'h': '1-2',
						'w-m': '1',
					},
				],
				[
					{
						'w': '1-3',
						'h': '1',
						'w-l': '1-2',
						'w-s': '1',
					},
					{
						'w': '1-3',
						'h': '1-2',
						'w-l': '1-2',
						'w-s': '1',
					},
					{
						'w': '1-3',
						'h': '1',
						'w-l': '1-2',
						'w-s': '1',
					},
					{
						'w': '1-3',
						'h': '1-2',
						'w-l': '1-2',
						'w-s': '1',
					},
				],
				[
					{
						'w': '1-2',
						'h': '1',
						'w-l': '1',
					},
					{
						'w': '1-4',
						'h': '1-2',
						'w-l': '1-2',
					},
					{
						'w': '1-4',
						'h': '1-2',
						'w-l': '1-2',
					},
					{
						'w': '1-2',
						'h': '1-2',
						'w-l': '1',
					},
				],
			];
		}

		componentDidMount() {
			var _this = this,
				attrs = this.props.attributes,
				categoriesList = this.state.categoriesList;

			if (!this.state.categories_loaded && _this.state.categoriesList.length === 0) {
				wp.apiFetch({ path: '/wc/v2/products/categories' }).then(function (obj) {
					_this.setState({ categoriesList: obj, categories_loaded: true, categories: obj });
				});
			}
		}

		componentDidUpdate(prevProps, prevState) {
			var _this = this,
				attrs = this.props.attributes,
				prevAttrs = prevProps.attributes;

			if (attrs.layout_mode == 'slider') {
				if (prevAttrs.layout_mode == 'creative') {
					this.destroyIsotope('.product-categories');
				}

				if (_this.state.categories != prevState.categories ||
					attrs.layout_mode != prevAttrs.layout_mode ||
					attrs.spacing != prevAttrs.spacing ||
					attrs.columns != prevAttrs.columns ||
					attrs.cat_slider_nav_pos != prevAttrs.cat_slider_nav_pos ||
					attrs.cat_slider_nav_type != prevAttrs.cat_slider_nav_type ||
					attrs.slider_nav != prevAttrs.slider_nav ||
					attrs.slider_dot != prevAttrs.slider_dot) {

					this.initSlider();
				}

			} else if (attrs.layout_mode == 'grid') {

				if (prevAttrs.layout_mode == 'slider') {
					this.destroySlider();
				} else if (prevAttrs.layout_mode == 'creative') {
					this.destroyIsotope('.product-categories');
				}

			} else if (attrs.layout_mode == 'creative') {
				if (prevAttrs.layout_mode == 'slider') {
					this.destroySlider();
				}

				if (_this.state.categories != prevState.categories ||
					attrs.layout_mode != prevAttrs.layout_mode ||
					attrs.grid_layout_mode != prevAttrs.grid_layout_mode ||
					attrs.grid_layout_height != prevAttrs.grid_layout_height ||
					attrs.spacing != prevAttrs.spacing ||
					attrs.columns != prevAttrs.columns) {
					this.initIsotope('.product-categories', '.grid-item');
				}
			}
			if (this.getQuery() !== this.state.query) {
				if (attrs.layout_mode == 'slider') {
					this.destroySlider();
				}
				this.fetchCategories();
			}
		}

		getQuery() {
			var attrs = this.props.attributes,
				columns = attrs.columns,
				status = attrs.status;

			var query = {
				per_page: attrs.count
			};

			query.orderby = attrs.orderby;
			query.order = attrs.order;
			query.hide_empty = attrs.hide_empty;

			if (attrs.category_count == 1 && attrs.show_sub_cat) {
				query.parent = attrs.categories[0];
			}

			if ((attrs.category_count != 1 || !attrs.show_sub_cat) && attrs.categories_op === 'selected') {
				query.include = attrs.categories.join(',')
			}

			var query_string = '?';
			var _iteratorNormalCompletion = true;
			var _didIteratorError = false;
			var _iteratorError = undefined;

			for (var _iterator = Object.keys(query)[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
				var key = _step.value;

				query_string += key + '=' + query[key] + '&';
			}

			var endpoint = '/wc/v2/products/categories' + query_string;
			return endpoint;
		}

		initSlider() {
			var attrs = this.props.attributes;
			this.destroySlider();

			jQuery('.product-categories').owlCarousel({
				items: attrs.columns,
				nav: attrs.slider_nav,
				dots: attrs.slider_dot,
				margin: attrs.spacing,
			}).removeClass('c-lg-' + attrs.columns);
		}

		destroySlider() {
			var attrs = this.props.attributes;
			var $cats = jQuery('.product-categories');
			$cats.trigger('destroy.owl.carousel').addClass(' c-lg-' + attrs.columns);;
		}

		initIsotope($container, $selector) {
			var _this = this;
			if (jQuery($container).data('isotope')) {
				_this.destroyIsotope($container);
			}
			if (jQuery($container).find('.grid-space').length) {
				jQuery($container).isotope({
					itemSelector: $selector,
					percentPosition: true,
					masonry: {
						columnWidth: '.grid-space'
					}
				});

			} else {
				jQuery($container).isotope({
					itemSelector: $selector,
					percentPosition: true,
				});
			}
		}

		destroyIsotope($container) {
			if (jQuery($container).data('isotope')) {
				jQuery($container).isotope('destroy');
			}
		}

		setCategories(catID, isAdd) {
			var props = this.props,
				attrs = props.attributes,
				setAttributes = props.setAttributes;
			var categories = attrs.categories;

			if (isAdd) {
				categories = [].concat(categories, [catID]);
			} else {
				categories = categories.filter(function (cat) {
					return cat !== catID;
				});
			}
			setAttributes({ category_count: categories.length, categories: categories });
		}

		fetchCategories() {
			var _this = this;
			var query = this.getQuery();

			_this.setState({
				query: query
			});

			apiFetch({ path: query }).then(function (categories) {
				_this.setState({
					categories: categories,
				});
			});
		}

		// View Sections
		sectionFigure(cat) {
			return el(
				'figure',
				{ className: 'cat_thumb' },
				el(
					'a',
					{ href: '#' },
					el(
						'img',
						{ src: cat.image ? cat.image.src : '' },
					),
				),
			);
		}

		sectionStyle(height) {
			var attrs = this.props.attributes;

			var grid_type = this.cat_grid_type[attrs.grid_layout_mode - 1];
			var height_ary = [];
			var style = '';

			for (var i = 0; i < grid_type.length; i++) {

				if (height_ary.indexOf(grid_type[i]['h']) == -1) {

					height_ary = grid_type[i]['h'];

					var height_each = grid_type[i]['h'].split('-');
					var ratio = 1;

					if (2 == height_each.length) {
						ratio = height * height_each[0] / height_each[1];
					}
					else {
						ratio = height * height_each[0];
					}

					style += '.h-' + grid_type[i]['h'] + '{ height:' + Number(ratio) + 'px; }';
				}
			}
			return style;
		}

		sectionContent(cat, position_active) {

			var attrs = this.props.attributes,
				content_class = '',
				add_class = '';

			content_class += ' x-' + attrs.x_pos;
			content_class += ' y-' + attrs.y_pos;
			content_class += ' t-x-' + attrs.t_x_pos;
			content_class += ' t-y-' + attrs.t_y_pos;

			add_class = (attrs.category_style == 'action-popup' ? ' cat-content-static' : '');
			add_class += (attrs.category_style == 'expand' ? ' cat-content-overlay' : '');

			return el(
				'div',
				{ className: 'cat-content ' + (position_active ? content_class : '') + add_class },
				el(
					'a',
					{ href: '#' },
					el(
						'h2',
						{ className: 'cat-title' },
						cat.name,
						!attrs.hide_count && el(
							'mark',
							{ className: 'count' },
							(cat.count ? cat.count : __('No')) + (cat.count == 1 ? __(' Product') : __(' Products')),
						),
					),
				),
				el(
					'a',
					{ className: 'cat-link banner-link' + (attrs.cat_btn_type ? (' ' + attrs.cat_btn_type) : '') },
					__('Shop Now'),
					attrs.cat_btn_icon && el(
						'i',
						{ className: attrs.cat_btn_icon },
					),
				),
			);
		}

		render() {
			var _this = this,
				props = this.props,
				attrs = props.attributes,
				categoriesList = this.state.categoriesList;

			var position_active = (attrs.category_style != 'float' && attrs.category_style != 'block' && attrs.category_style != 'action-popup' && attrs.category_style != 'expand');

			var inspectorControls = el(InspectorControls, {},
				el(PanelBody, {
					title: __('Categories Selector'),
					initialOpen: true,
				},
					el(TextControl, {
						label: __('Title'),
						value: attrs.title,
						onChange: (value) => { props.setAttributes({ title: value }); },
					}),
					el(SelectControl, {
						label: __('Title Align'),
						value: attrs.title_align,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ title_align: value }); },
					}),
					el(SelectControl, {
						label: __('Category'),
						value: attrs.categories_op,
						options: [{ label: __('All'), value: '' }, { label: __('Select Mode'), value: 'selected' }],
						onChange: (value) => { props.setAttributes({ categories_op: value }); },
					}),
					attrs.categories_op === 'selected' && el(
						'div',
						{ className: 'molla-check-list' },
						categoriesList.map(function (cat, index) {
							return el(CheckboxControl, {
								key: index,
								label: [cat.name, el(
									'span',
									{ key: 'cat-count', style: { fontSize: 'small', color: '#888', marginLeft: 5 } },
									'(',
									cat.count,
									')'
								)],
								checked: jQuery.inArray(cat.id, attrs.categories) > -1,
								onChange: function onChange(checked) {
									return _this.setCategories(cat.id, checked);
								}
							});
						})
					),
					attrs.category_count == 1 && el(ToggleControl, {
						label: __('Show sub categories?'),
						checked: attrs.show_sub_cat,
						onChange: (value) => { props.setAttributes({ show_sub_cat: value }); },
					}),
					el(RangeControl, {
						label: __('Categories Count'),
						value: attrs.count,
						min: 1,
						max: 100,
						onChange: (value) => { props.setAttributes({ count: value }); },
					}),
					el(SelectControl, {
						label: __('Order By'),
						value: attrs.orderby,
						options: [{ label: __('Name'), value: 'slug' }, { label: __('ID'), value: 'id' }, { label: __('Product Count'), value: 'count' }, { label: __('Description'), value: 'description' }, { label: __('Term Group'), value: 'term_group' }],
						onChange: (value) => { props.setAttributes({ orderby: value }); },
					}),
					el(SelectControl, {
						label: __('Order'),
						value: attrs.order,
						options: [{ label: __('Descending'), value: 'desc' }, { label: __('Ascending'), value: 'asc' }],
						onChange: (value) => { props.setAttributes({ order: value }); },
					}),
					el(ToggleControl, {
						label: __('Show empty categories?'),
						checked: attrs.hide_empty,
						onChange: (value) => { props.setAttributes({ hide_empty: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Categories Layout'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Layout Mode'),
						value: attrs.layout_mode,
						options: [{ label: __('Grid'), value: 'grid' }, { label: __('Grid Creative'), value: 'creative' }, { label: __('Slider'), value: 'slider' }],
						onChange: (value) => { props.setAttributes({ layout_mode: value }); },
					}),
					attrs.layout_mode == 'creative' && el(SelectControl, {
						label: __('Grid Layout Type'),
						value: attrs.grid_layout_mode,
						options: [{ label: '', value: '' }, { label: __('1'), value: '1' }, { label: __('2'), value: '2' }, { label: __('3'), value: '3' }, { label: __('4'), value: '4' }, { label: __('5'), value: '5' }, { label: __('6'), value: '6' }],
						onChange: (value) => { props.setAttributes({ grid_layout_mode: value }); },
					}),
					attrs.layout_mode == 'creative' && el(RangeControl, {
						label: __('Grid Height (px)'),
						value: attrs.grid_layout_height,
						min: 0,
						max: 2000,
						onChange: (value) => { props.setAttributes({ grid_layout_height: value }); },
					}),
					el(RangeControl, {
						label: __('Spacing(px)'),
						value: attrs.spacing,
						min: 0,
						max: 40,
						onChange: (value) => { props.setAttributes({ spacing: value }); },
					}),
					el(SelectControl, {
						label: __('Columns'),
						value: attrs.columns,
						options: [{ label: __('1'), value: '1' }, { label: __('2'), value: '2' }, { label: __('3'), value: '3' }, { label: __('4'), value: '4' }, { label: __('5'), value: '5' }, { label: __('6'), value: '6' }, { label: __('7'), value: '7' }, { label: __('8'), value: '8' }],
						onChange: (value) => { props.setAttributes({ columns: value }); },
					}),
					'slider' == attrs.layout_mode && el(SelectControl, {
						label: __('Nav & Dot Position'),
						value: attrs.cat_slider_nav_pos,
						options: [{ label: __('Inner'), value: 'owl-nav-inside' }, { label: __('Outer'), value: '' }, { label: __('Top'), value: 'owl-nav-top' }],
						onChange: (value) => { props.setAttributes({ cat_slider_nav_pos: value }); },
					}),
					'slider' == attrs.layout_mode && el(SelectControl, {
						label: __('Nav Type'),
						value: attrs.cat_slider_nav_type,
						options: [{ label: __('Type 1'), value: '' }, { label: __('Type 2'), value: 'owl-full' }, { label: __('Type 3'), value: 'owl-nav-rounded' }],
						onChange: (value) => { props.setAttributes({ cat_slider_nav_type: value }); },
					}),
					'slider' == attrs.layout_mode && el(ToggleControl, {
						label: __('Show navigation?'),
						checked: attrs.slider_nav,
						onChange: (value) => { props.setAttributes({ slider_nav: value }); },
					}),
					'slider' == attrs.layout_mode && el(ToggleControl, {
						label: __('Show slider dots?'),
						checked: attrs.slider_dot,
						onChange: (value) => { props.setAttributes({ slider_dot: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Categories Style'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Category Type'),
						value: attrs.category_style,
						options: [{ label: __('Default'), value: 'default' }, { label: __('Float'), value: 'float' }, { label: __('Block'), value: 'block' }, { label: __('Action-popup'), value: 'action-popup' }, { label: __('Action-slide'), value: 'action-slide' }, { label: __('Back-clip'), value: 'back-clip' }, { label: __('Fade-up'), value: 'fade-up' }, { label: __('Fade-down'), value: 'fade-down' }, { label: __('Expand'), value: 'expand' }, { label: __('Content-inner-link'), value: 'inner-link' }],
						onChange: (value) => { props.setAttributes({ category_style: value }); },
					}),
					el(SelectControl, {
						label: __('Align Content'),
						value: attrs.content_align,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ content_align: value }); },
					}),
					el(ToggleControl, {
						label: __('Enable Overlay'),
						checked: attrs.overlay_type,
						onChange: (value) => { props.setAttributes({ overlay_type: value }); },
					}),
					position_active && el(RangeControl, {
						label: __('Content Position X(%)'),
						value: attrs.x_pos,
						min: 0,
						max: 100,
						onChange: (value) => { props.setAttributes({ x_pos: value }); },
					}),
					position_active && el(RangeControl, {
						label: __('Content Position Y(%)'),
						value: attrs.y_pos,
						min: 0,
						max: 100,
						onChange: (value) => { props.setAttributes({ y_pos: value }); },
					}),
					position_active && el(SelectControl, {
						label: __('Origin X Pos'),
						value: attrs.t_x_pos,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ t_x_pos: value }); },
					}),
					position_active && el(SelectControl, {
						label: __('Origin Y Pos'),
						value: attrs.t_y_pos,
						options: [{ label: __('Top'), value: 'top' }, { label: __('Center'), value: 'center' }, { label: __('Bottom'), value: 'bottom' }],
						onChange: (value) => { props.setAttributes({ t_y_pos: value }); },
					}),
					el(ToggleControl, {
						label: __('Hide product counts'),
						checked: attrs.hide_count,
						onChange: (value) => { props.setAttributes({ hide_count: value }); },
					}),
					el(SelectControl, {
						label: __('Button Type'),
						value: attrs.cat_btn_type,
						options: [{ label: __('Link'), value: '' }, { label: __('Button'), value: 'btn' }],
						onChange: (value) => { props.setAttributes({ cat_btn_type: value }); },
					}),
					el(TextControl, {
						label: __('Button Icon'),
						value: attrs.cat_btn_icon,
						onChange: (value) => { props.setAttributes({ cat_btn_icon: value }); },
					}),
				),
			);

			var cat_class = '',
				wrapper_class = 'product-categories columns-' + attrs.columns;

			if (attrs.layout_mode == 'slider') {
				wrapper_class += ' owl-carousel owl-simple' + (attrs.cat_slider_nav_pos ? ' ' + attrs.cat_slider_nav_pos : '') + (attrs.cat_slider_nav_type ? ' ' + attrs.cat_slider_nav_type : '');
			}

			cat_class = attrs.category_style + (attrs.overlay_type ? ' overlay-hover' : '');
			cat_class += ' text-' + attrs.content_align;

			if (attrs.category_style == 'action-slide') {
				cat_class += ' cat-link-anim';
			}

			var catIdx = 0;
			var grid_height = attrs.grid_layout_height ? attrs.grid_layout_height : 600;

			var renderControls = el(
				'div',
				{ className: 'categories-wrapper' },
				attrs.title && el(
					'h2',
					{ className: 'title text-' + attrs.title_align },
					attrs.title,
				),
				attrs.layout_mode == 'creative' && attrs.grid_layout_mode && el(
					'style',
					{ 'type': 'text/css' },
					_this.sectionStyle(grid_height),
				),
				el(
					'div',
					{ className: wrapper_class, style: { marginLeft: attrs.layout_mode != 'slider' ? -attrs.spacing / 2 : 0, marginRight: attrs.layout_mode != 'slider' ? -attrs.spacing / 2 : 0 } },
					_this.state.categories.map(function (cat) {

						var cat_classes = '';

						if (attrs.layout_mode == 'creative' && attrs.grid_layout_mode) {

							catIdx++;
							cat_classes = '';
							var type = _this.cat_grid_type[attrs.grid_layout_mode - 1][catIdx - 1];

							if (type) {
								cat_classes = 'grid-item ';
								var keys = Object.keys(type);
								keys.map(function (key) {
									cat_classes += key + '-' + type[key] + ' ';
								});
							} else {
								cat_classes = 'd-none';
							}

						} else {
							cat_classes = 'product-col';
							if (attrs.layout_mode == 'creative') {
								cat_classes += ' grid-item';
							}
						}

						return el(
							'div',
							{ className: cat_classes, style: { paddingLeft: attrs.layout_mode != 'slider' ? attrs.spacing / 2 : 0, paddingRight: attrs.layout_mode != 'slider' ? attrs.spacing / 2 : 0 } },
							el(
								'div',
								{ className: 'product-category cat-' + cat_class },
								_this.sectionFigure(cat),
								_this.sectionContent(cat, position_active),
							),
						);
					}),
					attrs.layout_mode == 'creative' && attrs.grid_layout_mode && el(
						'div',
						{ className: 'grid-space' },
					),
				),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	}

	registerBlockType('molla/molla-product-cat', {
		title: 'Molla Product Category',
		icon: 'molla',
		category: 'molla',
		attributes: {
			title: {
				type: 'string',
			},
			title_align: {
				type: 'string',
				default: 'left',
			},
			categories_op: {
				type: 'string',
			},
			category_count: {
				type: 'int',
			},
			categories: {
				type: 'array',
				default: [],
			},
			show_sub_cat: {
				type: 'boolean',
			},
			count: {
				type: 'int',
				default: 4,
			},
			orderby: {
				type: 'string',
				default: 'slug',
			},
			order: {
				type: 'string',
				default: 'asc',
			},
			hide_empty: {
				type: 'boolean',
				default: true,
			},
			layout_mode: {
				type: 'string',
				default: 'grid',
			},
			grid_layout_mode: {
				type: 'string',
				default: '1',
			},
			grid_layout_height: {
				type: 'int',
			},
			spacing: {
				type: 'int',
				default: 20,
			},
			columns: {
				type: 'int',
				default: 4,
			},
			cat_slider_nav_pos: {
				type: 'string',
				default: '',
			},
			cat_slider_nav_type: {
				type: 'string',
				default: '',
			},
			slider_nav: {
				type: 'boolean',
				default: false,
			},
			slider_dot: {
				type: 'boolean',
				default: true,
			},
			category_style: {
				type: 'string',
				default: 'default',
			},
			content_align: {
				type: 'string',
				default: 'left',
			},
			overlay_type: {
				type: 'boolean',
				default: true,
			},
			t_x_pos: {
				type: 'string',
				default: 'center',
			},
			t_y_pos: {
				type: 'string',
				default: 'center',
			},
			x_pos: {
				type: 'int',
				default: 50,
			},
			y_pos: {
				type: 'int',
				default: 50,
			},
			hide_count: {
				type: 'boolean',
				default: false,
			},
			cat_btn_type: {
				type: 'string',
				default: '',
			},
			cat_btn_icon: {
				type: 'string',
			},
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Product_Cats,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});

})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash, wp.apiFetch);

/**
 * 5. Molla Blog
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash, apiFetch) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		MediaUpload = wpEditor.MediaUpload,
		el = wpElement.createElement,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		TextControl = wpComponents.TextControl,
		SelectControl = wpComponents.SelectControl,
		CheckboxControl = wpComponents.CheckboxControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl,
		IconButton = wpComponents.IconButton;

	class Molla_Blogs extends Component {
		constructor() {
			super(...arguments);

			this.state = {
				categoriesList: [],
				posts: [],
				categories_loaded: false,
				show_options: ['date', 'author', 'category', 'content'],
			};
		}

		componentDidMount() {
			var _this = this,
				attrs = this.props.attributes;
			if (!this.state.categories_loaded && _this.state.categoriesList.length === 0) {
				wp.apiFetch({ path: '/wp/v2/categories' }).then(function (obj) {
					_this.setState({ categoriesList: obj, categories_loaded: true, categories: obj });
				});
			}
			attrs.post_show_op = this.state.show_options;
		}

		componentDidUpdate(prevProps, prevState) {

			var _this = this,
				attrs = this.props.attributes,
				prevAttrs = prevProps.attributes;

			if (attrs.layout_mode == 'slider') {

				if (prevAttrs.layout_mode == 'creative') {
					this.destroyIsotope('.articles');
				}

				if (_this.state.posts != prevState.posts ||
					attrs.layout_mode != prevAttrs.layout_mode ||
					attrs.spacing != prevAttrs.spacing ||
					attrs.columns != prevAttrs.columns ||
					attrs.blog_slider_nav_pos != prevAttrs.blog_slider_nav_pos ||
					attrs.blog_slider_nav_type != prevAttrs.blog_slider_nav_type ||
					attrs.slider_nav != prevAttrs.slider_nav ||
					attrs.slider_dot != prevAttrs.slider_dot) {

					this.initSlider();

				}

			} else if (attrs.layout_mode == 'grid') {

				if (prevAttrs.layout_mode == 'slider') {
					this.destroySlider();
				} else if (prevAttrs.layout_mode == 'creative') {
					this.destroyIsotope('.articles');
				}

			} else if (attrs.layout_mode == 'creative') {

				if (prevAttrs.layout_mode == 'slider') {
					this.destroySlider();
					this.initIsotope('.articles', '.product-col');
				}

				if (_this.state.posts != prevState.posts ||
					attrs.layout_mode != prevAttrs.layout_mode ||
					attrs.spacing != prevAttrs.spacing ||
					attrs.columns != prevAttrs.columns) {

					this.initIsotope('.articles', '.product-col');

				}
			}

			if (this.getQuery() !== this.state.query) {
				if (attrs.layout_mode == 'slider') {
					this.destroySlider();
				}
				this.fetchBlogs();
			}
		}

		initSlider() {
			var attrs = this.props.attributes;
			this.destroySlider();
			jQuery('.articles').owlCarousel({
				items: attrs.columns,
				nav: attrs.slider_nav,
				dots: attrs.slider_dot,
				margin: attrs.spacing,
			}).removeClass('c-lg-' + attrs.columns);
		}

		destroySlider() {
			var attrs = this.props.attributes;
			var $posts = jQuery('.articles');
			$posts.trigger('destroy.owl.carousel').addClass(' c-lg-' + attrs.columns);
		}

		initIsotope($container, $selector) {
			var _this = this;

			_this.destroyIsotope($container);

			jQuery($container).imagesLoaded(function () {
				jQuery($container).isotope({
					itemSelector: $selector,
					percentPosition: true,
					masonry: {
						horizontalOrder: true
					}
				});
			});
		}

		destroyIsotope($container) {

			if (jQuery($container).data('isotope')) {
				jQuery($container).isotope('destroy');
			}
		}

		getQuery() {
			var attrs = this.props.attributes,
				columns = attrs.columns,
				status = attrs.status;

			var query = {
				per_page: attrs.count
			};

			query.orderby = attrs.orderby;
			query.order = attrs.order;

			if (attrs.categories_op === 'selected') {
				query.categories = attrs.categories.join(',')
			}

			var query_string = '?';
			var _iteratorNormalCompletion = true;
			var _didIteratorError = false;
			var _iteratorError = undefined;

			for (var _iterator = Object.keys(query)[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
				var key = _step.value;

				query_string += key + '=' + query[key] + '&';
			}

			var endpoint = '/wp/v2/posts' + query_string;
			return endpoint;
		}

		setCategories(catID, isAdd) {
			var props = this.props,
				attrs = props.attributes,
				setAttributes = props.setAttributes;
			var categories = attrs.categories;

			if (isAdd) {
				categories = [].concat(categories, [catID]);
			} else {
				categories = categories.filter(function (cat) {
					return cat !== catID;
				});
			}
			setAttributes({ category: categories.join(','), categories: categories });
		}

		setEnableElems(index, isAdd) {
			var _this = this,
				props = this.props,
				attrs = props.attributes,
				setAttributes = props.setAttributes;
			var post_show_op = attrs.post_show_op;

			if (isAdd) {
				post_show_op = [].concat(post_show_op, this.state.show_options[[index]]);
			} else {
				post_show_op = post_show_op.filter(function (elem) {
					return elem !== _this.state.show_options[index];
				});
			}
			setAttributes({ post_show_op: post_show_op });
		}

		fetchBlogs() {
			var _this = this;
			var query = this.getQuery();

			_this.setState({
				query: query
			});

			apiFetch({ path: query }).then(function (posts) {
				_this.setState({
					posts: posts,
				});
			});
		}

		// View Sections
		sectionFigure(post) {
			return el(
				'figure',
				{ className: 'entry-media' },
				el(
					'a',
					{ href: '#' },
					el(
						'img',
						{ src: post.featured_image_src.full[0] },
					),
				),
			);
		}

		sectionBody(post) {
			var attrs = this.props.attributes;
			return el(
				'div',
				{ className: 'entry-body text-' + attrs.post_align },
				el(
					'div',
					{ className: 'entry-meta' },
					jQuery.inArray('author', attrs.post_show_op) > -1 && el(
						'span',
						{ className: 'entry-author' },
						__('by '),
						el(
							'a',
							{},
							post.author_name,
						),
						jQuery.inArray('date', attrs.post_show_op) > -1 && el(
							'span',
							{ className: 'meta-separator' },
							'|',
						),
					),
					jQuery.inArray('date', attrs.post_show_op) > -1 && el(
						'span',
						{ className: 'entry-date' },
						el(
							'a',
							{},
							moment(post.date_gmt).local().format('MMMM DD, Y'),
						),
						el(
							'span',
							{ className: 'meta-separator' },
							'|',
						),
					),
					jQuery.inArray('date', attrs.post_show_op) > -1 && el(
						'span',
						{ className: 'entry-comment' },
						el(
							'a',
							{},
							post.comment_count.total_comments,
							' ' + (post.comment_count.total_comments == 1 ? __('Comment') : __('Comments')),
						),
					),
				),
				el(
					'h2',
					{ className: 'entry-title' },
					post.title.rendered,
				),
				jQuery.inArray('category', attrs.post_show_op) > -1 && el(
					'div',
					{ className: 'entry-cats' },
					__('in '),
					post.categories_name.map(function (cat, idx) {
						var sap = (idx == 0 ? '' : ', ');
						return el(
							'span',
							{},
							sap,
							el(
								'a',
								{ href: '#' },
								cat,
							),
						);
					}),
				),
				el(
					'div',
					{ className: 'entry-content' },
					jQuery.inArray('content', attrs.post_show_op) > -1 && el(
						'p',
						{ dangerouslySetInnerHTML: { __html: post.excerpt.rendered } },
					),
					el(
						'a',
						{ className: 'read-more' },
						__('Continue Reading'),
					),
				),
			);
		}

		render() {
			var _this = this,
				props = this.props,
				attrs = props.attributes,
				categoriesList = this.state.categoriesList;

			var inspectorControls = el(InspectorControls, {},
				el(PanelBody, {
					title: __('Blogs Selector'),
					initialOpen: true,
				},
					el(TextControl, {
						label: __('Title'),
						value: attrs.title,
						onChange: (value) => { props.setAttributes({ title: value }); },
					}),
					el(SelectControl, {
						label: __('Title Align'),
						value: attrs.title_align,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ title_align: value }); },
					}),
					el(SelectControl, {
						label: __('Category'),
						value: attrs.categories_op,
						options: [{ label: __('All'), value: '' }, { label: __('Select Mode'), value: 'selected' }],
						onChange: (value) => { props.setAttributes({ categories_op: value }); },
					}),
					attrs.categories_op === 'selected' && el(
						'div',
						{ className: 'molla-check-list' },
						categoriesList.map(function (cat, index) {
							return el(CheckboxControl, {
								key: index,
								label: [cat.name, el(
									'span',
									{ key: 'cat-count', style: { fontSize: 'small', color: '#888', marginLeft: 5 } },
									'(',
									cat.count,
									')'
								)],
								checked: jQuery.inArray(cat.id, attrs.categories) > -1,
								onChange: function onChange(checked) {
									return _this.setCategories(cat.id, checked);
								}
							});
						})
					),
					el(RangeControl, {
						label: __('Posts Count Per Page'),
						value: attrs.count,
						min: 1,
						max: 100,
						onChange: (value) => { props.setAttributes({ count: value }); },
					}),
					el(SelectControl, {
						label: __('Order By'),
						value: attrs.orderby,
						options: [{ label: __('Author'), value: 'author' }, { label: __('Date'), value: 'date' }, { label: __('ID'), value: 'id' }, { label: __('Include'), value: 'include' }, { label: __('Modified'), value: 'm…d' }, { label: __('Parent'), value: 'parent' }, { label: __('Relevance'), value: 'relevance' }, { label: __('Slug'), value: 'slug' }, { label: __('Title'), value: 'title' }],
						onChange: (value) => { props.setAttributes({ orderby: value }); },
					}),
					el(SelectControl, {
						label: __('Order'),
						value: attrs.order,
						options: [{ label: __('Descending'), value: 'desc' }, { label: __('Ascending'), value: 'asc' }],
						onChange: (value) => { props.setAttributes({ order: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Blog Layout'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Layout Mode'),
						value: attrs.layout_mode,
						options: [{ label: __('Grid'), value: 'grid' }, { label: __('Grid Creative'), value: 'creative' }, { label: __('Slider'), value: 'slider' }],
						onChange: (value) => { props.setAttributes({ layout_mode: value }); },
					}),
					el(RangeControl, {
						label: __('Spacing(px)'),
						value: attrs.spacing,
						min: 0,
						max: 40,
						onChange: (value) => { props.setAttributes({ spacing: value }); },
					}),
					el(SelectControl, {
						label: __('Columns'),
						value: attrs.columns,
						options: [{ label: __('1'), value: '1' }, { label: __('2'), value: '2' }, { label: __('3'), value: '3' }, { label: __('4'), value: '4' }, { label: __('5'), value: '5' }, { label: __('6'), value: '6' }, { label: __('7'), value: '7' }, { label: __('8'), value: '8' }],
						onChange: (value) => { props.setAttributes({ columns: value }); },
					}),
					el(ToggleControl, {
						label: __('Show pagination?'),
						checked: attrs.blog_pagination,
						onChange: (value) => { props.setAttributes({ blog_pagination: value }); },
					}),
					el(SelectControl, {
						label: __('Pagination position'),
						value: attrs.blog_pagination_pos,
						options: [{ label: __('Left'), value: 'start' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'end' }],
						onChange: (value) => { props.setAttributes({ blog_pagination_pos: value }); },
					}),
					'slider' == attrs.layout_mode && el(SelectControl, {
						label: __('Nav & Dot Position'),
						value: attrs.blog_slider_nav_pos,
						options: [{ label: __('Inner'), value: 'owl-nav-inside' }, { label: __('Outer'), value: '' }, { label: __('Top'), value: 'owl-nav-top' }],
						onChange: (value) => { props.setAttributes({ blog_slider_nav_pos: value }); },
					}),
					'slider' == attrs.layout_mode && el(SelectControl, {
						label: __('Nav Type'),
						value: attrs.blog_slider_nav_type,
						options: [{ label: __('Type 1'), value: '' }, { label: __('Type 2'), value: 'owl-full' }, { label: __('Type 3'), value: 'owl-nav-rounded' }],
						onChange: (value) => { props.setAttributes({ blog_slider_nav_type: value }); },
					}),
					'slider' == attrs.layout_mode && el(ToggleControl, {
						label: __('Show navigation?'),
						checked: attrs.slider_nav,
						onChange: (value) => { props.setAttributes({ slider_nav: value }); },
					}),
					'slider' == attrs.layout_mode && el(ToggleControl, {
						label: __('Show slider dots?'),
						checked: attrs.slider_dot,
						onChange: (value) => { props.setAttributes({ slider_dot: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Blogs Style'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Blog Post Type'),
						value: attrs.blog_type,
						options: [{ label: __('Default'), value: 'default' }, { label: __('List'), value: 'list' }],
						onChange: (value) => { props.setAttributes({ blog_type: value }); },
					}),
					el(SelectControl, {
						label: __('Content Align'),
						value: attrs.post_align,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ post_align: value }); },
					}),
					el(
						'div',
						{ className: 'molla-check-list' },
						_this.state.show_options.map(function (elem, index) {
							return el(CheckboxControl, {
								key: index,
								label: [elem],
								checked: jQuery.inArray(_this.state.show_options[index], attrs.post_show_op) > -1,
								onChange: function onChange(checked) {
									return _this.setEnableElems(index, checked);
								}
							});
						})
					),
					el(SelectControl, {
						label: __('Excerpt Type'),
						value: attrs.excerpt,
						options: [{ label: __('Theme options'), value: 'theme' }, { label: __('Custom'), value: 'custom' }],
						onChange: (value) => { props.setAttributes({ excerpt: value }); },
					}),
					attrs.excerpt == 'custom' && el(SelectControl, {
						label: __('Excerpt By'),
						value: attrs.excerpt_by,
						options: [{ label: __('Words'), value: 'word' }, { label: __('Characters'), value: 'character' }],
						onChange: (value) => { props.setAttributes({ excerpt_by: value }); },
					}),
					attrs.excerpt == 'custom' && el(RangeControl, {
						label: __('Excerpt Length'),
						value: attrs.excerpt_length,
						min: 1,
						max: 500,
						onChange: (value) => { props.setAttributes({ excerpt_length: value }); },
					}),
				),

			);

			var wrapper_class = 'articles columns-' + attrs.columns;

			if (attrs.layout_mode == 'slider') {
				wrapper_class += ' owl-carousel owl-simple' + (attrs.blog_slider_nav_pos ? ' ' + attrs.blog_slider_nav_pos : '') + (attrs.blog_slider_nav_type ? ' ' + attrs.blog_slider_nav_type : '');
			}

			var renderControls = el(
				'div',
				{ className: 'articles-wrapper' },
				attrs.title && el(
					'h2',
					{ className: 'title text-' + attrs.title_align },
					attrs.title,
				),
				el(
					'div',
					{ className: wrapper_class, style: { marginLeft: attrs.layout_mode != 'slider' ? -attrs.spacing / 2 : 0, marginRight: attrs.layout_mode != 'slider' ? -attrs.spacing / 2 : 0 } },
					_this.state.posts.map(function (post) {
						return el(
							'div',
							{ className: 'product-col', style: { paddingLeft: attrs.layout_mode != 'slider' ? attrs.spacing / 2 : 0, paddingRight: attrs.layout_mode != 'slider' ? attrs.spacing / 2 : 0 } },
							el(
								'article',
								{ className: 'post' + (attrs.blog_type == 'list' ? ' post-list' : '') },
								attrs.blog_type == 'list' && el(
									'div',
									{ className: 'col-md-5' },
									_this.sectionFigure(post),
								),
								attrs.blog_type != 'list' && _this.sectionFigure(post),
								attrs.blog_type == 'list' && el(
									'div',
									{ className: 'col-md-7' },
									_this.sectionBody(post),
								),
								attrs.blog_type != 'list' && _this.sectionBody(post),
							),
						);
					})
				),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	}
	registerBlockType('molla/molla-blog', {
		title: 'Molla Blog',
		icon: 'molla',
		category: 'molla',
		attributes: {
			title: {
				type: 'string',
			},
			title_align: {
				type: 'string',
				default: 'left',
			},
			categories_op: {
				type: 'string',
			},
			category: {
				type: 'string',
			},
			categories: {
				type: 'array',
				default: [],
			},
			count: {
				type: 'int',
				default: 10,
			},
			orderby: {
				type: 'string',
				default: 'date',
			},
			order: {
				type: 'string',
				default: 'desc',
			},
			layout_mode: {
				type: 'string',
				default: 'grid',
			},
			spacing: {
				type: 'int',
				default: 20,
			},
			columns: {
				type: 'int',
				default: 4,
			},
			blog_pagination: {
				type: 'boolean',
				default: true,
			},
			blog_pagination_pos: {
				type: 'string',
				default: 'start',
			},
			blog_slider_nav_pos: {
				type: 'string',
				default: '',
			},
			blog_slider_nav_type: {
				type: 'string',
				default: '',
			},
			slider_nav: {
				type: 'boolean',
				default: false,
			},
			slider_dot: {
				type: 'boolean',
				default: true,
			},
			blog_type: {
				type: 'string',
				default: 'default',
			},
			post_align: {
				type: 'string',
				default: 'left',
			},
			post_show_op: {
				type: 'array',
				default: [],
			},
			excerpt: {
				type: 'string',
				default: 'theme',
			},
			excerpt_by: {
				type: 'string',
				default: 'word',
			},
			excerpt_length: {
				type: 'int',
			},
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Blogs,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash, wp.apiFetch);

/**
 * 6. Molla Heading
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		el = wpElement.createElement,
		PanelColorSettings = wpblockEditor.PanelColorSettings,
		RichText = wpblockEditor.RichText,
		Component = wpElement.Component,
		TextControl = wpComponents.TextControl,
		PanelBody = wpComponents.PanelBody,
		SelectControl = wpComponents.SelectControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl;

	class Molla_Heading extends Component {
		constructor() {
			super(...arguments);
		}

		componentDidMount() { }

		componentDidUpdate(prevProps, prevState) { }

		render() {
			var props = this.props,
				attrs = props.attributes,
				clientId = props.clientId;

			var inspectorControls = el(InspectorControls, {},

				el(PanelBody, {
					title: __('Title'),
					initialOpen: true,
				},
					el(SelectControl, {
						label: __('Title Tag'),
						value: attrs.title_tag,
						options: [{ label: __('H1'), value: 'h1' }, { label: __('H2'), value: 'h2' }, { label: __('H3'), value: 'h3' }, { label: __('H4'), value: 'h4' }, { label: __('H5'), value: 'h5' }, { label: __('H6'), value: 'h6' }],
						onChange: (value) => { props.setAttributes({ title_tag: value }); },
					}),
					el(SelectControl, {
						label: __('Alignment'),
						value: attrs.title_align,
						options: [{ label: __('Left'), value: 'left' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'right' }],
						onChange: (value) => { props.setAttributes({ title_align: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Extra'),
					initialOpen: false,
				},
					el(TextControl, {
						label: __('Subtitle'),
						value: attrs.subtitle,
						onChange: (value) => { props.setAttributes({ subtitle: value }); },
					}),
					el(SelectControl, {
						label: __('Subtitle Tag'),
						value: attrs.subtitle_tag,
						options: [{ label: __('H1'), value: 'h1' }, { label: __('H2'), value: 'h2' }, { label: __('H3'), value: 'h3' }, { label: __('H4'), value: 'h4' }, { label: __('H5'), value: 'h5' }, { label: __('H6'), value: 'h6' }, { label: __('span'), value: 'span' }, { label: __('p'), value: 'p' }],
						onChange: (value) => { props.setAttributes({ subtitle_tag: value }); },
					}),
					el(ToggleControl, {
						label: __('Show Subtitle'),
						checked: attrs.show_subtitle,
						onChange: (value) => { props.setAttributes({ show_subtitle: value }); },
					}),
					el(TextControl, {
						label: __('Link'),
						value: attrs.link_html,
						onChange: (value) => { props.setAttributes({ link_html: value }); },
					}),
					el(TextControl, {
						label: __('Link Url'),
						value: attrs.link_url,
						onChange: (value) => { props.setAttributes({ link_url: value }); },
					}),
					el(TextControl, {
						label: __('Link Icon Class'),
						value: attrs.link_icon_class,
						onChange: (value) => { props.setAttributes({ link_icon_class: value }); },
					}),
					el(ToggleControl, {
						label: __('Show Link'),
						checked: attrs.show_link,
						onChange: (value) => { props.setAttributes({ show_link: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Type'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Alignment'),
						value: attrs.heading_align,
						options: [{ label: '', value: '' }, { label: __('Left'), value: 'flex-start' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'flex-end' }, { label: __('Justified'), value: 'space-between' }],
						onChange: (value) => { props.setAttributes({ heading_align: value }); },
					}),
					!attrs.heading_align && el(SelectControl, {
						label: __('Decoration Type'),
						value: attrs.decoration_type,
						options: [{ label: '', value: '' }, { label: __('Type 1'), value: 't-decor-both' }, { label: __('Type 2'), value: 't-decor-left' }, { label: __('Type 3'), value: 't-decor-right' }],
						onChange: (value) => { props.setAttributes({ decoration_type: value }); },
					}),
					!attrs.heading_align && el(TextControl, {
						label: __('Decoration Spacing ( px )'),
						type: 'number',
						value: attrs.decoration_spacing,
						onChange: (value) => { props.setAttributes({ decoration_spacing: value }); },
					}),

				),
				el(PanelBody, {
					title: __('Style'),
					initialOpen: false,
				},
					el(PanelColorSettings, {
						title: __('Title Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.title_color,
							onChange: function onChange(value) {
								return props.setAttributes({ title_color: value });
							}
						}]
					}),
					el(
						'div',
						{ className: 'typography-panel panel-group', 'data-type': 'Title' },

						el(TextControl, {
							label: __('Family'),
							value: attrs.title_font_family,
							onChange: (value) => { props.setAttributes({ title_font_family: value }); },
						}),
						el(TextControl, {
							label: __('Size'),
							value: attrs.title_font_size,
							onChange: (value) => { props.setAttributes({ title_font_size: value }); },
						}),
						el(SelectControl, {
							label: __('Weight'),
							value: attrs.title_font_weight,
							options: [{ label: '100', value: '100' }, { label: __('200'), value: '200' }, { label: __('300'), value: '300' }, { label: __('400'), value: '400' }, { label: __('500'), value: '500' }, { label: __('600'), value: '600' }, { label: __('700'), value: '700' }, { label: __('800'), value: '800' }, { label: __('900'), value: '900' }],
							onChange: (value) => { props.setAttributes({ title_font_weight: value }); },
						}),
						el(SelectControl, {
							label: __('Transform'),
							value: attrs.title_font_transform,
							options: [{ label: __('Uppercase'), value: 'uppercase' }, { label: __('Lowercase'), value: 'lowercase' }, { label: __('Capitalize'), value: 'capitalize' }, { label: __('Normal'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ title_font_transform: value }); },
						}),
						el(SelectControl, {
							label: __('Style'),
							value: attrs.title_font_style,
							options: [{ label: __('Normal'), value: 'normal' }, { label: __('Italic'), value: 'italic' }, { label: __('Oblique'), value: 'oblique' }],
							onChange: (value) => { props.setAttributes({ title_font_style: value }); },
						}),
						el(SelectControl, {
							label: __('Decoration'),
							value: attrs.title_font_decoration,
							options: [{ label: __('Underline'), value: 'underline' }, { label: __('Overline'), value: 'overline' }, { label: __('Line Through'), value: 'line-through' }, { label: __('None'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ title_font_decoration: value }); },
						}),
						el(TextControl, {
							label: __('Line-Height'),
							value: attrs.title_font_height,
							onChange: (value) => { props.setAttributes({ title_font_height: value }); },
						}),
						el(TextControl, {
							label: __('Letter Spacing'),
							value: attrs.title_font_ltr_spacing,
							onChange: (value) => { props.setAttributes({ title_font_ltr_spacing: value }); },
						}),
					),
					el(TextControl, {
						label: __('Title Custom Class'),
						value: attrs.title_custom_class,
						onChange: (value) => { props.setAttributes({ title_custom_class: value }); },
					}),
					el(PanelColorSettings, {
						title: __('Subtitle Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.subtitle_color,
							onChange: function onChange(value) {
								return props.setAttributes({ subtitle_color: value });
							}
						}]
					}),
					el(
						'div',
						{ className: 'typography-panel panel-group', 'data-type': 'Subtitle' },

						el(TextControl, {
							label: __('Family'),
							value: attrs.subtitle_font_family,
							onChange: (value) => { props.setAttributes({ subtitle_font_family: value }); },
						}),
						el(TextControl, {
							label: __('Size'),
							value: attrs.subtitle_font_size,
							onChange: (value) => { props.setAttributes({ subtitle_font_size: value }); },
						}),
						el(SelectControl, {
							label: __('Weight'),
							value: attrs.subtitle_font_weight,
							options: [{ label: '100', value: '100' }, { label: __('200'), value: '200' }, { label: __('300'), value: '300' }, { label: __('400'), value: '400' }, { label: __('500'), value: '500' }, { label: __('600'), value: '600' }, { label: __('700'), value: '700' }, { label: __('800'), value: '800' }, { label: __('900'), value: '900' }],
							onChange: (value) => { props.setAttributes({ subtitle_font_weight: value }); },
						}),
						el(SelectControl, {
							label: __('Transform'),
							value: attrs.subtitle_font_transform,
							options: [{ label: __('Uppercase'), value: 'uppercase' }, { label: __('Lowercase'), value: 'lowercase' }, { label: __('Capitalize'), value: 'capitalize' }, { label: __('Normal'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ subtitle_font_transform: value }); },
						}),
						el(SelectControl, {
							label: __('Style'),
							value: attrs.subtitle_font_style,
							options: [{ label: __('Normal'), value: 'normal' }, { label: __('Italic'), value: 'italic' }, { label: __('Oblique'), value: 'oblique' }],
							onChange: (value) => { props.setAttributes({ subtitle_font_style: value }); },
						}),
						el(SelectControl, {
							label: __('Decoration'),
							value: attrs.subtitle_font_decoration,
							options: [{ label: __('Underline'), value: 'underline' }, { label: __('Overline'), value: 'overline' }, { label: __('Line Through'), value: 'line-through' }, { label: __('None'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ subtitle_font_decoration: value }); },
						}),
						el(TextControl, {
							label: __('Line-Height'),
							value: attrs.subtitle_font_height,
							onChange: (value) => { props.setAttributes({ subtitle_font_height: value }); },
						}),
						el(TextControl, {
							label: __('Letter Spacing'),
							value: attrs.subtitle_font_ltr_spacing,
							onChange: (value) => { props.setAttributes({ subtitle_font_ltr_spacing: value }); },
						}),
					),
					el(TextControl, {
						label: __('Subtitle Custom Class'),
						value: attrs.subtitle_custom_class,
						onChange: (value) => { props.setAttributes({ subtitle_custom_class: value }); },
					}),
				),
			);

			var wrapper_class = 'heading';
			wrapper_class += attrs.decoration_type ? (' ' + attrs.decoration_type) : '';

			var title_style = '',
				subtitle_style = '';

			title_style = {
				fontFamily: attrs.title_font_family,
				fontSize: attrs.title_font_size,
				fontWeight: attrs.title_font_weight,
				textTransform: attrs.title_font_transform,
				fontStyle: attrs.title_font_style,
				textDecoration: attrs.title_font_decoration,
				lineHeight: attrs.title_font_height,
				letterSpacing: attrs.title_font_ltr_spacing,
				color: attrs.title_color
			};

			subtitle_style = 'font-family: ' + attrs.subtitle_font_family +
				'; font-size: ' + attrs.subtitle_font_size +
				'; font-weight: ' + attrs.subtitle_font_weight +
				'; text-transform: ' + attrs.subtitle_font_transform +
				'; font-style: ' + attrs.subtitle_font_style +
				'; text-decoration: ' + attrs.subtitle_font_decoration +
				'; line-height: ' + attrs.subtitle_font_height +
				'; letter-spacing: ' + attrs.subtitle_font_ltr_spacing +
				'; color: ' + attrs.subtitle_color;

			var renderControls = el(
				'div',
				{ className: wrapper_class, Style: 'justify-content: ' + attrs.heading_align },
				el(
					'div',
					{ className: 'heading-content text-' + attrs.title_align },
					el(
						RichText,
						{
							key: 'editable',
							tagName: attrs.title_tag,
							className: 'heading-title' + (attrs.title_custom_class ? (' ' + attrs.title_custom_class) : ''),
							style: title_style,
							onChange: function (value) {
								return props.setAttributes({ title: value });
							},
							value: attrs.title,
						}
					),
					attrs.show_subtitle && attrs.subtitle && el(
						attrs.subtitle_tag,
						{ className: 'heading-subtitle' + (attrs.subtitle_custom_class ? (' ' + attrs.subtitle_custom_class) : ''), Style: subtitle_style },
						attrs.subtitle,
					),
				),
				attrs.show_link && (attrs.link_html || attrs.link_icon_class) && el(
					'div',
					{ className: 'heading-link' },
					el(
						'a',
						{ className: 'title-link', href: attrs.link_url },
						attrs.link_html,
						attrs.link_icon_class && el(
							'i',
							{ className: attrs.link_icon_class },
						),
					),
				),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	}

	registerBlockType('molla/molla-heading', {
		title: 'Molla Heading',
		icon: 'molla',
		category: 'molla',
		attributes: {
			title: {
				type: 'string',
				default: __('Add Your Heading Text Here'),
			},
			title_tag: {
				type: 'string',
				default: 'h2',
			},
			title_align: {
				type: 'string',
				default: 'left',
			},
			subtitle: {
				type: 'string',
			},
			subtitle_tag: {
				type: 'string',
				default: 'h4',
			},
			show_subtitle: {
				type: 'boolean',
				default: true,
			},
			link_html: {
				type: 'string',
			},
			link_url: {
				type: 'string',
			},
			link_icon_class: {
				type: 'string',
			},
			show_link: {
				type: 'boolean',
				type: false,
			},
			heading_align: {
				type: 'string',
				default: '',
			},
			decoration_type: {
				type: 'string',
				default: 't-decor-both',
			},
			decoration_spacing: {
				type: 'int',
			},
			title_font_family: {
				type: 'string',
				default: 'Poppins',
			},
			title_font_size: {
				type: 'string',
				default: '2.4rem',
			},
			title_font_weight: {
				type: 'string',
				default: '600',
			},
			title_font_transform: {
				type: 'string',
				default: 'capitalize',
			},
			title_font_style: {
				type: 'string',
				default: 'normal',
			},
			title_font_decoration: {
				type: 'string',
				default: 'none',
			},
			title_font_height: {
				type: 'string',
				default: '1.4',
			},
			title_font_ltr_spacing: {
				type: 'string',
				default: '0',
			},
			subtitle_font_family: {
				type: 'string',
				default: 'Poppins',
			},
			subtitle_font_size: {
				type: 'string',
				default: '1.8rem',
			},
			subtitle_font_weight: {
				type: 'string',
				default: '400',
			},
			subtitle_font_transform: {
				type: 'string',
				default: 'capitalize',
			},
			subtitle_font_style: {
				type: 'string',
				default: 'normal',
			},
			subtitle_font_decoration: {
				type: 'string',
				default: 'none',
			},
			subtitle_font_height: {
				type: 'string',
				default: '1.4',
			},
			subtitle_font_ltr_spacing: {
				type: 'string',
				default: '0',
			},
			title_color: {
				type: 'string',
				default: '#333',
			},
			subtitle_color: {
				type: 'string',
				default: '#666',
			},
			title_custom_class: {
				type: 'string',
				default: '',
			},
			subtitle_custom_class: {
				type: 'string',
				default: '',
			}
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Heading,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash);

/**
 * 7. Molla Icon-Box
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		el = wpElement.createElement,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		TextControl = wpComponents.TextControl,
		PanelColorSettings = wpblockEditor.PanelColorSettings,
		TextareaControl = wpComponents.TextareaControl,
		SelectControl = wpComponents.SelectControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl;

	class Molla_Icon_Box extends Component {
		constructor() {
			super(...arguments);
		}

		componentDidMount() { }

		componentDidUpdate(prevProps, prevState) { }

		render() {
			var props = this.props,
				attrs = props.attributes;

			var inspectorControls = el(InspectorControls, {},

				el(PanelBody, {
					title: __('Icon'),
					initialOpen: false,
				},
					el(TextControl, {
						label: __('Icon Class'),
						value: attrs.icon_class,
						onChange: (value) => { props.setAttributes({ icon_class: value }); },
					}),
					el(SelectControl, {
						label: __('View'),
						value: attrs.icon_view,
						options: [{ label: __('Default'), value: 'default' }, { label: __('Stacked'), value: 'stacked' }, { label: __('Framed'), value: 'framed' }],
						onChange: (value) => { props.setAttributes({ icon_view: value }); },
					}),
					attrs.icon_view != 'default' && el(TextControl, {
						label: 'Icon Padding',
						value: attrs.icon_padding,
						onChange: (value) => { props.setAttributes({ icon_padding: value }); },
					}),
					attrs.icon_view != 'default' && el(SelectControl, {
						label: __('Shape'),
						value: attrs.icon_shape,
						options: [{ label: __('Circle'), value: 'circle' }, { label: __('Square'), value: 'square' }],
						onChange: (value) => { props.setAttributes({ icon_shape: value }); },
					}),
					attrs.content_style == 'horizontal' && el(SelectControl, {
						label: __('Position'),
						value: attrs.icon_position,
						options: [{ label: __('Inner Content'), value: 'inner' }, { label: __('Outer Content'), value: 'outer' }],
						onChange: (value) => { props.setAttributes({ icon_position: value }); },
					}),
					el(
						'div',
						{ className: 'spacing-panel panel-group', 'data-type': 'Margin' },
						el(TextControl, {
							label: 'Top',
							value: attrs.icon_margin_top,
							onChange: (value) => { props.setAttributes({ icon_margin_top: value }); },
						}),
						el(TextControl, {
							label: 'Bottom',
							value: attrs.icon_margin_bottom,
							onChange: (value) => { props.setAttributes({ icon_margin_bottom: value }); },
						}),
						el(TextControl, {
							label: 'Left',
							value: attrs.icon_margin_left,
							onChange: (value) => { props.setAttributes({ icon_margin_left: value }); },
						}),
						el(TextControl, {
							label: 'Right',
							value: attrs.icon_margin_right,
							onChange: (value) => { props.setAttributes({ icon_margin_right: value }); },
						}),
					),
					el(TextControl, {
						label: __('Font size'),
						value: attrs.icon_font_size,
						onChange: (value) => { props.setAttributes({ icon_font_size: value }); },
					}),
					el(PanelColorSettings, {
						title: __('Icon Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.icon_color,
							onChange: function onChange(value) {
								return props.setAttributes({ icon_color: value });
							}
						}]
					}),
					el(PanelColorSettings, {
						title: __('Icon Background-Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.icon_back_color,
							onChange: function onChange(value) {
								return props.setAttributes({ icon_back_color: value });
							}
						}]
					}),
				),
				el(PanelBody, {
					title: __('Content'),
					initialOpen: false,
				},
					el(TextControl, {
						label: __('Heading'),
						value: attrs.icon_heading,
						onChange: (value) => { props.setAttributes({ icon_heading: value }); },
					}),
					el(SelectControl, {
						label: __('Heading Tag'),
						value: attrs.icon_heading_tag,
						options: [{ label: __('H1'), value: 'h1' }, { label: __('H2'), value: 'h2' }, { label: __('H3'), value: 'h3' }, { label: __('H4'), value: 'h4' }, { label: __('H5'), value: 'h5' }, { label: __('H6'), value: 'h6' }],
						onChange: (value) => { props.setAttributes({ icon_heading_tag: value }); },
					}),
					el(TextControl, {
						label: __('Heading Custom Class'),
						value: attrs.icon_heading_class,
						onChange: (value) => { props.setAttributes({ icon_heading_class: value }); },
					}),
					el(RangeControl, {
						label: __('Heading Spacing'),
						value: attrs.title_spacing,
						min: 0,
						max: 100,
						onChange: (value) => { props.setAttributes({ title_spacing: value }); },
					}),
					el(TextareaControl, {
						label: __('Description'),
						value: attrs.icon_description,
						onChange: (value) => { props.setAttributes({ icon_description: value }); },
					}),
					el(SelectControl, {
						label: __('Description Tag'),
						value: attrs.icon_desc_tag,
						options: [{ label: __('H1'), value: 'h1' }, { label: __('H2'), value: 'h2' }, { label: __('H3'), value: 'h3' }, { label: __('H4'), value: 'h4' }, { label: __('H5'), value: 'h5' }, { label: __('H6'), value: 'h6' }, { label: __('p'), value: 'p' }, { label: __('span'), value: 'span' }],
						onChange: (value) => { props.setAttributes({ icon_desc_tag: value }); },
					}),
					el(TextControl, {
						label: __('Description Custom Class'),
						value: attrs.icon_desc_class,
						onChange: (value) => { props.setAttributes({ icon_desc_class: value }); },
					}),
				),
				el(PanelBody, {
					title: __('Style'),
					initialOpen: false,
				},
					el(PanelColorSettings, {
						title: __('Title Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.title_color,
							onChange: function onChange(value) {
								return props.setAttributes({ title_color: value });
							}
						}]
					}),
					el(
						'div',
						{ className: 'typography-panel panel-group', 'data-type': 'Title' },

						el(TextControl, {
							label: __('Family'),
							value: attrs.title_font_family,
							onChange: (value) => { props.setAttributes({ title_font_family: value }); },
						}),
						el(TextControl, {
							label: __('Size'),
							value: attrs.title_font_size,
							onChange: (value) => { props.setAttributes({ title_font_size: value }); },
						}),
						el(SelectControl, {
							label: __('Weight'),
							value: attrs.title_font_weight,
							options: [{ label: '100', value: '100' }, { label: __('200'), value: '200' }, { label: __('300'), value: '300' }, { label: __('400'), value: '400' }, { label: __('500'), value: '500' }, { label: __('600'), value: '600' }, { label: __('700'), value: '700' }, { label: __('800'), value: '800' }, { label: __('900'), value: '900' }],
							onChange: (value) => { props.setAttributes({ title_font_weight: value }); },
						}),
						el(SelectControl, {
							label: __('Transform'),
							value: attrs.title_font_transform,
							options: [{ label: __('Uppercase'), value: 'uppercase' }, { label: __('Lowercase'), value: 'lowercase' }, { label: __('Capitalize'), value: 'capitalize' }, { label: __('Normal'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ title_font_transform: value }); },
						}),
						el(SelectControl, {
							label: __('Style'),
							value: attrs.title_font_style,
							options: [{ label: __('Normal'), value: 'normal' }, { label: __('Italic'), value: 'italic' }, { label: __('Oblique'), value: 'oblique' }],
							onChange: (value) => { props.setAttributes({ title_font_style: value }); },
						}),
						el(SelectControl, {
							label: __('Decoration'),
							value: attrs.title_font_decoration,
							options: [{ label: __('Underline'), value: 'underline' }, { label: __('Overline'), value: 'overline' }, { label: __('Line Through'), value: 'line-through' }, { label: __('None'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ title_font_decoration: value }); },
						}),
						el(TextControl, {
							label: __('Line-Height'),
							value: attrs.title_font_height,
							onChange: (value) => { props.setAttributes({ title_font_height: value }); },
						}),
						el(TextControl, {
							label: __('Letter Spacing'),
							value: attrs.title_font_ltr_spacing,
							onChange: (value) => { props.setAttributes({ title_font_ltr_spacing: value }); },
						}),
					),
					el(PanelColorSettings, {
						title: __('Description Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.desc_color,
							onChange: function onChange(value) {
								return props.setAttributes({ desc_color: value });
							}
						}]
					}),
					el(
						'div',
						{ className: 'typography-panel panel-group', 'data-type': 'Description' },

						el(TextControl, {
							label: __('Family'),
							value: attrs.desc_font_family,
							onChange: (value) => { props.setAttributes({ desc_font_family: value }); },
						}),
						el(TextControl, {
							label: __('Size'),
							value: attrs.desc_font_size,
							onChange: (value) => { props.setAttributes({ desc_font_size: value }); },
						}),
						el(SelectControl, {
							label: __('Weight'),
							value: attrs.desc_font_weight,
							options: [{ label: '100', value: '100' }, { label: __('200'), value: '200' }, { label: __('300'), value: '300' }, { label: __('400'), value: '400' }, { label: __('500'), value: '500' }, { label: __('600'), value: '600' }, { label: __('700'), value: '700' }, { label: __('800'), value: '800' }, { label: __('900'), value: '900' }],
							onChange: (value) => { props.setAttributes({ desc_font_weight: value }); },
						}),
						el(SelectControl, {
							label: __('Transform'),
							value: attrs.desc_font_transform,
							options: [{ label: __('Uppercase'), value: 'uppercase' }, { label: __('Lowercase'), value: 'lowercase' }, { label: __('Capitalize'), value: 'capitalize' }, { label: __('Normal'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ desc_font_transform: value }); },
						}),
						el(SelectControl, {
							label: __('Style'),
							value: attrs.desc_font_style,
							options: [{ label: __('Normal'), value: 'normal' }, { label: __('Italic'), value: 'italic' }, { label: __('Oblique'), value: 'oblique' }],
							onChange: (value) => { props.setAttributes({ desc_font_style: value }); },
						}),
						el(SelectControl, {
							label: __('Decoration'),
							value: attrs.desc_font_decoration,
							options: [{ label: __('Underline'), value: 'underline' }, { label: __('Overline'), value: 'overline' }, { label: __('Line Through'), value: 'line-through' }, { label: __('None'), value: 'none' }],
							onChange: (value) => { props.setAttributes({ desc_font_decoration: value }); },
						}),
						el(TextControl, {
							label: __('Line-Height'),
							value: attrs.desc_font_height,
							onChange: (value) => { props.setAttributes({ desc_font_height: value }); },
						}),
						el(TextControl, {
							label: __('Letter Spacing'),
							value: attrs.desc_font_ltr_spacing,
							onChange: (value) => { props.setAttributes({ desc_font_ltr_spacing: value }); },
						}),
					),
				),
				el(PanelBody, {
					title: __('Layout'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Type'),
						value: attrs.content_style,
						options: [{ label: __('Horizontal'), value: 'horizontal' }, { label: __('Vertical'), value: 'vertical' }],
						onChange: (value) => { props.setAttributes({ content_style: value }); },
					}),
					el(SelectControl, {
						label: __('Vertical Alignment'),
						value: attrs.icon_align,
						options: [{ label: __('Top'), value: 'flex-start' }, { label: __('Center'), value: 'center' }, { label: __('Bottom'), value: 'flex-end' }],
						onChange: (value) => { props.setAttributes({ icon_align: value }); },
					}),
					el(SelectControl, {
						label: __('Horizontal Alignment'),
						value: attrs.content_align,
						options: [{ label: __('Left'), value: 'flex-start' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'flex-end' }],
						onChange: (value) => { props.setAttributes({ content_align: value }); },
					}),
					el(ToggleControl, {
						label: __('Enable border'),
						checked: attrs.border_enable,
						onChange: (value) => { props.setAttributes({ border_enable: value }); },
					}),
				),
			);

			var icon_wrap_style = '',
				icon_style = '',
				icon_box_class = '',
				icon_box_style = '',
				title_style = '',
				desc_style = '';

			if (attrs.icon_margin_top) {
				icon_style += 'margin-top: ' + attrs.icon_margin_top + ';';
			}
			if (attrs.icon_margin_bottom) {
				icon_style += 'margin-bottom: ' + attrs.icon_margin_bottom + ';';
			}
			if (attrs.icon_margin_left) {
				icon_style += 'margin-left: ' + attrs.icon_margin_left + ';';
			}
			if (attrs.icon_margin_right) {
				icon_style += 'margin-right: ' + attrs.icon_margin_right + ';';
			}
			if (attrs.icon_view != 'default') {
				icon_style += 'padding: ' + (attrs.icon_padding ? attrs.icon_padding : '20px') + ';';
			}
			if (attrs.icon_view == 'stacked') {
				icon_style += 'background-color: ' + attrs.icon_back_color + ';';
			} else if (attrs.icon_view == 'framed') {
				icon_style += 'border-color: ' + attrs.icon_back_color + ';';
			}

			if (attrs.icon_position == 'inner') {
				icon_wrap_style += 'align-items: ' + attrs.icon_align + ';';
			}

			icon_box_class = 'icon-box' +
				(attrs.content_style == 'horizontal' ? ' icon-box-side' : '') +
				' icon-' + attrs.icon_position + '-content' +
				(attrs.border_enable ? ' icon-box-bordered' : '');

			if (attrs.content_style == 'horizontal') {
				if (attrs.icon_position == 'outer') {
					icon_box_style += 'align-items: ' + attrs.icon_align + ';';
					icon_box_style += 'justify-content:' + attrs.content_align + ';';
				} else {
					icon_box_style += 'align-items:' + attrs.content_align + ';';
				}
			} else {
				icon_box_style += 'align-items: ' + attrs.content_align + ';';
				icon_box_style += 'justify-content:' + attrs.icon_align + ';';
				icon_box_style += 'text-align: ' + (attrs.content_align == 'flex-start' ? 'left' : (attrs.content_align == 'flex-end' ? 'right' : attrs.content_align)) + ';';
			}

			icon_style += 'font-size: ' + (attrs.icon_font_size ? attrs.icon_font_size : '4rem') + ';';
			icon_style += 'color: ' + attrs.icon_color + ';';

			title_style = 'font-family: ' + attrs.title_font_family +
				'; font-size: ' + attrs.title_font_size +
				'; font-weight: ' + attrs.title_font_weight +
				'; text-transform: ' + attrs.title_font_transform +
				'; font-style: ' + attrs.title_font_style +
				'; text-decoration: ' + attrs.title_font_decoration +
				'; line-height: ' + attrs.title_font_height +
				'; letter-spacing: ' + attrs.title_font_ltr_spacing +
				'; color: ' + attrs.title_color +
				'; margin-bottom: ' + attrs.title_spacing + 'px';

			desc_style = 'font-family: ' + attrs.desc_font_family +
				'; font-size: ' + attrs.desc_font_size +
				'; font-weight: ' + attrs.desc_font_weight +
				'; text-transform: ' + attrs.desc_font_transform +
				'; font-style: ' + attrs.desc_font_style +
				'; text-decoration: ' + attrs.desc_font_decoration +
				'; line-height: ' + attrs.desc_font_height +
				'; letter-spacing: ' + attrs.desc_font_ltr_spacing +
				'; color: ' + attrs.desc_color;

			var renderControls = el(
				'div',
				{ className: icon_box_class, Style: icon_box_style },
				attrs.icon_class && el(
					'div',
					{ className: 'icon-box-icon icon-' + attrs.icon_view + ' icon-' + attrs.icon_shape, Style: icon_wrap_style },
					el(
						'i',
						{ className: attrs.icon_class, Style: icon_style },
					),
					attrs.content_style != 'vertical' && attrs.icon_position == 'inner' && attrs.icon_heading && el(
						attrs.icon_heading_tag,
						{ className: 'icon-box-title' + (attrs.icon_heading_class ? (' ' + attrs.icon_heading_class) : ''), Style: title_style },
						attrs.icon_heading,
					),
				),
				el(
					'div',
					{ className: 'icon-box-content' },
					(attrs.content_style == 'vertical' || attrs.icon_position == 'outer') && attrs.icon_heading && el(
						attrs.icon_heading_tag,
						{ className: 'icon-box-title' + (attrs.icon_heading_class ? (' ' + attrs.icon_heading_class) : ''), Style: title_style },
						attrs.icon_heading,
					),
					attrs.icon_description && el(
						attrs.icon_desc_tag,
						{ className: 'icon-box-desc' + (attrs.icon_desc_class ? (' ' + attrs.icon_desc_class) : ''), Style: desc_style },
						attrs.icon_description,
					),
				),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	}

	registerBlockType('molla/molla-icon-box', {
		title: 'Molla Icon-Box',
		icon: 'molla',
		category: 'molla',
		attributes: {
			icon_class: {
				type: 'string',
			},
			icon_view: {
				type: 'string',
				default: 'default',
			},
			icon_padding: {
				type: 'string',
				default: '20px',
			},
			icon_shape: {
				type: 'string',
				default: 'circle',
			},
			icon_align: {
				type: 'string',
				default: 'center',
			},
			icon_position: {
				type: 'string',
				default: 'outer',
			},
			icon_margin_top: {
				type: 'string',
				default: '',
			},
			icon_margin_bottom: {
				type: 'string',
				default: '',
			},
			icon_margin_left: {
				type: 'string',
				default: '',
			},
			icon_margin_right: {
				type: 'string',
				default: '',
			},
			icon_font_size: {
				type: 'string',
			},
			icon_color: {
				type: 'string',
			},
			icon_back_color: {
				type: 'string',
			},
			icon_heading: {
				type: 'string',
				default: 'This is the heading',
			},
			icon_heading_tag: {
				type: 'string',
				default: 'h3',
			},
			icon_heading_class: {
				type: 'string',
				default: '',
			},
			icon_description: {
				type: 'string',
				default: '',
			},
			icon_desc_tag: {
				type: 'string',
				default: 'p',
			},
			icon_desc_class: {
				type: 'string',
				default: ''
			},
			content_style: {
				type: 'string',
				default: 'horizontal',
			},
			content_align: {
				type: 'string',
				default: 'center',
			},
			border_enable: {
				type: 'boolean',
				default: false,
			},
			title_spacing: {
				type: 'int',
				default: 3,
			},
			title_color: {
				type: 'string',
				default: '#333',
			},
			desc_color: {
				type: 'string',
				default: '#777',
			},
			title_font_family: {
				type: 'string',
				default: 'Poppins',
			},
			title_font_size: {
				type: 'string',
				default: '1.4rem',
			},
			title_font_weight: {
				type: 'string',
				default: '400',
			},
			title_font_transform: {
				type: 'string',
				default: 'capitalize',
			},
			title_font_style: {
				type: 'string',
				default: 'normal',
			},
			title_font_decoration: {
				type: 'string',
				default: 'none',
			},
			title_font_height: {
				type: 'string',
				default: '1.4',
			},
			title_font_ltr_spacing: {
				type: 'string',
				default: '0',
			},
			desc_font_family: {
				type: 'string',
				default: 'Poppins',
			},
			desc_font_size: {
				type: 'string',
				default: '1.3rem',
			},
			desc_font_weight: {
				type: 'string',
				default: '400',
			},
			desc_font_transform: {
				type: 'string',
				default: 'none',
			},
			desc_font_style: {
				type: 'string',
				default: 'normal',
			},
			desc_font_decoration: {
				type: 'string',
				default: 'none',
			},
			desc_font_height: {
				type: 'string',
				default: '1.4',
			},
			desc_font_ltr_spacing: {
				type: 'string',
				default: '0',
			},
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Icon_Box,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash);


/**
 * 8. Molla Button
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		el = wpElement.createElement,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		TextControl = wpComponents.TextControl,
		PanelColorSettings = wpblockEditor.PanelColorSettings,
		TextareaControl = wpComponents.TextareaControl,
		SelectControl = wpComponents.SelectControl,
		RangeControl = wpComponents.RangeControl,
		ToggleControl = wpComponents.ToggleControl;

	class Molla_Button extends Component {
		constructor() {
			super(...arguments);
		}

		componentDidMount() { }

		componentDidUpdate(prevProps, prevState) { }

		internalCss() {
			var props = this.props,
				attrs = props.attributes,
				clientId = props.clientId;

			var internal = '';

			if (attrs.icon_show_hover) {
				internal = '#block-' + clientId + ' .icon-hidden:hover i,' + '#block-' + clientId + ' .icon-hidden:focus i {';
				if (attrs.icon_mg_top) {
					internal += 'margin-top: ' + attrs.icon_mg_top + ';';
				}
				if (attrs.icon_mg_right) {
					internal += 'margin-right: ' + attrs.icon_mg_right + ';';
				}
				if (attrs.icon_mg_bottom) {
					internal += 'margin-bottom: ' + attrs.icon_mg_bottom + ';';
				}
				if (attrs.icon_mg_left) {
					internal += 'margin-left: ' + attrs.icon_mg_left + ';';
				}
				internal += '}';
			}

			internal += '#block-' + clientId + ' .btn {';
			if (attrs.btn_color) {
				internal += 'color: ' + attrs.btn_color + ';';
			}
			if (attrs.btn_backcolor) {
				internal += 'background-color: ' + attrs.btn_backcolor + ';';
			}
			if (attrs.btn_bordercolor) {
				internal += 'border-color: ' + attrs.btn_bordercolor + ';';
			}
			internal += '}';

			internal += '#block-' + clientId + ' .btn:hover, ' + '#block-' + clientId + ' .btn:focus {';
			if (attrs.btn_hover_color) {
				internal += 'color: ' + attrs.btn_hover_color + ';';
			}
			if (attrs.btn_hover_backcolor) {
				internal += 'background-color: ' + attrs.btn_hover_backcolor + ';';
			}
			if (attrs.btn_hover_bordercolor) {
				internal += 'border-color: ' + attrs.btn_hover_bordercolor + ';';
			}
			internal += '}';

			return internal;
		}

		render() {
			var _this = this,
				props = this.props,
				attrs = props.attributes,
				clientId = props.clientId;

			var inspectorControls = el(InspectorControls, {},

				el(PanelBody, {
					title: __('Content'),
					initialOpen: false,
				},
					el(TextControl, {
						label: __('Text'),
						value: attrs.btn_text,
						onChange: (value) => { props.setAttributes({ btn_text: value }); },
					}),
					el(TextControl, {
						label: __('Link'),
						value: attrs.btn_link_url,
						onChange: (value) => { props.setAttributes({ btn_link_url: value }); },
					}),
					el(ToggleControl, {
						label: __('Open In New Tab'),
						checked: attrs.btn_link_new_tab,
						onChange: (value) => { props.setAttributes({ btn_link_new_tab: value }); },
					}),
					attrs.btn_link_new_tab && el(TextControl, {
						label: __('Link Rel'),
						value: attrs.btn_link_rel,
						onChange: (value) => { props.setAttributes({ btn_link_rel: value }); },
					}),
					el(SelectControl, {
						label: __('Type'),
						value: attrs.btn_type,
						options: [{ label: __('Default'), value: '' }, { label: __('Outline'), value: 'outline' }, { label: __('Link'), value: 'link' }],
						onChange: (value) => { props.setAttributes({ btn_type: value }); },
					}),
					el(SelectControl, {
						label: __('Corner Type'),
						value: attrs.btn_corner_type,
						options: [{ label: __('Rounded'), value: 'rounded' }, { label: __('Square'), value: '' }, { label: __('Ellipse'), value: 'round' }],
						onChange: (value) => { props.setAttributes({ btn_corner_type: value }); },
					}),
					el(SelectControl, {
						label: __('Button Size'),
						value: attrs.btn_size,
						options: [{ label: __('Small'), value: 'sm' }, { label: __('Normal'), value: 'md' }, { label: __('Large'), value: 'lg' }],
						onChange: (value) => { props.setAttributes({ btn_size: value }); },
					}),
					el(
						'div',
						{ className: 'spacing-panel panel-group', 'data-type': 'Padding' },
						el(TextControl, {
							label: 'Top',
							value: attrs.btn_pd_top,
							onChange: (value) => { props.setAttributes({ btn_pd_top: value }); },
						}),
						el(TextControl, {
							label: 'Bottom',
							value: attrs.btn_pd_bottom,
							onChange: (value) => { props.setAttributes({ btn_pd_bottom: value }); },
						}),
						el(TextControl, {
							label: 'Left',
							value: attrs.btn_pd_left,
							onChange: (value) => { props.setAttributes({ btn_pd_left: value }); },
						}),
						el(TextControl, {
							label: 'Right',
							value: attrs.btn_pd_right,
							onChange: (value) => { props.setAttributes({ btn_pd_right: value }); },
						}),
					),
					el(
						'div',
						{ className: 'spacing-panel panel-group', 'data-type': 'Margin' },
						el(TextControl, {
							label: 'Top',
							value: attrs.btn_mg_top,
							onChange: (value) => { props.setAttributes({ btn_mg_top: value }); },
						}),
						el(TextControl, {
							label: 'Bottom',
							value: attrs.btn_mg_bottom,
							onChange: (value) => { props.setAttributes({ btn_mg_bottom: value }); },
						}),
						el(TextControl, {
							label: 'Left',
							value: attrs.btn_mg_left,
							onChange: (value) => { props.setAttributes({ btn_mg_left: value }); },
						}),
						el(TextControl, {
							label: 'Right',
							value: attrs.btn_mg_right,
							onChange: (value) => { props.setAttributes({ btn_mg_right: value }); },
						}),
					),
					el(TextControl, {
						label: __('Border-radius'),
						value: attrs.btn_border_radius,
						onChange: (value) => { props.setAttributes({ btn_border_radius: value }); },
					}),
					el(SelectControl, {
						label: __('Alignment'),
						value: attrs.btn_align,
						options: [{ label: __('Left'), value: 'flex-start' }, { label: __('Center'), value: 'center' }, { label: __('Right'), value: 'flex-end' }, { label: __('Justified'), value: 'space-between' }],
						onChange: (value) => { props.setAttributes({ btn_align: value }); },
					}),
					el(TextControl, {
						label: __('Icon Class'),
						value: attrs.btn_icon_class,
						onChange: (value) => { props.setAttributes({ btn_icon_class: value }); },
					}),
					el(TextControl, {
						label: __('Icon Font Size'),
						value: attrs.icon_font_size,
						onChange: (value) => { props.setAttributes({ icon_font_size: value }); },
					}),
					el(ToggleControl, {
						label: __('Icon Before Text?'),
						checked: attrs.icon_before,
						onChange: (value) => { props.setAttributes({ icon_before: value }); },
					}),
					el(ToggleControl, {
						label: __('Show Icon When Hover?'),
						checked: attrs.icon_show_hover,
						onChange: (value) => { props.setAttributes({ icon_show_hover: value }); },
					}),
					el(
						'div',
						{ className: 'spacing-panel panel-group', 'data-type': 'Icon Margin' },
						el(TextControl, {
							label: 'Top',
							value: attrs.icon_mg_top,
							onChange: (value) => { props.setAttributes({ icon_mg_top: value }); },
						}),
						el(TextControl, {
							label: 'Bottom',
							value: attrs.icon_mg_bottom,
							onChange: (value) => { props.setAttributes({ icon_mg_bottom: value }); },
						}),
						el(TextControl, {
							label: 'Left',
							value: attrs.icon_mg_left,
							onChange: (value) => { props.setAttributes({ icon_mg_left: value }); },
						}),
						el(TextControl, {
							label: 'Right',
							value: attrs.icon_mg_right,
							onChange: (value) => { props.setAttributes({ icon_mg_right: value }); },
						}),
					),

				),
				el(PanelBody, {
					title: __('Style'),
					initialOpen: false,
				},
					el(TextControl, {
						label: __('Custom Class'),
						value: attrs.btn_custom_class,
						onChange: (value) => { props.setAttributes({ btn_custom_class: value }); },
					}),
					el(
						'div',
						{ className: 'radio-button-control-wrapper' },
						el(
							'button', {
							className: 'radio-button-control' + (attrs.radio_active ? '' : ' active'),
							onClick: function onClick() {
								props.setAttributes({ radio_active: false });
							},
						},
							__('Normal'),
						),
						el(
							'button', {
							className: 'radio-button-control' + (attrs.radio_active ? ' active' : ''),
							onClick: function onClick() {
								props.setAttributes({ radio_active: true });
							},
						},
							__('Hover'),
						),
					),
					!attrs.radio_active && el(PanelColorSettings, {
						title: __('Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.btn_color,
							onChange: function onChange(value) {
								return props.setAttributes({ btn_color: value });
							}
						}]
					}),
					!attrs.radio_active && el(PanelColorSettings, {
						title: __('Background-Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.btn_backcolor,
							onChange: function onChange(value) {
								return props.setAttributes({ btn_backcolor: value });
							}
						}]
					}),
					!attrs.radio_active && el(PanelColorSettings, {
						title: __('Border-Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.btn_bordercolor,
							onChange: function onChange(value) {
								return props.setAttributes({ btn_bordercolor: value });
							}
						}]
					}),
					attrs.radio_active && el(PanelColorSettings, {
						title: __('Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.btn_hover_color,
							onChange: function onChange(value) {
								return props.setAttributes({ btn_hover_color: value });
							}
						}]
					}),
					attrs.radio_active && el(PanelColorSettings, {
						title: __('Background-Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.btn_hover_backcolor,
							onChange: function onChange(value) {
								return props.setAttributes({ btn_hover_backcolor: value });
							}
						}]
					}),
					attrs.radio_active && el(PanelColorSettings, {
						title: __('Border-Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.btn_hover_bordercolor,
							onChange: function onChange(value) {
								return props.setAttributes({ btn_hover_bordercolor: value });
							}
						}]
					}),
				),
			);

			var btn_class = '',
				btn_style = '',
				wrap_style = '',
				icon_style = '';

			if (attrs.btn_pd_top) {
				btn_style += 'padding-top: ' + attrs.btn_pd_top + ';';
			}
			if (attrs.btn_pd_right) {
				btn_style += 'padding-right: ' + attrs.btn_pd_right + ';';
			}
			if (attrs.btn_pd_bottom) {
				btn_style += 'padding-bottom: ' + attrs.btn_pd_bottom + ';';
			}
			if (attrs.btn_pd_left) {
				btn_style += 'padding-left: ' + attrs.btn_pd_left + ';';
			}
			if (attrs.btn_mg_top) {
				btn_style += 'margin-top: ' + attrs.btn_mg_top + ';';
			}
			if (attrs.btn_mg_right) {
				btn_style += 'margin-right: ' + attrs.btn_mg_right + ';';
			}
			if (attrs.btn_mg_bottom) {
				btn_style += 'margin-bottom: ' + attrs.btn_mg_bottom + ';';
			}
			if (attrs.btn_mg_left) {
				btn_style += 'margin-left: ' + attrs.btn_mg_left + ';';
			}
			if (attrs.btn_border_radius) {
				btn_style += 'border-radius: ' + attrs.btn_border_radius + ';';
			}
			if (attrs.icon_before) {
				btn_style += 'flex-flow: row-reverse;';
			}
			if (!attrs.icon_show_hover) {
				if (attrs.icon_mg_top) {
					icon_style += 'margin-top: ' + attrs.icon_mg_top + ';';
				}
				if (attrs.icon_mg_right) {
					icon_style += 'margin-right: ' + attrs.icon_mg_right + ';';
				}
				if (attrs.icon_mg_bottom) {
					icon_style += 'margin-bottom: ' + attrs.icon_mg_bottom + ';';
				}
				if (attrs.icon_mg_left) {
					icon_style += 'margin-left: ' + attrs.icon_mg_left + ';';
				}
			}
			if (attrs.icon_font_size) {
				icon_style += 'font-size: ' + attrs.icon_font_size + ';';
			}

			btn_class = 'btn btn-' + attrs.btn_corner_type +
				' btn-' + (attrs.btn_type ? attrs.btn_type : 'primary') +
				' btn-' + attrs.btn_size +
				' ' + attrs.btn_custom_class;
			if (attrs.icon_show_hover) {
				btn_class += ' icon-hidden';
			}

			wrap_style = 'justify-content: ' + attrs.btn_align + ';';

			var target = '',
				rel = '';
			if (attrs.btn_link_new_tab) {
				target = '_blank';
				rel = attrs.btn_link_rel;
			}


			var renderControls = el(
				'div',
				{ className: 'btn-wrap', Style: wrap_style },
				el(
					'style',
					{ 'type': 'text/css' },
					_this.internalCss(),
				),
				el(
					'a',
					{ href: (attrs.btn_link_url ? attrs.btn_link_url : '#'), className: btn_class, Style: btn_style, target, rel },
					attrs.btn_text,
					attrs.btn_icon_class && el(
						'i',
						{ className: attrs.btn_icon_class, Style: icon_style },
					),
				),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	}

	registerBlockType('molla/molla-button', {
		title: 'Molla Button',
		icon: 'molla',
		category: 'molla',
		attributes: {
			btn_type: {
				type: 'string',
				default: '',
			},
			btn_corner_type: {
				type: 'string',
				default: 'rounded',
			},
			btn_text: {
				type: 'string',
				default: 'Click here',
			},
			btn_link_url: {
				type: 'string',
				default: '#',
			},
			btn_link_new_tab: {
				type: 'boolean',
				default: false,
			},
			btn_link_rel: {
				type: 'string',
				default: '',
			},
			btn_border_radius: {
				type: 'string',
			},
			btn_align: {
				type: 'string',
				default: 'left',
			},
			btn_size: {
				type: 'string',
				default: 'md',
			},
			btn_pd_top: {
				type: 'string',
				default: ''
			},
			btn_pd_right: {
				type: 'string',
				default: ''
			},
			btn_pd_bottom: {
				type: 'string',
				default: ''
			},
			btn_pd_left: {
				type: 'string',
				default: ''
			},
			btn_mg_top: {
				type: 'string',
				default: ''
			},
			btn_mg_right: {
				type: 'string',
				default: ''
			},
			btn_mg_bottom: {
				type: 'string',
				default: ''
			},
			btn_mg_left: {
				type: 'string',
				default: ''
			},
			btn_icon_class: {
				type: 'string',
				default: '',
			},
			icon_mg_top: {
				type: 'string',
				default: '',
			},
			icon_mg_right: {
				type: 'string',
				default: '',
			},
			icon_mg_bottom: {
				type: 'string',
				default: '',
			},
			icon_mg_left: {
				type: 'string',
				default: '',
			},
			icon_font_size: {
				type: 'string',
				default: '',
			},
			icon_before: {
				type: 'boolean',
				default: false,
			},
			icon_show_hover: {
				type: 'boolean',
				default: false,
			},
			btn_color: {
				type: 'string',
				default: '',
			},
			btn_hover_color: {
				type: 'string',
				default: '',
			},
			btn_backcolor: {
				type: 'string',
				default: '',
			},
			btn_hover_backcolor: {
				type: 'string',
				default: '',
			},
			btn_bordercolor: {
				type: 'string',
				default: '',
			},
			btn_hover_bordercolor: {
				type: 'string',
				default: '',
			},
			radio_active: {
				type: 'boolean',
				default: false,
			},
			btn_custom_class: {
				type: 'string',
				default: '',
			}
		},
		edit: Molla_Button,
		supports: {
			align: ['wide', 'full'],
		},
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash);

/**
 * 9. Molla Section
 */
(function (wpI18n, wpBlocks, wpElement, wpEditor, wpblockEditor, wpComponents, wpData, lodash) {
	"use strict";

	var __ = wpI18n.__,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpblockEditor.InnerBlocks,
		InspectorControls = wpblockEditor.InspectorControls,
		MediaUpload = wpEditor.MediaUpload,
		el = wpElement.createElement,
		PanelColorSettings = wpblockEditor.PanelColorSettings,
		Component = wpElement.Component,
		PanelBody = wpComponents.PanelBody,
		TextControl = wpComponents.TextControl,
		SelectControl = wpComponents.SelectControl,
		IconButton = wpComponents.IconButton;

	class Molla_Section extends Component {

		constructor() {
			super(...arguments);
		}

		componentDidMount() { }

		componentDidUpdate(prevProps, prevState) { }

		render() {
			var props = this.props,
				attrs = props.attributes;

			var inspectorControls = el(InspectorControls, {},

				el(PanelBody, {
					title: __('Section Options'),
					initialOpen: false,
				},
					el(SelectControl, {
						label: __('Wrapper'),
						value: attrs.wrapper,
						options: [{ label: __('Container'), value: 'container' }, { label: __('Container-Fluid'), value: 'container-fluid' }, { label: __('Full'), value: 'full-inner' }],
						onChange: (value) => { props.setAttributes({ wrapper: value }); },
					}),
					el(PanelColorSettings, {
						title: __('Background Color'),
						initialOpen: false,
						colorSettings: [{
							label: __('Color'),
							value: attrs.back_color,
							onChange: function onChange(value) {
								return props.setAttributes({ back_color: value });
							}
						}]
					}),
					el(MediaUpload, {
						label: __('Background Image'),
						allowedTypes: ['image'],
						value: attrs.back_img,
						onSelect: (img) => { props.setAttributes({ back_img_url: img.url, back_img: img.id }); },
						render: function render(_ref) {
							var open = _ref.open;
							return el(IconButton, {
								className: 'components-toolbar__control',
								label: __('Banner Image'),
								icon: 'edit',
								onClick: open
							});
						}
					}),
					el(IconButton, {
						className: 'components-toolbar__control',
						label: __('Remove image'),
						icon: 'no',
						onClick: function onClick() {
							return props.setAttributes({ back_img_url: undefined, back_img: undefined });
						}
					}),
					el(
						'div',
						{ className: 'spacing-panel panel-group', 'data-type': 'Padding(px)' },
						el(TextControl, {
							label: 'Top',
							type: 'number',
							value: attrs.pd_top,
							onChange: (value) => { props.setAttributes({ pd_top: value }); },
						}),
						el(TextControl, {
							label: 'Bottom',
							type: 'number',
							value: attrs.pd_bottom,
							onChange: (value) => { props.setAttributes({ pd_bottom: value }); },
						}),
						el(TextControl, {
							label: 'Left',
							type: 'number',
							value: attrs.pd_left,
							onChange: (value) => { props.setAttributes({ pd_left: value }); },
						}),
						el(TextControl, {
							label: 'Right',
							type: 'number',
							value: attrs.pd_right,
							onChange: (value) => { props.setAttributes({ pd_right: value }); },
						}),
					),
				),
			);

			let wrapper_class = attrs.wrapper;
			let section_style = '';

			section_style = 'padding: ' + Number(attrs.pd_top) + 'px '
				+ Number(attrs.pd_right) + 'px '
				+ Number(attrs.pd_bottom) + 'px '
				+ Number(attrs.pd_left) + 'px;';
			if (attrs.back_color) {
				section_style += ' background-color: ' + attrs.back_color + '';
			}
			if (attrs.back_img_url) {
				section_style += ' background-image: url("' + attrs.back_img_url + '"); background-repeat: no-repeat; background-size: cover; background-position: center;';
			}

			var renderControls = el(
				'div',
				{ className: 'section', Style: section_style },
				el(
					'div',
					{ className: wrapper_class },
					el(InnerBlocks),
				),
			);


			return [
				inspectorControls,
				renderControls,
			];
		}
	}

	registerBlockType('molla/molla-section', {
		title: 'Molla Section',
		icon: 'molla',
		category: 'molla',
		attributes: {
			wrapper: {
				type: 'string',
				default: 'container',
			},
			back_color: {
				type: 'string',
			},
			back_img: {
				type: 'int',
			},
			back_img_url: {
				type: 'string',
			},
			pd_top: {
				type: 'int',
				default: 20,
			},
			pd_right: {
				type: 'int',
				default: 0,
			},
			pd_bottom: {
				type: 'int',
				default: 20,
			},
			pd_left: {
				type: 'int',
				default: 0,
			}
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: Molla_Section,
		save: function (props) {
			return el(InnerBlocks.Content);
		}
	});
})(wp.i18n, wp.blocks, wp.element, wp.editor, wp.blockEditor, wp.components, wp.data, lodash);

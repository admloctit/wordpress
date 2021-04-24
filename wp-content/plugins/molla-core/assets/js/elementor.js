jQuery(document).ready(function ($) {
	'use strict';
	if (typeof elementorFrontend != 'undefined') {
		if (typeof Molla != 'undefined') {
			var mollaElementorInit = function () {
				var molla_widgets = ['molla_product.default', 'molla_product_category.default', 'molla_blog.default', 'molla_cl_image.default', 'molla_image_carousel.default'];
				$.each(molla_widgets, function (key, element_name) {
					elementorFrontend.hooks.addAction('frontend/element_ready/' + element_name, function ($obj) {
						Molla.owlCarousels($obj.parent());
						Molla.layoutInit($obj.find('[data-toggle="isotope"]'));

						if ('molla_product.default' == element_name) {
							Molla.productTotalSales($obj.find('.products'));
							Molla.productSlide();
							Molla.countDown($obj.find('.products'));
						}

						if ('molla_cl_image.default' == element_name) {
							Molla.elevateZoomCtrl();
							Molla.thumbnailSlide($obj);
						}
					});
				});

				elementorFrontend.hooks.addAction('frontend/element_ready/molla_count_down.default', function ($obj) {
					Molla.countDown($obj);
				});
				elementorFrontend.hooks.addAction('frontend/element_ready/molla_cl_countdown.default', function ($obj) {
					Molla.countDown($obj);
				});

				elementorFrontend.hooks.addAction('frontend/element_ready/molla_count_to.default', function ($obj) {
					Molla.countTo();
				});
				elementorFrontend.hooks.addAction('frontend/element_ready/molla_floating_image.default', function ($obj) {
					Molla.floatingElements($obj);
				});
				elementorFrontend.hooks.addAction('frontend/element_ready/molla_banner.default', function ($obj) {
					$obj.find('.elementor-invisible').removeClass('elementor-invisible');
				});

				elementorFrontend.hooks.addAction('frontend/element_ready/molla_cl_cart_form.default', function ($obj) {
					Molla.quantityInputs($obj.find("input[type='number']"));
				})

				elementorFrontend.hooks.addAction('frontend/element_ready/column', function ($obj) {
					var $row = $obj.closest('.elementor-row');
					if (!$row.length) {
						$row = $obj.closest('.elementor-container');
					}
					if ($obj.find('.molla-elementor-column-wrap').data('toggle') == 'owl') {
						var $column_carousel = $obj.find('.molla-elementor-column-wrap');
						if ($column_carousel.children('.elementor-background-overlay').length) {
							$column_carousel.children('.elementor-background-overlay').remove();
						}
						$column_carousel.trigger('destroy.owl.carousel');
						Molla.owlCarousels($column_carousel.parent());
					}

					remove_banner_content($obj);
					remove_tab_content($obj);

					if ($row.attr('data-toggle') == 'owl') {
						$row.trigger('destroy.owl.carousel');
						Molla.owlCarousels($row.parent());
					} else if ($obj.find('.molla-elementor-column-wrap').eq(0).data('role') == 'tab-content') {
						var title = $obj.find('.molla-elementor-column-wrap').eq(0).data('tab-title');
						$obj.attr('role', 'tabpanel');
						$obj.addClass('tab-pane');
						var $links = $row.children('ul.nav');
						if ($links.find('[pane-id="' + $obj.data('id') + '"]').length) {
							$links.find('[pane-id="' + $obj.data('id') + '"] a').html(title);
						} else {
							$links.append('<li class="nav-item" pane-id="' + $obj.data('id') + '"><a href="#" class="nav-link" data-toggle="tab" data-target="' + $obj.data('id') + '" role="tab">' + title + '</a></li>');
						}
						var $first = $row.find('ul.nav > li:first-child');
						if (!$first.hasClass('active')) {
							$first.addClass('active');
							$first.closest('ul.nav').siblings('.tab-pane').addClass('active');
						}
					} else if ($row.hasClass('accordion')) {
						if (!$obj.parent().hasClass('accordion-panel')) {
							$obj.wrap('<div class="accordion-panel"><div class="panel-body collapse show"></div></div>');
						}
						if (!$obj.parent().siblings('.panel-header').length) {
							$obj.parent().before($row.children('.panel-header').clone());
						}

						var $toggle = $obj.parent().siblings('.panel-header').find('a'),
							$panel_body = $obj.parent(),
							id = $obj.attr('data-id');

						$toggle.children('.title').html($obj.find('.molla-elementor-column-wrap').eq(0).attr('data-accordion-title'));
						$toggle.children('i:first-child').attr('class', $obj.find('.molla-elementor-column-wrap').eq(0).attr('data-accordion-icon'));
						$toggle.attr('data-target', '#panel-' + id);
						$panel_body.attr('id', 'panel-' + id).attr('data-parent', '#accordion-' + $row.closest('.elementor-section').attr('data-id'));

						if ($row.find('.panel-body:not(.show)').length) {
							setTimeout(function () {
								$obj.removeClass('show');
							}, 300);
						}
					} else if ('isotope' == $row.data('toggle')) {
						if (!$row.data('creative-preset')) {
							$.ajax({
								url: plugin.ajax_url,
								data: {
									action: 'molla_load_creative_layout',
									nonce: plugin.wpnonce,
									mode: $row.data('creative-mode'),
								},
								type: 'post',
								async: false,
								success: function (res) {
									if (res) {
										$row.data('creative-preset', res);
									}
								}
							});
						}

						// Remove existing layout classes
						var cls = $obj.attr('class');
						cls = cls.slice(0, cls.indexOf("grid-item")) + cls.slice(cls.indexOf("size-"));
						$obj.attr('class', cls);
						$obj.removeClass('size-small size-medium size-large e');

						var preset = JSON.parse($row.data('creative-preset')),
							grid_info_src = $obj.find('.molla-elementor-column-wrap').eq(0),
							grid_item = grid_info_src.data('creative-item'),
							grid_cat_title = grid_info_src.data('creative-cat-title'),
							grid_cat_slug = grid_cat_title ? grid_cat_title.replace(' ', '-').toLowerCase() : '';

						Object.entries(grid_item).forEach(function (item) {
							if ('preset' != item[1]) {
								grid_item[item[0]] = item[1];
							} else if (undefined == preset[$obj.index()] || undefined == preset[$obj.index()][item[0]]) {
								if ('w' == item[0]) {
									item[1] = '1-4';
									grid_item['w-l'] = '1-2';
								} else if ('h' == item[0]) {
									item[1] = '1-3';
								}

								grid_item[item[0]] = item[1];
							} else {
								if ('h' != item[0]) {
									grid_item = preset[$obj.index()];
								} else {
									grid_item['h'] = preset[$obj.index()]['h'];
								}
							}
						})

						var style = '<style>';
						Object.entries(grid_item).forEach(function (item) {
							if ('h' == item[0] || 'h-l' == item[0] || 'h-m' == item[0]) {
								return;
							}
							if (item[1] == 1) {
								grid_item[item[0]] = '1';
							} else if (100 % item[1] == 0) {
								grid_item[item[0]] = '1-' + (100 / item[1]);
							} else {
								for (var i = 1; i <= 100; ++i) {
									var val = item[1] * i;
									var val_round = Math.round(val);
									if (Math.abs(Math.ceil((val - val_round) * 100) / 100) <= 0.01) {
										var g = gcd(100, val_round);
										var numer = val_round / g;
										var deno = i * 100 / g;
										grid_item[item[0]] = numer + '-' + deno;

										// For Smooth Resizing of Isotope Layout
										if ('w-l' == item[0]) {
											style += '@media (max-width: 991px) {';
										} else if ('w-m' == item[0]) {
											style += '@media (max-width: 767px) {';
										}

										style += '.elementor-element-' + $row.closest('.elementor-section').attr('data-id') + ' .grid-item.' + item[0] + '-' + numer + '-' + deno + '{flex:0 0 ' + (numer * 100 / deno).toFixed(4) + '%;width:' + (numer * 100 / deno).toFixed(4) + '%}';

										if ('w-l' == item[0] || 'w-m' == item[0]) {
											style += '}';
										}
										break;
									}
								}

							}
						})
						style += '</style>';
						$row.before(style);

						$obj.addClass(get_creative_class(grid_item));
						$obj.addClass(grid_cat_slug);

						// Set Order Data
						$obj.attr('data-creative-order', (undefined == $obj.find('.molla-elementor-column-wrap').eq(0).attr('data-creative-order') ? $obj.index() + 1 : $obj.find('.molla-elementor-column-wrap').eq(0).attr('data-creative-order')));
						$obj.attr('data-creative-order-lg', (undefined == $obj.find('.molla-elementor-column-wrap').eq(0).attr('data-creative-order-lg') ? $obj.index() + 1 : $obj.find('.molla-elementor-column-wrap').eq(0).attr('data-creative-order-lg')));
						$obj.attr('data-creative-order-md', (undefined == $obj.find('.molla-elementor-column-wrap').eq(0).attr('data-creative-order-md') ? $obj.index() + 1 : $obj.find('.molla-elementor-column-wrap').eq(0).attr('data-creative-order-md')));

						var layout = $row.data('creative-layout');
						if (!layout) {
							layout = [];
						}
						layout[$obj.index()] = grid_item;
						$row.data('creative-layout', layout);
						$row.find('.grid-space').appendTo($row);
						Object.setPrototypeOf($obj.get(0), HTMLElement.prototype);

						var timer = setTimeout(function () {
							elementorFrontend.hooks.doAction('refresh_isotope_layout', timer, $row);
						}, 300);
					} else if ($row.hasClass('banner')) {
						var banner_class = $obj.find('.molla-elementor-column-wrap').eq(0).data('banner-class');
						$obj.attr('class', $obj.attr('class').replace(/ t-x-.* /, ' '));
						if (banner_class) {
							$obj.addClass(banner_class);
						}
					}
				});

				if (typeof elementor != 'undefined') {
					elementor.channels.data.on('element:after:add', function (e) {
						var $obj = $('[data-id="' + e.id + '"]'),
							$row = $obj.closest('.elementor-row');
						if (!$row.length) {
							$row = $obj.closest('.elementor-container');
						}
						if ('column' == e.elType && 'owl' == $row.data('toggle')) {
							$row.trigger('destroy.owl.carousel');
						} else if ('owl' == $obj.closest('.molla-elementor-column-wrap').data('toggle')) {
							$obj.closest('.molla-elementor-column-wrap').trigger('destroy.owl.carousel');
							setTimeout(function () {
								Molla.owlCarousels($obj.closest('.molla-elementor-column-wrap').parent());
							}, 300);
						} else if ('column' == e.elType && 'isotope' == $row.data('toggle')) {
							$row.isotope('destroy');
						}
					});

					elementor.channels.data.on('element:before:remove', function (e) {
						var $obj = $('[data-id="' + e.id + '"]'),
							$row = $obj.closest('.elementor-row');
						if (!$row.length) {
							$row = $obj.closest('.elementor-container');
						}
						if ('column' == e.attributes.elType && 'owl' == $row.data('toggle')) {
							var pos = $obj.parent('.owl-item:not(.cloned)').index() - ($row.find('.owl-item.cloned').length / 2);
							$row.trigger('remove.owl.carousel', pos);
						} else if ('owl' == $obj.closest('.molla-elementor-column-wrap').data('toggle')) {
							var $parent = $obj.closest('.molla-elementor-column-wrap');
							var pos = $obj.closest('.owl-item:not(.cloned)').index() - ($parent.find('.owl-item.cloned').length / 2);
							$parent.trigger('destroy.owl.carousel');
							setTimeout(function () {
								Molla.owlCarousels($parent.parent());
							}, 300);
						} else if ('column' == e.attributes.elType && $row.hasClass('tab-section')) {
							var $link = $row.children('ul.nav').find('li a[data-target="' + $obj.data('id') + '"]');
							$link.parent().remove();
						} else if ('column' == e.attributes.elType && 'isotope' == $row.data('toggle')) {
							$row.isotope('remove', $obj).isotope('layout');
						}
					});
				}

				elementorFrontend.hooks.addAction('frontend/element_ready/section', function ($obj) {
					var $row = $obj.children('.elementor-container').children('.elementor-row');
					if (!$row.length) {
						$row = $obj.children('.elementor-container');
					}
					var $section = $row.closest('.elementor-section');

					if ($row.data('plx-img')) {
						$section.addClass('parallax-container');
						$section.attr('data-plx-img', $row.data('plx-img'));
						if ($row.data('plx-img-repeat')) {
							$section.attr('data-plx-img-repeat', $row.data('plx-img-repeat'));
						}
						if ($row.data('plx-img-pos')) {
							$section.attr('data-plx-img-pos', $row.data('plx-img-pos'));
						}
						if ($row.data('plx-img-att')) {
							$section.attr('data-plx-img-att', $row.data('plx-img-att'));
						}
						if ($row.data('plx-img-size')) {
							$section.attr('data-plx-img-size', $row.data('plx-img-size'));
						}
						if ($row.data('plx-speed')) {
							$section.attr('data-plx-speed', $row.data('plx-speed'));
						}
						Molla.parallaxCtrl();
					} else {
						$section.removeClass('parallax-container');
					}

					if ($row.hasClass('section-parallax-inner')) {
						$section.addClass('section-parallax overflow-hidden');
						$section.attr('data-plx-speed', $row.data('plx-speed'));
					}

					if (!$row.hasClass('img-not-fixed') && $row.hasClass('banner')) {
						$obj.addClass('background-image-none');
					} else {
						$obj.removeClass('background-image-none');
					}

					if ($row.hasClass('accordion')) {
						$row.attr('id', 'accordion-' + $section.attr('data-id'));
						$row.children('.panel-header').remove();

						setTimeout(function () {
							$row.find('.accordion-panel:not(:first-child) .panel-body').removeClass('show');
							$row.find('.accordion-panel:first-child .panel-header a').removeClass('collapsed');
						}, 300);

						if (!$.fn.collapse && plugin.assets_url) {
							$(document.createElement('script')).attr('id', 'bootstrap-bundle').appendTo('body').attr('src', plugin.assets_url + 'bootstrap.bundle.min.js');
						}
					}

					if ('isotope' == $row.data('toggle')) {
						$row.append('<div class="grid-space"></div>');
						$row.attr('data-creative-breaks', JSON.stringify({
							md: plugin.breakpoints['md'],
							lg: plugin.breakpoints['lg'],
						}));
						Object.setPrototypeOf($row.get(0), HTMLElement.prototype);
						var timer = setTimeout(function () {
							elementorFrontend.hooks.doAction('refresh_isotope_layout', timer, $row);
						});
					} else {
						remove_creative($row);
					}
					if ($row.attr('data-sticky') == 'true' && !$section.parent().hasClass('sticky-wrapper')) {
						$section.addClass('sticky-header').wrap('<div class="sticky-wrapper"></div>');
					}
				});

				elementorFrontend.hooks.addAction('refresh_dynamic_css', function (css) {
					var $obj = $('style#molla-elementor-custom-css');
					if (!$obj.length) {
						$obj = $('<style id="molla-elementor-custom-css"></style>').appendTo('head');
					}
					css = css.replace('/<script.*?\/script>/s', '');
					$obj.html(css);
				});

				elementorFrontend.hooks.addAction('refresh_dynamic_script', function (script) {
					var $obj = $('script#molla-elementor-custom-script');
					if (!$obj.length) {
						$obj = $('<script id="molla-elementor-custom-script"></script>').appendTo('body');
					}
					$obj.html(script);
				});

				elementorFrontend.hooks.addAction('refresh_isotope_layout', function (timer, $selector) {
					if (timer) {
						clearTimeout(timer);
					}
					if (undefined == $selector) {
						var $row = $('.elementor-element-editable').closest('.grid');
					} else {
						var $row = $selector;
					}
					$row.siblings('style').remove();

					var nav_filter = $row.siblings('.nav-filter');
					if (nav_filter.length) {
						$row.closest('.elementor-section').addClass('elementor-section-with-masonry');

						var cats = [];
						$row.children('.grid-item').each(function () {
							var each = $(this).children('.molla-elementor-column-wrap').data('creative-cat-title');
							if (cats.indexOf(each) == -1) {
								cats.push(each);
							}
						})

						nav_filter.html('<li class="nav-item active"><a href="#" class="nav-link" data-filter="*">All</a></li>');
						cats.map(function (cat) {
							var cat_slug = cat.replace(' ', '-').toLowerCase();
							nav_filter.append('<li class="nav-item"><a href="#" class="nav-link ' + cat_slug + '" data-filter=".' + cat_slug + '">' + cat + '</a></li>')
						})
					}

					$row.parent().prepend(get_creative_grid_item_css($row.closest('.elementor-section').data('id'), $row.data('creative-layout'), $row.data('creative-height'), $row.data('creative-height-ratio'), $row.data('creative-spacing')));
					if ($row.data('isotope')) {
						$row.removeAttr('data-current-break');
						$row.isotope('reloadItems');
						$row.isotope('layout');
					} else {
						Molla.layoutInit($row);
						Molla.isotopeFilter($row.siblings('.nav-filter'), $row);
					}
					$row.find('.owl-carousel').trigger('refresh.owl.carousel');
					$(window).trigger('resize');
				})

				function remove_carousel($wrap) {
					$wrap.isotope('destroy');
				}

				function remove_tab_content($wrap) {
					$wrap.removeClass('tab-pane');
					$wrap.removeAttr('role');
				}

				function remove_banner_content($wrap) {
					$wrap.removeClass('banner-content');
					$wrap.attr('class', $wrap.attr('class').replace(/ t-x-.* /, ''));
				}

				function remove_creative($wrap) {
					$wrap.siblings('style').remove();
					$wrap.children('.grid-space').remove();
					$wrap.removeAttr('data-creative-breaks');
					if ($wrap.data('isotope')) {
						$wrap.isotope('destroy');
					}
				}


				function get_creative_class($grid_item) {
					var ex_class = '';
					if (undefined != $grid_item) {
						ex_class = 'grid-item ';
						Object.entries($grid_item).forEach(function (item) {
							if (item[1]) {
								ex_class += item[0] + '-' + item[1] + ' ';
							}
						})
					}
					return ex_class;
				}

				function get_creative_grid_item_css($id, $layout, $height, $height_ratio, $sp) {
					if (undefined == $layout) {
						return;
					}
					var $deno = [];
					var $numer = [];
					var $gutter = $sp / 2;
					var $style = '';
					var $ws = { 'w': [], 'w-l': [], 'w-m': [], 'w-s': [] };
					var $hs = { 'h': [], 'h-l': [], 'h-m': [] };

					var global_gutter = Number(plugin.gutter_size);
					var container_width = Number(plugin.container_width);

					$style += '<style scope="">';

					$style += '.elementor-element-' + $id + '.elementor-section.elementor-section-boxed > .elementor-container{max-width:' + (container_width - global_gutter + $sp) + 'px; flex-basis:' + (container_width - global_gutter + $sp) + 'px}';
					$style += '.elementor-element-' + $id + '.elementor-section.elementor-section-full_width > .elementor-container{max-width:calc(100% + ' + $sp + 'px); flex-basis:calc(100% + ' + $sp + 'px)}';
					$style += '@media (max-width:' + (container_width + 19) + 'px) and (min-width: 480px) {' + '.elementor-element-' + $id + '.elementor-section.elementor-section-boxed > .elementor-container{ max-width: calc(100% - 40px + ' + $sp + 'px); flex-basis: calc(100% - 40px + ' + $sp + 'px); }}';
					$style += '@media (max-width: 480px) {' + '.elementor-element-' + $id + '.elementor-section.elementor-section-boxed > .elementor-container{ max-width: calc(100% - 20px + ' + $sp + 'px); flex-basis: calc(100% - 20px + ' + $sp + 'px); }}';
					$style += '.elementor-element-' + $id + ' .grid' + '{display: block}';
					$style += '.elementor-element-' + $id + ' .grid' + '>.grid-item{padding:' + $gutter + 'px}';
					$layout.map(function ($grid_item) {
						Object.entries($grid_item).forEach(function ($info) {
							if ('size' == $info[0]) {
								return;
							}

							var $num = $info[1].split('-');
							if (undefined != $num[1] && -1 == $deno.indexOf($num[1])) {
								$deno.push($num[1]);
							}
							if (-1 == $numer.indexOf($num[0])) {
								$numer.push($num[0]);
							}

							if (('w' == $info[0] || 'w-l' == $info[0] || 'w-m' == $info[0] || 'w-s' == $info[0]) && -1 == $ws[$info[0]].indexOf($info[1])) {
								$ws[$info[0]].push($info[1]);
							} else if (('h' == $info[0] || 'h-l' == $info[0] || 'h-m' == $info[0]) && -1 == $hs[$info[0]].indexOf($info[1])) {
								$hs[$info[0]].push($info[1]);
							}
						});
					});
					Object.entries($ws).forEach(function ($w) {
						if (!$w[1].length) {
							return;
						}

						if ('w-l' == $w[0]) {
							$style += '@media (max-width: 991px) {';
						} else if ('w-m' == $w[0]) {
							$style += '@media (max-width: 767px) {';
						} else if ('w-s' == $w[0]) {
							$style += '@media (max-width: 575px) {';
						}

						$w[1].map(function ($item) {
							var $opts = $item.split('-');
							var $width = (undefined == $opts[1] ? 100 : (100 * $opts[0] / $opts[1]).toFixed(4));
							$style += '.elementor-element-' + $id + ' .grid-item.' + $w[0] + '-' + $item + '{flex:0 0 ' + $width + '%;width:' + $width + '%}';
						})

						if ('w-l' == $w[0] || 'w-m' == $w[0] || 'w-s' == $w[0]) {
							$style += '}';
						}
					});
					Object.entries($hs).forEach(function ($h) {
						if (!$h[1].length) {
							return;
						}

						$h[1].map(function ($item) {
							var $opts = $item.split('-'), $value;
							if (undefined != $opts[1]) {
								$value = $height * $opts[0] / $opts[1];
							} else {
								$value = $height;
							}
							if ('h' == $h[0]) {
								$style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + $value.toFixed(2) + 'px}';
								$style += '@media (max-width: 767px) {';
								$style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + ($value * $height_ratio / 100).toFixed(2) + 'px}';
								$style += '}';
							} else if ('h-l' == $h[0]) {
								$style += '@media (max-width: 991px) {';
								$style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + $value.toFixed(2) + 'px}';
								$style += '}';
								$style += '@media (max-width: 767px) {';
								$style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + ($value * $height_ratio / 100).toFixed(2) + 'px}';
								$style += '}';
							} else if ('h-m' == $h[0]) {
								$style += '@media (max-width: 767px) {';
								$style += '.elementor-element-' + $id + ' .h-m-' + $item + '{height:' + ($value * $height_ratio / 100).toFixed(2) + 'px}';
								$style += '}';
							}
						})
					});
					var $lcm = 1;
					$deno.map(function ($value) {
						$lcm = $lcm * $value / gcd($lcm, $value);
					});
					var $gcd = $numer[0];
					$numer.map(function ($value) {
						$gcd = gcd($gcd, $value);
					});
					var $sizer = Math.floor(100 * $gcd / $lcm * 10000) / 10000;
					$style += '.elementor-element-' + $id + ' .grid' + '>.grid-space{flex: 0 0 ' + ($sizer < 0.01 ? 100 : $sizer) + '%;width:' + ($sizer < 0.01 ? 100 : $sizer) + '%}';
					$style += '</style>';
					return $style;
				}

				function gcd($a, $b) {
					while ($b) {
						var $r = $a % $b;
						$a = $b;
						$b = $r;
					}
					return $a;
				}

				$('.molla-block[data-el-class]').each(function () {
					$(this).addClass($(this).attr('data-el-class')).removeAttr('data-el-class');
				});
			}

			elementorFrontend.waypoint($('.elementor-widget-molla_banner .banner-elem, .elementor-widget-molla_banner .banner-content'), function () {
				var $this = $(this),
					settings = $(this).data('settings');

				if (!settings) {
					return;
				}

				var animation = settings._animation,
					delay = settings._animation_delay;

				setTimeout(function () {
					$this.removeClass('elementor-invisible').addClass('animated ' + animation);
				}, delay)

			});

			if (elementorFrontend.hooks) {
				mollaElementorInit();
			} else {
				elementorFrontend.on('components:init', mollaElementorInit);
			}
		}
	}
});
jQuery(document).ready(function ($) {
	'use strict';

	elementor.on('frontend:init', function () {
		// Custom CSS & Script
		var custom_css = elementor.settings.page.model.get('page_css'),
			custom_script = elementor.settings.page.model.get('page_script');
		if (typeof custom_css != 'undefined') {
			setTimeout(function () {
				elementorFrontend.hooks.doAction('refresh_dynamic_css', custom_css);
			}, 1000);
		}
		if (typeof custom_script != 'undefined') {
			setTimeout(function () {
				elementorFrontend.hooks.doAction('refresh_dynamic_script', custom_script);
			}, 1000);
		}

		// Add Studio Block Button
		var addSectionTmpl = document.getElementById('tmpl-elementor-add-section');

		if (addSectionTmpl) {
			addSectionTmpl.textContent = addSectionTmpl.textContent.replace(
				'<div class="elementor-add-section-area-button elementor-add-template-button',
				'<div class="elementor-add-section-area-button elementor-studio-section-button" ' +
				'onclick="window.parent.runStudio(this);" ' +
				'title="Molla Studio"><img class="molla-studio-icon" src="https://d-themes.com/wordpress/molla/wp-content/themes/molla/assets/images/logo-studio-mini.png" alt="Molla Studio"><i class="eicon-insert"></i></div>' +
				'<div class="elementor-add-section-area-button elementor-add-template-button');
		}

	});

	$(document.body).on('input', 'textarea[data-setting="page_css"]', function (e) {
		elementorFrontend.hooks.doAction('refresh_dynamic_css', $(this).val());
	})

	/* Template Display Conditions */
	var condition_template = '<li class="condition">' +
		('popup' == elementor_admin.builder_type ? '<div class="condition-wrap condition-input-wrap condition-popup-within"><input type="number" placeholder="' + elementor_admin.i18n.popup_description + '"></div>' : '') +
		('sidebar' == elementor_admin.builder_type ? '<div class="condition-wrap condition-sidebar-pos"><select><option value="left">' + elementor_admin.i18n.left + '</option><option value="right">' + elementor_admin.i18n.right + '</option></select></div><div class="condition-wrap condition-input-wrap condition-sidebar-width"><input type="number" placeholder="' + elementor_admin.i18n.width + '"></div>' : '') +
		'<a href="#" class="btn clone_condition" title="' + elementor_admin.i18n.clone_condition + '"><i class="fas fa-copy"></i></a><a href="#" class="btn remove_condition" title="' + elementor_admin.i18n.remove_condition + '"><i class="fas fa-times"></i></a></li>';

	elementor.on('preview:loaded', function () {
		var footerView = elementor.getPanelView().footer.currentView,
			behavior = footerView._behaviors[Object.keys(footerView.behaviors()).indexOf('saver')];
		var builders = ['header', 'footer', 'sidebar', 'popup', 'product_layout'];

		if (builders.indexOf(elementor_admin.builder_type) != -1) {
			// Make display condition modal active
			var document = elementor.documents.getCurrent(),
				postStatus = document.container.settings.get('post_status'),
				publishLabel = 'publish';
			// Create conditional modal
			var modalOptions = {
				className: 'elementor-templates-modal molla-builder-conditional-modal',
				closeButton: false,
				draggable: true,
				hide: {
					onOutsideClick: true,
					onEscKeyPress: true
				}
			};

			var template_name = elementor_admin.builder_type.replace('_', ' '),
				template_name_upper = template_name[0].toUpperCase() + template_name.slice(1);

			var conditionalModalOptions = {
				headerMessage: '<div class="elementor-templates-modal__header"><div class="elementor-templates-modal__header__logo-area"><div class="elementor-templates-modal__header__logo"><span class="elementor-templates-modal__header__logo__icon-wrapper e-logo-wrapper"><i class="eicon-save"></i></span><span class="elementor-templates-modal__header__logo__title">' + elementor_admin.i18n.modal_heading + '</span></div></div><div class="elementor-templates-modal__header__menu-area"></div><div class="elementor-templates-modal__header__items-area"><div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--normal elementor-templates-modal__header__item"><i class="eicon-close" aria-hidden="true" title="Close"></i><span class="elementor-screen-only">Close</span></div><div id="elementor-template-library-header-tools"></div></div></div>',
				message: '<img src="' + elementor_admin.theme_assets + '/assets/images/retina_logo.png' + '" alt="logo" width="105" ><div class="elementor-template-library-blank-title">' + elementor.translate(elementor_admin.i18n.conditions_title, [template_name_upper]) + '</div><div class="elementor-template-library-blank-message">' + elementor.translate(elementor_admin.i18n.conditions_description, [template_name]) + '</div>' + elementor_admin.conditions,
			}

			jQuery.extend(true, modalOptions, conditionalModalOptions);
			var modal = elementorCommon.dialogsManager.createWidget('lightbox', modalOptions);
			modal.getElements('message').append(modal.addElement('content'), modal.addElement('loading'));
			modal.addButton({
				name: 'action',
				text: elementor_admin.i18n.save_action,
				callback: function callback() {
					onSaveMollaBuilder();
				}
			});
			modal.getElements('action').addClass('elementor-button elementor-button-success');

			// Add display condition in footer menu
			footerView.ui.menuConditions = footerView.addSubMenuItem('saver-options', {
				before: 'save-template',
				name: 'conditions',
				icon: 'eicon-flow',
				title: 'Display Conditions',
				callback: function callback() {
					openConditionalModal(modal);
				}
			});
			behavior.ui.buttonPreview.tipsy('disable').html(jQuery('#tmpl-elementor-theme-builder-button-preview').html()).addClass('elementor-panel-footer-theme-builder-buttons-wrapper elementor-toggle-state');

			if (postStatus == 'draft') {
				$('#elementor-panel-saver-button-publish').html(publishLabel).removeClass('elementor-disabled');
				$('#elementor-panel-saver-button-save-options').removeClass('elementor-disabled');
				$('#elementor-panel-saver-button-publish').on('click', function (e, builder_condition_saved) {
					if (typeof builder_condition_saved == 'undefined' && elementor.documents.getCurrent().container.settings.get('post_status') == 'draft') {
						e.stopPropagation();
						openConditionalModal(modal);
					}
				});
			}

		}
	})

	function openConditionalModal(modal) {
		modal.show();

		$('.molla-builder-conditional-modal .elementor-templates-modal__header__close i').on('click', function () {
			modal.hide();
		})

		getConditionIds($('.ids-select'));
	}

	function onSaveMollaBuilder() {
		var conditions = [];

		$('.molla-builder-conditional-modal .condition').each(function () {
			var condition = {};

			condition.category = $(this).find('.condition-category select').val();

			if ($(this).find('.condition-subcategory').length) {
				condition.subcategory = $(this).find('.condition-subcategory select').val();

				if ($(this).find('.condition-ids').length) {
					condition.id = { id: $(this).find('.ids-select-toggle').attr('data-id'), title: $(this).find('.ids-select-toggle').text() };
				}
			}

			if ($(this).find('.condition-popup-within').length) {
				condition.popup_within = $(this).find('.condition-popup-within input').val();
			}

			if ($(this).find('.condition-sidebar-pos').length) {
				condition.sidebar_pos = $(this).find('.condition-sidebar-pos select').val();
				condition.sidebar_width = $(this).find('.condition-sidebar-width input').val();
				var width = parseFloat(condition.sidebar_width);
				if (width <= 0 || width >= 100) {
					$(this).find('.condition-sidebar-width input').val('');
				}
			}

			conditions.push(condition);
		})
		$.ajax({
			url: elementor_admin.ajax_url,
			type: 'post',
			dataType: 'json',
			data: {
				action: 'molla_save_conditions',
				nonce: elementor_admin.nonce,
				conditions: conditions,
				post_id: elementor_admin.post_id,
			},
			success: function (response) {
				if ('success' == response) {
					elementor_admin.builder_conditions = conditions;
				}
			}
		});

		$('#elementor-panel-saver-button-publish').trigger('click', ['builder_condition_saved']);
	}

	elementor.saver.on('after:save', function (data) {
		if (data.status == 'publish') {
			$('#elementor-panel-saver-button-publish').html(elementor.translate('update'));
		}
	})

	$('body')
		// Remove Condition
		.on('click', '.molla-builder-conditional-modal .remove_condition', function (e) {
			e.preventDefault();
			$(this).closest('.condition').remove();
		})
		// Clone Condition
		.on('click', '.molla-builder-conditional-modal .clone_condition', function (e) {
			e.preventDefault();

			var cur = $(this).closest('.condition');
			cur.after($(this).closest('.condition').clone());
			var cloned = cur.next();
			cloned.find('.condition-category select').val(cur.find('.condition-category select').val());
			cloned.find('.condition-subcategory select').val(cur.find('.condition-subcategory select').val());
			getConditionIds(cloned.find('.condition-subcategory select').trigger('change'));
		})
		// Add Condition
		.on('click', '#molla-add-condition', function (e) {
			$(condition_template).prepend($(getConditionSelectBox(false))).appendTo($(this).siblings('.conditions'));
			if (elementor_admin.builder_type == 'product_layout') {
				$('.molla-builder-conditional-modal .condition-subcategory select').trigger('change');
			}
		})
		.on('change', '.molla-builder-conditional-modal .condition-category select', function () {
			var subcategory = getConditionSelectBox(true, $(this).val()),
				$condition = $(this).closest('.condition');

			$condition.find('.condition-ids').remove();
			if (subcategory) {
				if ($condition.find('.condition-subcategory').length) {
					$condition.find('.condition-subcategory').replaceWith($(subcategory));
				} else {
					$condition.find('.condition-category').after($(subcategory));
				}
			} else {
				$condition.find('.condition-subcategory, .condition-ids').remove();
			}
		})
		.on('change', '.molla-builder-conditional-modal .condition-subcategory select', function () {
			var $condition = $(this).closest('.condition'),
				ids = getConditionSelectBox(true, $condition.find('.condition-category select').val(), $(this).val());

			if (ids) {
				if ($condition.find('.condition-ids').length) {
					$condition.find('.condition-ids').replaceWith($(ids));
				} else {
					$condition.find('.condition-subcategory').after($(ids));
				}

				getConditionIds($condition.find('.ids-select'));
			} else {
				$condition.find('.condition-ids').remove();
			}
		})
		// Select Condition Ids
		.on('click', '.molla-builder-conditional-modal .ids-select-toggle', function () {
			var $dropdown = $(this).siblings('.dropdown-box');
			$dropdown.toggleClass('show');

			if ($dropdown.hasClass('show')) {
				$dropdown.children('.form-control').focus();
			}
		})
		.on('click', '.molla-builder-conditional-modal', function (e) {
			$(this).find('.ids-select .dropdown-box').removeClass('show');
		})
		.on('click', '.molla-builder-conditional-modal .ids-select', function (e) {
			e.stopPropagation();
		})

	function getConditionPostType(category) {
		if ('entire' == category) {
			return 'all';
		} else if (0 === category.indexOf('post') || 'category' == category) {
			return 'post';
		} else if (0 === category.indexOf('product')) {
			return 'product';
		} else if ('page' == category) {
			return 'page';
		} else {
			return category.replace(/_archive$|_single$/, '');
		}
	}

	function hasSubOption(subcategory) {
		if (-1 != subcategory.indexOf('_archive') || 'shop' == subcategory || 'front' == subcategory || 'error' == subcategory) {
			return false;
		}
		return true;
	}

	function getConditionSelectBox(level, category, subcategory) {
		var html = '',
			post_type = (undefined != category ? (undefined != subcategory ? getConditionPostType(subcategory) : getConditionPostType(category)) : false);

		if (elementor_admin.builder_type == 'product_layout') {
			category = 'single';
			post_type = 'product';
		}

		if (!level && elementor_admin.builder_type != 'product_layout') {
			post_type = category;
			html += '<div class="condition-wrap condition-category"><select>';

			var types = Object.keys(elementor_admin.condition_network);

			types.forEach(function (type, typeIdx) {
				html += '<option value="' + type + '">' + elementor_admin.condition_network[type]['name'] + '</option>';
			});

			html += '</select></div>';

			return html;
		}

		if ((!level && elementor_admin.builder_type != 'product_layout') || !Object.keys(elementor_admin.condition_network[category]['subcats']).length) {
			return html;
		} else if (undefined == subcategory) {
			html = '<div class="condition-wrap condition-subcategory"><select>';

			var subcats = Object.keys(elementor_admin.condition_network[category]['subcats']);

			subcats.forEach(function (value, idx) {
				if (typeof elementor_admin.condition_network[category]['subcats'][value] == 'object') {
					var sub_post_type = elementor_admin.condition_network[category]['subcats'][value],
						label = '';

					label = value[0].toUpperCase() + value.slice(1);
					if (category == 'archive') {
						label += elementor_admin.i18n.archive_label;
					}
					html += '<optgroup label=' + label + '>';
					label = Object.keys(sub_post_type);
					Object.keys(sub_post_type).forEach(function (value, idx) {
						html += '<option value="' + value + '">' + sub_post_type[value] + '</option>';
					});
					html += '</optgroup>';
				} else {
					html += '<option value="' + value + '">' + elementor_admin.condition_network[category]['subcats'][value] + '</option>';
				}
			});

			html += '</select></div>';

			return html;
		}
		if (subcategory) {
			var id = 0;
			if (hasSubOption(subcategory)) {
				var option = $('.molla-builder-conditional-modal .condition-subcategory').find('[value="' + subcategory + '"]');
				html = '<div class="condition-wrap condition-ids"><div class="ids-select"><span class="ids-select-toggle" data-id="' + id + '"><mark>' + elementor_admin.i18n.all + '</mark></span><div class="dropdown-box"><input type="hidden" name="post_type" value="' + post_type + '"><input type="hidden" name="taxonomy" value="' + subcategory + '"><input type="search" class="form-control" name="s" required="" autocomplete="off"><div class="live-search-list"></div></div>';
				html += '</div></div>';
			}
		}

		return html;
	}

	function getConditionIds($selector) {
		if (!$.fn.devbridgeAutocomplete) {
			return;
		}
		if ('undefined' == typeof $selector) {
			$selector = $('.search-wrapper');
		} else {
			$selector = $selector;
		}

		$selector.each(function () {
			var $this = $(this),
				appendTo = $this.find('.live-search-list'),
				postType = $this.find('input[name="post_type"]').val(),
				taxonomy = $this.find('input[name="taxonomy"]').val(),
				serviceUrl = elementor_admin.ajax_url + '?action=molla_template_ids_search&nonce=' +
					elementor_admin.nonce + (postType ? '&post_type=' + postType : '') + (taxonomy ? '&taxonomy=' + taxonomy : '');

			$this.find('input[type="search"]').each(function () {
				if ($(this).siblings('.live-search-list').find('.autocomplete-suggestions').length) {
					return;
				}

				$(this).on('keydown', function (e) {
					if ("Enter" == e.key) {
						$this.find('.ids-select-toggle').attr('data-id', 0).html('<mark>' + elementor_admin.i18n.all + '</mark>');
						$this.find('.dropdown-box').removeClass('show');
					}
				})
				$(this).devbridgeAutocomplete({
					minChars: 3,
					appendTo: appendTo,
					triggerSelectOnValidInput: false,
					serviceUrl: serviceUrl,
					onSearchStart: function (params) {
					},
					onSelect: function (item) {
						if (item.id != -1) {
							$this.find('.ids-select-toggle').attr('data-id', item.id).html('<mark>' + item.title + '</mark>').trigger('click');
						}
					},
					onSearchComplete: function (q, suggestions) {
						if (!suggestions.length) {
							appendTo.children().eq(0).hide();
						}
					},
					beforeRender: function (container) {
						$(container).removeAttr('style');
					},
					formatResult: function (item, currentValue) {
						return '<span class="ids-result" data-id="' + item.id + '">' + item.title + '</span>';
					}
				});
			});
		});
	}
});
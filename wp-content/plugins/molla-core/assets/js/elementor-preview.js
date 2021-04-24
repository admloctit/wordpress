jQuery(document).ready(function ($) {
    'use strict';
    if (typeof elementorFrontend != 'undefined') {
        // popup condition
        if ($('body').hasClass('popup-template-default')) {
            var $edit_area = $('[data-elementor-id]'),
                id = $edit_area.data('elementor-id');
            $edit_area.parent().prepend('<div class="mfp-bg mfp-molla-lightbox-' + id + ' mfp-ready"></div>');
            $edit_area.wrap('<div class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-molla-lightbox mfp-molla-lightbox-' + id + ' mfp-ready" tabindex="-1" style="overflow: hidden auto;"><div class="mfp-container mfp-inline-holder"><div class="mfp-content"><div id="molla-lightbox-' + id + '" class="molla-lightbox-container mfp-fade"><div class="molla-lightbox-content"></div></div></div></div></div>')
        }
    }
});
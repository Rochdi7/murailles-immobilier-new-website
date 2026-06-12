/**
 * Murailles Immobilier Admin – Tab switching, media uploader, map preview, validation
 */
(function($) {
    'use strict';

    $(document).ready(function() {

        // ── Tab Navigation ──
        $('.murailles-tabs-nav a').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');

            $('.murailles-tabs-nav a').removeClass('active');
            $(this).addClass('active');

            $('.murailles-tab-panel').removeClass('active');
            $(target).addClass('active');
        });

        // ── Gallery Uploader ──
        var mediaFrame;

        $(document).on('click', '#murailles-add-gallery', function(e) {
            e.preventDefault();

            if (mediaFrame) {
                mediaFrame.open();
                return;
            }

            mediaFrame = wp.media({
                title: 'Select Property Images',
                button: { text: 'Add to Gallery' },
                multiple: true
            });

            mediaFrame.on('select', function() {
                var attachments = mediaFrame.state().get('selection').toJSON();
                var container = $('.murailles-gallery-container');
                var input = $('#_property_gallery_ids');
                var ids = input.val() ? input.val().split(',') : [];

                attachments.forEach(function(att) {
                    if (ids.indexOf(String(att.id)) === -1) {
                        ids.push(att.id);
                        var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                        container.append(
                            '<div class="murailles-gallery-item" data-id="' + att.id + '">' +
                                '<img src="' + thumb + '" />' +
                                '<button type="button" class="remove-image">&times;</button>' +
                            '</div>'
                        );
                    }
                });

                input.val(ids.join(','));
            });

            mediaFrame.open();
        });

        // Remove gallery image
        $(document).on('click', '.murailles-gallery-item .remove-image', function() {
            var item = $(this).closest('.murailles-gallery-item');
            var id = item.data('id');
            var input = $('#_property_gallery_ids');
            var ids = input.val().split(',').filter(function(v) {
                return v != id;
            });
            input.val(ids.join(','));
            item.remove();
        });

        // ── Map Embed Preview (live update on paste/change) ──
        $('#_property_map_embed').on('input change paste', function() {
            var url = $(this).val().trim();
            if (url && url.indexOf('google.com/maps') !== -1) {
                $('#murailles-map-preview').attr('src', url).show();
                $('#murailles-map-empty').hide();
            } else if (!url) {
                $('#murailles-map-preview').hide();
                $('#murailles-map-empty').show();
            }
        });

        // ── Highlight tab with errors on submit ──
        $('form#post').on('submit', function() {
            var firstInvalid = null;

            $('.murailles-tab-panel').each(function() {
                var panel = $(this);
                var tabId = '#' + panel.attr('id');
                var hasInvalid = panel.find(':invalid').length > 0;

                // Mark tab with red dot if it has invalid fields
                var tabLink = $('.murailles-tabs-nav a[href="' + tabId + '"]');
                tabLink.find('.murailles-error-dot').remove();
                if (hasInvalid) {
                    tabLink.append('<span class="murailles-error-dot" style="display:inline-block;width:8px;height:8px;background:#d63638;border-radius:50%;margin-left:6px;vertical-align:middle;"></span>');
                    if (!firstInvalid) {
                        firstInvalid = tabId;
                    }
                }
            });

            // Switch to the first tab with errors
            if (firstInvalid) {
                $('.murailles-tabs-nav a').removeClass('active');
                $('.murailles-tabs-nav a[href="' + firstInvalid + '"]').addClass('active');
                $('.murailles-tab-panel').removeClass('active');
                $(firstInvalid).addClass('active');
            }
        });
    });

})(jQuery);

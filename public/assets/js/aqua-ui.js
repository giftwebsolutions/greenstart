/*
 * GA layout interactions (jQuery)
 * Drawer · expandable search · category dropdown · sticky header
 */
(function ($) {
    'use strict';

    $(function () {
        var $body = $('body');

        /* ---- Mobile drawer ---- */
        function openDrawer() { $body.addClass('ga-drawer-open'); $('#gaDrawer').attr('aria-hidden', 'false'); }
        function closeDrawer() { $body.removeClass('ga-drawer-open'); $('#gaDrawer').attr('aria-hidden', 'true'); }

        $(document).on('click', '[data-ga-drawer-open]', function (e) { e.preventDefault(); openDrawer(); });
        $(document).on('click', '[data-ga-drawer-close]', function (e) { e.preventDefault(); closeDrawer(); });
        $(document).on('keyup', function (e) { if (e.key === 'Escape') closeDrawer(); });

        /* ---- Expandable mobile search ---- */
        $(document).on('click', '[data-ga-search-toggle]', function (e) {
            e.preventDefault();
            var $area = $('#gaSearchMobile').toggleClass('is-open');
            if ($area.hasClass('is-open')) {
                $('html, body').animate({ scrollTop: 0 }, 200);
                $area.find('input[name="q"]').trigger('focus');
            }
        });

        /* ---- Desktop "Browse Categories" dropdown ---- */
        var $cats = $('[data-ga-cats-wrap]');
        $(document).on('click', '[data-ga-cats]', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var open = $cats.toggleClass('is-open').hasClass('is-open');
            $(this).attr('aria-expanded', open ? 'true' : 'false');
        });
        $(document).on('click', function (e) {
            if ($cats.length && !$(e.target).closest('[data-ga-cats-wrap]').length) {
                $cats.removeClass('is-open');
                $cats.find('[data-ga-cats]').attr('aria-expanded', 'false');
            }
        });

        /* ---- Sticky header shadow on scroll ---- */
        var $header = $('#gaHeader');
        function onScroll() { $header.toggleClass('is-stuck', $(window).scrollTop() > 8); }
        $(window).on('scroll', onScroll);
        onScroll();
    });
})(jQuery);

$(document).ready(function () {

    const $nav = $('.sidebar-wrapper');
    const $header = $('.page-header');
    const $pageWrapper = $('.page-wrapper');
    const $window = $(window);

    /* ===============================
       PAGE WRAPPER MODE
    =============================== */

    let wrapperClass = localStorage.getItem('page-wrapper');

    if (wrapperClass) {
        $pageWrapper.addClass(wrapperClass);
    } else {
        $pageWrapper.addClass('compact-wrapper');
    }


    /* ===============================
       MOBILE NAV OPEN / CLOSE
    =============================== */

    $(".toggle-nav").click(function () {
        $('#sidebar-links .nav-menu').css("left", "0px");
    });

    $(".mobile-back").click(function () {
        $('#sidebar-links .nav-menu').css("left", "-410px");
    });


    /* ===============================
       SIDEBAR ACCORDION
    =============================== */

    function initSidebarMenu() {

        $('.sidebar-submenu, .menu-content, .submenu-content').hide();

        $('.sidebar-title').off('click').on('click', function () {

            let $this = $(this);

            $('.sidebar-title').removeClass('active');
            $('.sidebar-submenu').slideUp(200);

            if ($this.next().is(':hidden')) {
                $this.addClass('active');
                $this.next().slideDown(200);
            }

        });

        $('.submenu-title').off('click').on('click', function () {

            let $this = $(this);

            $('.submenu-title').removeClass('active');
            $('.submenu-content').slideUp(200);

            if ($this.next().is(':hidden')) {
                $this.addClass('active');
                $this.next().slideDown(200);
            }

        });

    }

    initSidebarMenu();


    /* ===============================
       SIDEBAR TOGGLE BUTTON
    =============================== */

    $('.toggle-sidebar').on('click', function () {
        $nav.toggleClass('close_icon');
        $header.toggleClass('close_icon');    


        
        handleOverlay();
    });


    /* ===============================
       OVERLAY HANDLER
    =============================== */

    function handleOverlay() {

        let $overlay = $(".bg-overlay");

        if ($window.width() <= 991 && !$nav.hasClass('close_icon')) {

            if ($overlay.length === 0) {
                $('<div class="bg-overlay active"></div>').appendTo('body');
            }

        } else {
            $overlay.remove();
        }

    }

    $(document).on("click", ".bg-overlay", function () {
        $nav.addClass('close_icon');
        $header.addClass('close_icon');
        $(this).remove();
    });


    /* ===============================
       RESPONSIVE SIDEBAR
    =============================== */

    function handleResponsiveSidebar() {

        if ($window.width() <= 991) {
            $nav.addClass("close_icon");
            $header.addClass("close_icon");
        } else {
            $nav.removeClass("close_icon");
            $header.removeClass("close_icon");
        }

    }

    handleResponsiveSidebar();
    $window.resize(handleResponsiveSidebar);


    /* ===============================
       ACTIVE MENU DETECTION
    =============================== */

    if ($pageWrapper.hasClass('compact-wrapper')) {

        let current = window.location.pathname;

        $(".sidebar-wrapper nav ul li a").each(function () {

            let link = $(this).attr("href");

            if (!link) return;

            if (current.indexOf(link) !== -1) {

                $(this).addClass('active');

                $(this)
                    .closest('ul')
                    .show()
                    .prev('.sidebar-title')
                    .addClass('active');

                return false;
            }

        });

    }


    /* ===============================
       HORIZONTAL ARROWS (optional)
    =============================== */

    const view = $("#sidebar-menu");
    const move = 500;

    $("#right-arrow").click(function () {
        view.animate({ marginLeft: "-=" + move }, 300);
    });

    $("#left-arrow").click(function () {
        view.animate({ marginLeft: "+=" + move }, 300);
    });


    /* ===============================
       HEADER MENUS
    =============================== */

    $('.left-header .mega-menu .nav-link').click(function (e) {
        e.stopPropagation();
        $(this).parent().children('.mega-menu-container').toggleClass("show");
    });

    $('.left-header .level-menu .nav-link').click(function (e) {
        e.stopPropagation();
        $(this).parent().children('.header-level-menu').toggleClass("show");
    });

    $(document).click(function () {
        $('.mega-menu-container, .header-level-menu').removeClass("show");
    });


    /* ===============================
       MOBILE HEADER LINKS
    =============================== */

    $('.left-header .link-section > div').click(function () {

        if ($window.width() <= 1199) {

            $(".left-header .link-section > div").removeClass("active");

            $(this).toggleClass("active");

            $(this)
                .parent()
                .children('ul')
                .slideToggle();

        }

    });


    /* ===============================
       SIMPLEBAR AUTO SCROLL
    =============================== */

    if (
        $('.simplebar-wrapper .simplebar-content-wrapper').length &&
        $pageWrapper.hasClass('compact-wrapper')
    ) {

        let $container = $('.simplebar-wrapper .simplebar-content-wrapper');
        let $active = $container.find('a.active');

        if ($active.length) {
            $container.animate({
                scrollTop: $active.offset().top - 200
            }, 600);
        }

    }

});
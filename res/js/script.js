/**
 * Author     : Hendel
 */
var $logo_sequence;

$(function () {
    /**
     * Botón "Ir Arriba"
     */
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    $('#back-to-top').tooltip('show');

    /**
     * Objeto canvas para logo animado
     */
    $logo_sequence = $('#logo_sequence');
    $logo_sequence.spriteAnimate({
        frameWidth: 64,
        frameHeight: 64,
        numberOfFrames: 6,
        imgSrc: "/res/img/AddDate_sequence_64px.png",
        fps: 10,
        loop: true,
        onReady: function () {
            $logo_sequence.spriteAnimate('pause');
            $logo_sequence.spriteAnimate('goTo', 3);
        }
    });
    $("#home_nav_link").hover(function () {
        $logo_sequence.spriteAnimate('play');
    }, function () {
        $logo_sequence.spriteAnimate('pause');
        $logo_sequence.spriteAnimate('goTo', 3);
    });

    /*
     * 
     */
    $('#right-menu-toggle').hover(function () {
        $(this).find('i').toggleClass('glyphicon-menu-hamburger').toggleClass('glyphicon-option-horizontal');
    });

    $(".clickable-row").click(function () {
        location = $(this).data("href");
    });

    /**
     * 
     */
    $('.dropdown').on('show.bs.dropdown', function (e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });
    $('.dropdown').on('hide.bs.dropdown', function (e) {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });

    /** API
     * $logo_sequence.spriteAnimate('play');
     * $logo_sequence.spriteAnimate('pause');
     * $logo_sequence.spriteAnimate('restart');
     * $logo_sequence.spriteAnimate('goTo', 3);
     */
});

$(document).on({
    ajaxStart: function () {
        $logo_sequence.spriteAnimate('goTo', 1);
        $logo_sequence.spriteAnimate('play');
    },
    ajaxStop: function () {
        $logo_sequence.spriteAnimate('pause');
        $logo_sequence.spriteAnimate('goTo', 3);
    }
});

$(document).ready(function () {
    /**
     * Boostrap Tooltip
     */
    $('[data-toggle="tooltip"]').tooltip();
});
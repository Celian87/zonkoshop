/**
 * Created by Michel on 05/02/2015.
 */

$(document).ready(function () {

  $(window).scroll(function () {
    console.log("AAAWWW");
    if ($(this).scrollTop() > 100) {
      $('.scrollToTop').fadeIn();
    } else {
      $('.scrollToTop').fadeOut();
    }
  });

  $('body').mouseover(function () {
    $('.edit_live_cx').css('display', 'block');
  }).mouseleave(function () {
    $('.edit_live_cx').css('display', 'none');
  });

  //breadcrumb
  $(window).resize(function () {
    ellipses1 = $("#breadcrumb:nth-child(2)");
    if ($("#breadcrumb a:hidden").length > 0) {
      ellipses1.show()
    } else {
      ellipses1.hide()
    }
  });

  $('.owl-carousel').owlCarousel({
    items: 1,
    dots: true,
    lazyLoad: true,
    dotsEach: true,
    nav: false,
    autoplay: true,
    loop: true,
    autoplayTimeout: 3000,
    animateOut: 'fadeOut',
    navText: [
      "<i class='fa fa-chevron-left'></i>",
      "<i class='fa fa-chevron-right'></i>"
    ]
  });

  $(".applicazione").change(function () {
    $(".specializzazione").prop('disabled', false);
    $(".specializzazione").css('cursor', "auto");
  });
  // Initialize Slidebars
  var controller = new slidebars();
  controller.init();

  // Toggle Slidebars
  $('.slidebar-left-toggle').on('click', function (event) {
    // Stop default action and bubbling
    event.stopPropagation();
    event.preventDefault();

    // Toggle the Slidebar with id 'slidebar-left'
    controller.toggle('slidebar-left');
  });


  //Check to see if the window is top if not then display button


  //Click event to scroll to top
  $('.scrollToTop').click(function () {
    $('html, body').animate({scrollTop: 0}, 800);
    return false;
  });


  //accordion
  $('.toggle').click(function (e) {
    //e.preventDefault();

    var $this = $(this);

    if ($this.next().hasClass('show')) {
      $this.next().removeClass('show');
      $this.next().addClass('hide');
      $this.next().slideUp(350);
      $this.find('span').removeClass("down");

    } else {
      $this.parent().parent().find('li .inner').removeClass('show');
      $this.parent().parent().find('li .inner').addClass('hide');
      $this.parent().parent().find('li .inner').slideUp(350);
      $this.parent().parent().find('li a span').removeClass("down");
      $('.fa-chevron-right').removeClass("down");

      $this.next().toggleClass('show');
      $this.find('span').toggleClass("down");
      //$this.next().animate({height: 'toggle'});
    }

  });

  //immagini ingrandibili
  $('.cliccabile').css("cursor", "pointer").click(function () {
    $(this).wrap('<a href="' + $(this).attr("src") + '" data-lightbox="image-1" />');
    $(this).parent('a').trigger('click');
    $(this).unwrap();
  });


  //hamburger
  $('#hamburger').click(function () {
    $(this).toggleClass('open');
  });


  $('.table-prodotto tr').eq(1).css('background-color', '#008c47');
  $('.table-prodotto tr').eq(1).css('color', 'white');

  function search() {
    var id = $('#specializzazione').val();
    window.location.replace("http://test4.mediaticaweb.it/it/advance-search?search=" + id);

  }

  $('#menu_orizzontale li.dropdown').hover(function() {
    alert();
    //$(this).find('.dropdown-menu').show();
  });

//NEWS RECOMMENDED PAGES
  $(".recommended-pages").appendTo("body"); //sposto il box al di fuori del contenuto

  // $(window).scroll(function () {
  //   console.log("AA");
  //   if ($(window).scrollTop() > 600) {
  //     $('.recommended-pages').css("left", "100px");
  //   } else {
  //     $('.recommended-pages').css("left", "-400px");
  //   }
  // });

    $('.rp-header').click(function () {
      $('.recommended-pages').toggle(function () {
        var apri_news = $('.recommended-pages').css('bottom');
        if (apri_news < '0px') { // TENDINA APERTA
          var altezza_rec = $('.recommended-pages').height();
          $('.rp-header').animate({bottom: altezza_rec},490);
          $('.recommended-pages').animate({bottom: 0},100);
        }else{
          $('.rp-header').animate({bottom: 0},10);
          $('.recommended-pages').animate({bottom: -300},10);
        }

      });
    });

  $('.rp-close').click(function () {
    $('.recommended-pages').hide();
  });

  //window.addEventListener('scroll', function(){ $(window).scrollTop() }, true)




});



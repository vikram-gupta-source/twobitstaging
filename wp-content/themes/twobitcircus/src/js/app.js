// Custom Scripts
import "bootstrap";
import "lazyloadxt/src/jquery.lazyloadxt";
import "lazyloadxt/src/jquery.lazyloadxt.bg";
import "waypoints/lib/jquery.waypoints";
import $ from "jquery";
import "slick-carousel";
import imagesLoaded from "imagesloaded";
import parallax from "./jquery.parallax.js";
import Isotope from "isotope-layout/dist/isotope.pkgd.min";
import {
  Calendar
} from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import ScrollMagic from "scrollmagic/scrollmagic/minified/ScrollMagic.min.js";
import addIndicators from "scrollmagic/scrollmagic/minified/plugins/debug.addIndicators.min.js";

$(function() {
  //Wait for Preload Sprite before Starting
  var loadedItems = 0,
    $headerElem = $("#main-nav"),
    $articleElem = $("article.page.type-page"),
    scrollHeightTop = 800,
    scrollHide = 300,
    handleWaypoints = function() {
      if ($(".inview").length) {
        $(".inview").each(function() {
          let delay = $(this).data("offset") ? $(this).data("offset") : "90%";
          let easeType = $(this).data("ease") ?
            $(this).data("ease") :
            "fadeInUp";
          let waypoint = new Waypoint({
            element: this,
            handler: function(direction) {
              if (direction == "down" && !$(this.element).hasClass(easeType)) {
                $(this.element).addClass(easeType);
              } else {
                //$(this.element).removeClass(easeType);
              }
            },
            offset: delay
          });
        });
      }
    };
  handleWaypoints();
  $headerElem.addClass("start");
  $articleElem.addClass("start");
  // Scroll Handler
  if ($("#arrow-cta").length && $(window).height() < scrollHeightTop) {
    $("#arrow-cta").addClass("show");
  }
  // Handle resize
  let clearInt = 0;
  var navBarHt = $("#main-nav").height();
  $("body").css({
    "padding-top": navBarHt + "px"
  });
  $(window).on("resize", function() {
    clearTimeout(clearInt);
    clearInt = setTimeout(function() {
      navBarHt = $("#main-nav").height();
      $("body").css({
        "padding-top": navBarHt + "px"
      });
      $(".slick-days .slick-slide.slick-current").trigger("click");
    }, 500);
  });
  var prevScrollpos = window.pageYOffset;
  $(window)
    .scroll(function() {
      let currentScrollPos = window.pageYOffset;
      if ($("#arrow-cta").length) {
        if ($(this).scrollTop() >= scrollHide) {
          $("#arrow-cta").removeClass("show");
        } else {
          if ($(window).height() < scrollHeightTop) {
            $("#arrow-cta").addClass("show");
          }
        }
      }
      if ((prevScrollpos > currentScrollPos) || (currentScrollPos == 0) || currentScrollPos < (navBarHt + 25)) {
        $("#main-nav").css({
          top: 0
        });
      } else {
        $("#main-nav").css({
          top: "-" + navBarHt + "px"
        });
      }
      prevScrollpos = currentScrollPos;
    });

  // Handle Slider Slick
  var slick_calendar_settings = {
    dots: true,
    infinite: false,
    speed: 600,
    arrows: true,
    slidesToShow: 4,
    slidesToScroll: 4,
    responsive: [{
        breakpoint: 1199,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 767,
        settings: {
          dots: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  };
  var slick_center_settings = {
    dots: true,
    centerMode: true,
    slidesToShow: 3,
    arrows: false,
    variableWidth: true,
    responsive: [{
      breakpoint: 767,
      settings: {
        dots: true,
        arrows: false,
        centerMode: false,
        variableWidth: false,
        adaptiveHeight: true,
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  };
  var slick_event_settings = {
    dots: true,
    infinite: false,
    speed: 600,
    arrows: false,
    slidesToShow: 4,
    slidesToScroll: 4,
    adaptiveHeight: true,
    responsive: [{
        breakpoint: 1199,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 767,
        settings: {
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  };
  var slick_filter_settings = {
    dots: false,
    infinite: false,
    speed: 600,
    arrows: false,
    slidesToShow: 7,
    slidesToScroll: 1,
    responsive: [{
        breakpoint: 1199,
        settings: {
          arrows: true,
          slidesToShow: 6
        }
      },
      {
        breakpoint: 991,
        settings: {
          arrows: true,
          slidesToShow: 4
        }
      },
      {
        breakpoint: 767,
        settings: {
          arrows: true,
          slidesToShow: 3
        }
      },
      {
        breakpoint: 500,
        settings: {
          arrows: true,
          slidesToShow: 2
        }
      }
    ]
  };
  var slick_attractions_settings = {
    infinite: false,
    dots: false,
    swipe: false,
    touchMove: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    adaptiveHeight: true,
    fade: true
  };
  var slick_shows_settings = {
    dots: false,
    swipe: false,
    touchMove: false,
    slidesToShow: 1,
    arrows: true,
    adaptiveHeight: true,
    fade: true
  };
  var slick_feed_settings = {
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    responsive: [{
        breakpoint: 1199,
        settings: {
          dots: true,
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 530,
        settings: {
          dots: true,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  };
  var slick_social_settings = {
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 5,
    arrows: false,
    dots: true,
    responsive: [{
        breakpoint: 1199,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 580,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  };
  var slick_days_settings = {
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: true,
    asNavFor: ".slick-times",
    focusOnSelect: true
  };
  var slick_times_settings = {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    adaptiveHeight: true,
    arrows: false,
    swipe: false,
    touchMove: false,
    fade: true
  };
  var slick_media_nav_settings = {
    infinite: false,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    asNavFor: ".slick-media",
    focusOnSelect: true,
    responsive: [{
        breakpoint: 1199,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3
        }
      }
    ]
  };
  var slick_media_settings = {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    asNavFor: ".slick-media-nav"
  };

  imagesLoaded(
    "main", {
      background: true
    },
    function() {
      if ($(".slick-filter").length) {
        $(".slick-filter").slick(slick_filter_settings);
      }
      if ($(".slick-center-init").length) {
        $(".slick-center-init").slick(slick_center_settings);
      }
      if ($(".slick-event").length) {
        $(".slick-event").slick(slick_event_settings);
      }
      if ($(".slick-calendar").length) {
        $(".slick-calendar").slick(slick_calendar_settings);
      }
      if ($(".slick-social").length) {
        $(".slick-social")
          .slick(slick_social_settings)
          .on("beforeChange", function(event, slick, currentSlide, nextSlide) {
            var srcid = $(slick.$slides.get(nextSlide))
              .find(".embed-data")
              .data("src");
            if (srcid) {
              $(slick.$slides.get(nextSlide))
                .find(".embed-data")
                .append(
                  '<iframe class="embed-responsive-item" src="' +
                  srcid +
                  '"></iframe>'
                );
            }
          });
        var firstEmbed = $(".youtube .grid-feed:first .embed-data").data("src");
        $(".youtube .grid-feed:first .embed-data").append(
          '<iframe class="embed-responsive-item" src="' +
          firstEmbed +
          '"></iframe>'
        );
      }

      // Handle all Attraction Events
      if ($("#attractions-block").length) {
        var allowStart = false;
        $('[data-tool-toggle="tooltip"]').tooltip({
          html: true
        });
        $(".attractions-slick").slick(slick_attractions_settings);
        $(".slick-shows")
          .slick(slick_shows_settings)
          .on("afterChange", function(ev, slick, cur) {
            if ($(slick.$slides.get(cur)).find(".slick-days").length) {
              $(slick.$slides.get(cur))
                .find(
                  ".slick-days > .slick-list > .slick-track > .slick-slide:first-child"
                )
                .trigger("click");
            }
          });
        $(".slick-media").slick(slick_media_settings);
        $(".slick-media-nav").slick(slick_media_nav_settings);
        $(".slick-days").slick(slick_days_settings);
        $(".slick-times")
          .slick(slick_times_settings)
          .on("beforeChange", function(ev, slick, cur, next) {
            $(".available-dates .cta-btn").removeClass("show");
          });
        // Append to Filter show
        $("#filters .dropdown-menu .dropdown-item").on("click", function(e) {
          e.preventDefault(e);
          if (!$(this).hasClass("active")) {
            let slug = $(this).attr("aria-controls");
            if ($("#" + slug).length) {
              $(this).parent().find('.dropdown-item').removeClass("active");
              $(this).addClass("active");
              let index = $("#" + slug)
                .parents(".slick-slide").data("slick-index");
              $("#" + slug).parents(".slick-shows").slick("slickGoTo", index);
            }
          }
        });
        // Append to Filter show
        $("#filters .nav-item .nav-link").on("click", function(e) {
          e.preventDefault(e);
          $('[data-tool-toggle="tooltip"]').tooltip("hide");
          if (!$(this).hasClass("active")) {
            if (!$(this).parent().find(".dropdown-menu .dropdown-item").hasClass("active")) {
              $(this)
                .parent()
                .find(".dropdown-menu .dropdown-item:first-child")
                .addClass("active");
            }
            $("#filters .nav-link").removeClass("active");
            $(this).addClass("active");
            let slug = $(this).attr("aria-controls");
            if ($("#cat-" + slug).length) {
              let index = $("#cat-" + slug)
                .parents(".slick-slide")
                .data("slick-index");
              $(".attractions-slick").slick("slickGoTo", index);
              $("#cat-" + slug)
                .find(".slick-slide:first-child")
                .addClass(".slick-current .slick-active");
              $("#cat-" + slug)
                .find(
                  ".slick-days > .slick-list > .slick-track > .slick-slide:first-child"
                )
                .trigger("click");
            }
          }
        });
        //Extend Days slick
        $(".slick-days .slick-slide").on("click", function(evt) {
          var $_this = $(this);
          var timer = 0;
          timer = setTimeout(function() {
            clearTimeout(timer);
            let ht = $_this
              .parents(".slick-shows")
              .find("> .slick-list > .slick-track")
              .outerHeight();
            let newHt = parseInt(ht + 40) + "px";
            $_this
              .parents(".slick-shows")
              .find("> .slick-list")
              .height(newHt);
            $(".attractions-slick > .slick-list").height(newHt);
          }, 400);
        });

        // Handle Model all times
        $(".open-times-modal").on("click", function(evt) {
          evt.preventDefault();
          $("#modal-showtimes .modal-body").empty();
          $(this)
            .parents(".show-content-block")
            .find(".showtimes")
            .find(".accordion")
            .clone()
            .appendTo("#modal-showtimes .modal-body");
        });

        // Handlers Show
        $(".show-content-block .btn-group .btn-twobit").on("click", function(
          evt
        ) {
          if ($(this).hasClass("next")) {
            $(this)
              .parents(".slick-shows")
              .slick("slickNext");
          } else {
            $(this)
              .parents(".slick-shows")
              .slick("slickPrev");
          }
        });

        // Confirm Purcahse
        $(".slick-times .btn-twobit").on("click", function(evt) {
          evt.preventDefault();
          let href = $(this).prop("href");
          $(this)
            .parents(".show-content-block")
            .find(".available-dates .cta-btn")
            .addClass("show")
            .find(".btn-twobit")
            .prop("href", href);
        });

        // Check Deep link
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("cat") && urlParams.has("id")) {
          let cat = urlParams.get("cat");
          let focus = urlParams.get("id");
          $("#" + cat + "-tab").trigger("click");
          setTimeout(function() {
            $("#" + cat + " .slick-shows").slick("slickGoTo", focus);
          }, 1000);
        }
      }
      // Handle CLick for Nav Map
      $(".nav-link-direction").on("click", function(evt) {
        evt.preventDefault();
        $("#map-modal").modal("toggle");
      });
      // Handle Arrow Scroll Top
      $("#return-to-top").on("click", function(evt) {
        evt.preventDefault();
        $("html, body").animate({
            scrollTop: 0
          },
          "slow"
        );
      });
      // Enable parallax
      if ($(".parallax").length) {
        $(".parallax").parallax();
      }
      // Scroll to Top
      $(window).scroll(function() {
        if ($(this).scrollTop() >= 100) {
          $("#return-to-top").addClass("active");
        } else {
          $("#return-to-top").removeClass("active");
        }
      });
      if ($(".grid-isotope").length) {
        var $iso = new Isotope(".grid-isotope", {
          itemSelector: ".grid-item"
        });

        $("#grid-filter a").on("click", function(evt) {
          evt.preventDefault();
          if (!$(this).hasClass("active")) {
            $("#grid-filter a").removeClass("active");
            $(this).addClass("active");
            let subfilter = $(this).data("filter");
            $iso.arrange({
              filter: subfilter
            });
          }
        });
      }
      if ($("#parties-block").length || $("#promo-block").length) {
        $(".grid-item .event-link").on("click", function(evt) {
          evt.preventDefault();
          let $parent = $(this).parents(".grid-item");
          if (!$parent.find(".card-title").hasClass("collapsed")) {
            $parent.find(".card-title").addClass("collapsed");
            $parent.find(".card-body").addClass("show");
          } else {
            $parent.find(".card-title").removeClass("collapsed");
            $parent.find(".card-body").removeClass("show");
          }
          $iso.arrange();
        });
        $(".link-wrapper .btn").on("click", function(evt) {
          evt.preventDefault();
          let _event = $(this)
            .parents(".grid-item")
            .data("event");
          let $select = $("#event-form select[name='inquiry']");
          $('option[value="' + _event + '"]', $select).prop("selected", true);
          $select.trigger("click");
          let title = $(this)
            .parents(".grid-item.card")
            .find(".card-title")
            .text();
          $("#event-form")
            .find(".modal-title")
            .text(title);
          $("#event-form").modal("toggle");
        });
      }
      if ($(".more-calendar-block").length) {
        var weekday = [];
        var month = [];
        weekday[0] = "Sun";
        weekday[1] = "Mon";
        weekday[2] = "Tues";
        weekday[3] = "Wed";
        weekday[4] = "Thur";
        weekday[5] = "Fri";
        weekday[6] = "Sat";
        month[0] = "Jan";
        month[1] = "Feb";
        month[2] = "Mar";
        month[3] = "Apr";
        month[4] = "May";
        month[5] = "Jun";
        month[6] = "Jul";
        month[7] = "Aug";
        month[8] = "Sept";
        month[9] = "Oct";
        month[10] = "Nov";
        month[11] = "Dec";
        var calendarEl = document.getElementById("full-calendar");
        var addZero = function(i) {
            if (i < 10) {
              i = "0" + i;
            }
            return i;
          },
          formatAMPM = function(hours, minutes) {
            let hrs = (hours + 24 - 2) % 24;
            let ampm = hrs >= 12 ? "PM" : "AM";
            if (hrs == 0) {
              hrs = 12;
            } else if (hrs > 12) {
              hrs = hrs % 12;
            }
            return hours + ":" + addZero(minutes) + ampm;
          };
        var calendar = new Calendar(calendarEl, {
          plugins: [dayGridPlugin, timeGridPlugin, bootstrapPlugin],
          themeSystem: "bootstrap",
          events: _cal_events,
          displayEventTime: false,
          eventClick: function(info) {
            info.jsEvent.preventDefault();
            if (!$("#event-window").is(":visible")) {
              $("#event-window").addClass("show");
            }
            //console.log(info);
            let $obj = $(info.el);
            let $target = $("#event-window .card");
            let sd = new Date(info.event.start);
            let ed = new Date(info.event.end);
            $("#event-window")
              .parent()
              .addClass("show");
            $(".day", $target).text(weekday[sd.getDay()]);
            $(".date", $target).text(month[sd.getMonth()] + " " + sd.getDay());
            $(".card-title", $target).text(info.event.title);
            $(".start", $target).text(
              "Starts: " + formatAMPM(sd.getHours(), sd.getMinutes())
            );
            if (info.event.end)
              $(".end", $target).text(
                "Ends: " + formatAMPM(ed.getHours(), ed.getMinutes())
              );
            else {
              $(".end", $target).text("");
            }
            $(".card-img-top", $target).prop("src", info.event.id);
            $(".text", $target).text(info.event.textColor);
            if (info.event.url) {
              $(".link", $target)
                .removeClass("d-none")
                .prop("href", info.event.url);
            } else {
              $(".link", $target).addClass("d-none");
            }
          }
        });
        $(".btn.full-calendar").on("click", function(evt) {
          evt.preventDefault();
          $(this).toggleClass("show");
          $(".more-calendar-block").toggleClass("show");
          if (!$("#full-calendar.fc").length) calendar.render();
        });
        $(".more-calendar-block .close").on("click", function() {
          $(".full-calendar").toggleClass("show");
          $(".more-calendar-block").toggleClass("show");
        });
      }
      // Close Main Menu
      $("#close-btn").on("click", function() {
        $("body").removeClass("scroll-hidden");
        $("#main-nav .navbar-toggler").trigger("click");
      });
      $("#expanded-menu").on("show.bs.collapse", function() {
        $("body").addClass("scroll-hidden");
      });
    }
  );
  if ($("#about").length) {
    var _h = $("#about-header").height();
    var controller = new ScrollMagic.Controller();
    var scene = new ScrollMagic.Scene({
        triggerElement: "#trigger-element",
        offset: -_h / 2
      })
      .on("start end", function(e) {
        if (e.scrollDirection == "FORWARD") {
          $("html, body")
            .stop()
            .animate({
                scrollTop: $("#trigger-element").offset().top
              },
              700
            );
        }
      })
      .setClassToggle("#about-header", "scrolled")
      .addTo(controller);

    var scene2 = new ScrollMagic.Scene({
        triggerElement: "#trigger-element",
        offset: _h / 2
      })
      .on("start", function(e) {
        if (e.scrollDirection == "REVERSE") {
          $("html, body")
            .stop()
            .animate({
                scrollTop: 0
              },
              700
            );
        }
      })
      .setClassToggle("#about-header", "scrolled")
      .addTo(controller);

    let count = 0;
    $(window).on("resize", function() {
      clearTimeout(count);
      count = setTimeout(function() {
        _h = $("#about-header").height();
      });
    });
  }

  if ($("form#secret").length) {
    $("form#secret").on("submit", function(e) {
      e.preventDefault();
      $("#submit-btn").hide();
      $("#submit-loading").addClass("activate");
      jQuery.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "post",
        data: {
          action: "ajaxAirtable",
          secret: $("#secret-word").val()
        },
        success: function(response) {
          var dataObject = $.parseJSON(response);
          if (dataObject.succeed) {
            window.location = dataObject.succeed;
          } else {
            window.location = dataObject.failed;
          }
        }
      });
      return false;
    });
  }

  // Mobile SLick
  $(window).on('load resize orientationchange', function() {
    if ($('#filters').length) {
      let $slider = $('#filters .navbar-nav');
      if ($(window).width() > 768) {
        if ($slider.hasClass('slick-initialized')) {
          $slider.slick('unslick');
        }
      } else {
        if (!$slider.hasClass('slick-initialized')) {
          $slider.slick({
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            variableWidth: true,
            centerMode: true,
            focusOnSelect: true
          });
        }
      }
    }
  });
});
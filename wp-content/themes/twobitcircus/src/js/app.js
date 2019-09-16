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
import {Calendar} from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import ScrollMagic from "scrollmagic/scrollmagic/minified/ScrollMagic.min.js";
import addIndicators from "scrollmagic/scrollmagic/minified/plugins/debug.addIndicators.min.js";
import Player from "@vimeo/player";

var isIOS = navigator.userAgent.match(/ipad|ipod|iphone|macintosh/gi);

$(function() {
  //Wait for Preload Sprite before Starting
  var loadedItems = 0,
    $aboutElem = $("#about-intro"),
    $headerElem = $("#main-nav"),
    $articleElem = $("article.page.type-page"),
    scrollHeightTop = 800,
    scrollHide = 300,
    handleWaypoints = function() {
      if ($(".inview").length) {
        $(".inview").each(function() {
          let delay = $(this).data("offset") ? $(this).data("offset") : "90%";
          let easeType = $(this).data("ease")
            ? $(this).data("ease")
            : "fadeInUp";
          let waypoint = new Waypoint({
            element: this,
            handler: function(direction) {
              if (direction == "down" && !$(this.element).hasClass(easeType)) {
                $(this.element).addClass(easeType);
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
  if (isIOS) {
    $("body").addClass("is-mac");
  }
  // Intro for About
  if ($aboutElem.length) {
    imagesLoaded(
      "#about-intro",
      {
        background: true
      },
      function() {
        $aboutElem.addClass("start");
        setTimeout(function() {
          $("#about-header .caption-top .caption-content").addClass("fadeInUp");
        }, 2000);
      }
    );
  }
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
  $(window).scroll(function() {
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
    if (
      prevScrollpos > currentScrollPos ||
      currentScrollPos == 0 ||
      currentScrollPos < navBarHt + 25
    ) {
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
    responsive: [
      {
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
    responsive: [
      {
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
      }
    ]
  };
  var slick_event_settings = {
    dots: true,
    infinite: false,
    speed: 600,
    arrows: false,
    slidesToShow: 4,
    slidesToScroll: 4,
    adaptiveHeight: true,
    responsive: [
      {
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
    responsive: [
      {
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
    fade: true,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          arrows: false
        }
      }
    ]
  };
  var slick_feed_settings = {
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    responsive: [
      {
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
    responsive: [
      {
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
    infinite: false,
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
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    asNavFor: ".slick-media",
    focusOnSelect: true,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          centerMode: true
        }
      }
    ]
  };
  var slick_media_settings = {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: ".slick-media-nav"
  };

  imagesLoaded(
    "#attractions",
    {
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

      $("#filters .navbar-nav")
        .slick({
          slidesToShow: 7,
          slidesToScroll: 1,
          focusOnSelect: true,
          variableWidth: true,
          responsive: [
            {
              breakpoint: 991,
              settings: {
                variableWidth: false,
                arrows: true,
                centerMode: true,
                slidesToShow: 3
              }
            },
            {
              breakpoint: 767,
              settings: {
                variableWidth: false,
                arrows: true,
                centerMode: true,
                slidesToShow: 1
              }
            }
          ]
        })
        .on("beforeChange", function(event, slick, currentSlide, nextSlide) {
          let $elSlide = $(slick.$slides[nextSlide]);
          if ($(window).width() < 992) {
            $elSlide
              .addClass("item-mobile")
              .find(".nav-item .nav-link")
              .trigger("click");
          }
        });

      if ($("#news-content").length) {
        $(".slick-media").slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          adaptiveHeight: true,
          arrows: false,
          fade: true
        });
      }
      // Handle all Attraction Events
      if ($("#attractions-block").length) {
        var allowStart = false;
        var loadImg = function($elm) {
          if ($elm.find(".pre-load-img").length) {
            $elm.find(".pre-load-img").each(function() {
              let url = $(this).data("img");
              $(this)
                .removeClass("pre-load-img")
                .find("img")
                .removeClass("fade")
                .prop("src", url);
              $(this).removeAttr("data-img");
            });
          }
        };
        // ToolTips
        $('[data-tool-toggle="tooltip"]').tooltip({
          html: true
        });

        // First Attraction img
        loadImg($(".attractions-slick .item-attraction:first-child"));

        var initAttraction = function(resize) {
          if (resize === false) {
            $(".attractions-slick")
              .slick(slick_attractions_settings)
              .on("afterChange", function(ev, slick, cur) {
                let $elSlide = $(slick.$slides.get(cur));
                $elSlide
                  .parent()
                  .find(".slick-media-nav .slick-slide[data-slick-index=0]")
                  .addClass("slick-current slick-active");
              });
            $(".slick-shows")
              .slick(slick_shows_settings)
              .on("beforeChange", function(ev, slick, cur, next) {
                let iframe = $(slick.$slides.get(cur)).find("iframe");
                if (iframe.length) {
                  let player = new Player(iframe[0]);
                  player.pause();
                }
              })
              .on("afterChange", function(ev, slick, cur) {
                let $elSlide = $(slick.$slides.get(cur));
                if ($elSlide.find(".slick-days").length) {
                  $elSlide
                    .find(
                      ".slick-days > .slick-list > .slick-track > .slick-slide:first-child"
                    )
                    .trigger("click");
                }
              });
            $(".slick-media")
              .slick(slick_media_settings)
              .on("beforeChange", function(ev, slick, cur, next) {
                let iframe = $(slick.$slides.get(cur)).find("iframe");
                if (iframe.length) {
                  let player = new Player(iframe[0]);
                  player.pause();
                }
              });
            $(".slick-media-nav").slick(slick_media_nav_settings);
            $(".slick-days").slick(slick_days_settings);
            $(".slick-times")
              .slick(slick_times_settings)
              .on("beforeChange", function(ev, slick, cur, next) {
                $(".available-dates .cta-btn").removeClass("show");
              });
          } else {
            $(".slick-shows").slick("reinit");
            $(".attractions-slick").slick("reinit");
            $(".slick-media").slick("reinit");
            $(".slick-media-nav").slick("reinit");
            $(".slick-days").slick("reinit");
            $(".slick-times").slick("reinit");
          }
          // Append to Filter show
          $("#filters .nav-item .nav-link").on("click", function(e) {
            e.preventDefault(e);
            $('[data-tool-toggle="tooltip"]').tooltip("hide");
            if (!$(this).hasClass("active")) {
              $(".dropdown-toggle").dropdown("update");
              $("#filters .nav-link").removeClass("active");
              $(this).addClass("active");
              let slug = $(this).attr("aria-controls");
              if ($("#cat-" + slug).length) {
                loadImg($("#cat-" + slug));
                let index = $("#cat-" + slug)
                  .parents(".slick-slide")
                  .data("slick-index");
                $(".attractions-slick").slick("slickGoTo", index);
                $("#cat-" + slug)
                  .find(".slick-slide:first-child")
                  .addClass("slick-current slick-active");
                $("#cat-" + slug)
                  .find(
                    ".slick-days > .slick-list > .slick-track > .slick-slide:first-child"
                  )
                  .trigger("click");
                if ($(".slick-media").find("iframe").length) {
                  $(".slick-media")
                    .find("iframe")
                    .each(function(kf, fr) {
                      let player = new Player($(this)[0]);
                      player.pause();
                    });
                }
              }
            }
          });

          // Append to Filter show
          $("#filters .dropdown-menu .dropdown-item").on("click", function(e) {
            e.preventDefault(e);
            if (!$(this).hasClass("active")) {
              let slug = $(this).attr("aria-controls");
              if ($("#" + slug).length) {
                let index = $("#" + slug)
                  .parents(".slick-slide")
                  .data("slick-index");
                $("#" + slug)
                  .parents(".slick-shows")
                  .slick("slickGoTo", index);
                $("#" + slug)
                  .find(".slick-media-nav .slick-slide[data-slick-index=0]")
                  .addClass("slick-current slick-active");
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
            if ($(this).hasClass("btn-disabled")) return false;
            let href = $(this).prop("href");
            $(this)
              .parents(".item-time")
              .find(".btn-twobit")
              .removeClass("btn-green")
              .addClass("btn-white");
            $(this)
              .removeClass("btn-white")
              .addClass("btn-green");
            $(this)
              .parents(".show-content-block")
              .find(".available-dates .cta-btn")
              .addClass("show")
              .find(".btn-twobit")
              .prop("href", href);
          });
        };
        // Init Attraction Events
        initAttraction(false);

        var resizeAttract = 0;
        $(window).on("resize", function() {
          clearTimeout(resizeAttract);
          resizeAttract = setTimeout(function() {
            initAttraction(true);
          }, 500);
        });

        // Check Deep link
        let urlParams = window.location.href.split("/");
        let urlCat = "";
        let urlShow = "";
        if (
          typeof urlParams[3] !== "undefined" &&
          urlParams[3] == "attractions"
        ) {
          if (typeof urlParams[4] !== "undefined" && urlParams[4] != "#") {
            urlCat = urlParams[4];
          }
          if (typeof urlParams[5] !== "undefined" && urlParams[5] != "#") {
            urlShow = urlParams[5];
          }
        }
        if (urlCat) {
          $("a.nav-link[aria-controls=" + urlCat + "]").trigger("click");
          if (urlShow) {
            $("a.dropdown-item[aria-controls=" + urlShow + "]").trigger(
              "click"
            );
          } else {
            $("a.nav-link[aria-controls=" + urlCat + "]")
              .parent()
              .find(".dropdown-menu")
              .removeClass("show");
          }
        }
      }
    }
  );

  // Handle CLick for Nav Map
  $(".nav-link-direction").on("click", function(evt) {
    evt.preventDefault();
    $("#map-modal").modal("toggle");
  });
  // Handle Arrow Scroll Top
  $("#return-to-top").on("click", function(evt) {
    evt.preventDefault();
    $("html, body").animate(
      {
        scrollTop: 0
      },
      "slow"
    );
  });
  // Enable parallax
  if ($(".parallax").length) {
    $(".parallax").parallax();
  }
  // Go-Back
  // Handle Back Button
  var mainUrl = document.location.host;
  $(".go-back").on("click", function(e) {
    e.preventDefault();
    if (document.referrer.match(mainUrl)) {
      window.location.href = document.referrer;
    } else {
      window.location.href = "/shows/";
    }
  });
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
  if ($("#contact-block").length) {
    let $select = $("#contact-block select[name='inquiry']");
    $('option[value="General Inquiries"]', $select).prop("selected", true);
    $select.trigger("click");
  }
  if ($("#parties-block").length || $("#promo-block").length) {
    $(".grid-item .event-link").on("click", function(evt) {
      evt.preventDefault();
      let $parent = $(this).parents(".grid-item");
      if (!$parent.find(".card-title").hasClass("collapsed")) {
        $(".grid-item .card-title").removeClass("collapsed");
        $(".grid-item .card-body").removeClass("show");
        $parent.find(".card-title").addClass("collapsed");
        $parent.find(".card-body").addClass("show");
      } else {
        $parent.find(".card-title").removeClass("collapsed");
        $parent.find(".card-body").removeClass("show");
      }
    });
    $("#parties-block .link-wrapper .btn").on("click", function(evt) {
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
        let $obj = $(info.el);
        let $target = $("#event-window .card");
        let sd = new Date(info.event.start);
        let ed = new Date(info.event.end);
        $("#event-window")
          .parent()
          .addClass("show");
        $(".day", $target).text(weekday[sd.getDay()]);
        $(".date", $target).text(month[sd.getMonth()] + " " + sd.getDate());
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
            .prop("href", info.event.url)
            .parent()
            .removeClass("d-none");
        } else {
          $(".link", $target)
            .parent()
            .addClass("d-none");
        }
      }
    });
    $(".btn.full-calendar").on("click", function(evt) {
      evt.preventDefault();
      if (!$(this).hasClass("active")) {
        $(this).addClass("active");
        $(".more-calendar-block").toggleClass("show");
        if (!$("#full-calendar.fc").length) calendar.render();
        $(".full-calendar.btn span").text("Close Calendar");
      } else {
        $(this).removeClass("active");
        $(".more-calendar-block").toggleClass("show");
        $(".full-calendar.btn span").text("View Full Calendar");
      }
    });
    $("#event-window .close").on("click", function() {
      $(this)
        .parents(".event-show")
        .toggleClass("show");
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

  if ($("#about").length) {
    var _h = $("#about-header").height();
    var controller = new ScrollMagic.Controller();
    var scene = new ScrollMagic.Scene({
      triggerElement: "#trigger-element",
      offset: -_h / 2
    })
      .on("start end", function(e) {
        if (e.scrollDirection == "FORWARD") {
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
  if ($(".slick-package").length) {
    $(".slick-package").slick({
      arrows: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      adaptiveHeight: true,
      responsive: [
        {
          breakpoint: 1499,
          settings: {
            arrows: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: true
          }
        },
        {
          breakpoint: 991,
          settings: {
            arrows: true,
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 680,
          settings: {
            arrows: true,
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
  }
});

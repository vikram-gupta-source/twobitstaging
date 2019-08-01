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

$(function() {
  //Wait for Preload Sprite before Starting
  var loadedItems = 0,
    $headerElem = $("#main-nav"),
    $articleElem = $("article.page.type-page"),
    playIntro = true,
    scrollHeightTop = 800,
    scrollHeightNav = 200,
    scrollHide = 200,
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
  // Scroll Handler
  if ($("#arrow-cta").length && $(window).height() < scrollHeightTop)
    $("#arrow-cta").addClass("show");

  // Handle resize
  let clearInt = 0;
  var navBarHt = $("#main-nav").height();
  $("body").css({"padding-top": navBarHt + "px"});
  $(window).on("resize", function() {
    clearTimeout(clearInt);
    clearInt = setTimeout(function() {
      navBarHt = $("#main-nav").height();
      $("body").css({"padding-top": navBarHt + "px"});
    }, 500);
  });
  var lastY = 0;
  $(window)
    .scroll(function() {
      if ($("#arrow-cta").length) {
        if ($(this).scrollTop() >= scrollHide) {
          $("#arrow-cta").removeClass("show");
        } else {
          if ($(window).height() < scrollHeightTop) {
            $("#arrow-cta").addClass("show");
          }
        }
      }
      if ($(this).scrollTop() >= scrollHeightNav) {
        let lt = $(this).scrollTop();
        if (lt >= lastY) {
          // Down
          $("#main-nav").css({top: "-" + navBarHt + "px"});
        } else {
          $("#main-nav").css({top: 0});
        }
        lastY = lt;
      }
    })
    .trigger("scroll");

  // Handle Slider Slick
  var slick_settings = {
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
        settings: "unslick"
      }
    ]
  };
  var slick_center_settings = {
    dots: true,
    centerMode: true,
    slidesToShow: 3,
    arrows: true,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 767,
        settings: "unslick"
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
    arrows: false,
    adaptiveHeight: true,
    fade: true
  };
  var slick_feed_settings = {
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          dots: true,
          arrows: false,
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 530,
        settings: {
          dots: true,
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  };
  var slick_social_settings = {
    infinite: false,
    slidesToShow: 1,
    slidesToScroll: 1
  };
  var slick_days_settings = {
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    asNavFor: ".slick-times",
    focusOnSelect: true,
    centerMode: true
  };
  var slick_times_settings = {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    adaptiveHeight: true,
    arrows: false,
    swipe: false,
    touchMove: false
  };
  var slick_media_nav_settings = {
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    asNavFor: ".slick-media",
    focusOnSelect: true,
    centerMode: true
  };
  var slick_media_settings = {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    asNavFor: ".slick-media-nav",
    fade: true
  };
  if ($(".slick-init").length || $(".slick-center-init").length) {
    if ($(".slick-init").length) $(".slick-init").slick(slick_settings);
    if ($(".slick-center-init").length)
      $(".slick-center-init").slick(slick_center_settings);
    $(window).on("resize", function() {
      if ($(window).width() > 690) {
        if ($(".slick-init").length) {
          if (!$(".slick-init").hasClass("slick-initialized")) {
            return $(".slick-init").slick(slick_settings);
          }
        }
        if ($(".slick-center-init").length) {
          if (!$(".slick-center-init").hasClass("slick-initialized")) {
            return $(".slick-center-init").slick(slick_center_settings);
          }
        }
        return;
      }
    });
  }
  if ($(".slick-social").length) {
    $(".slick-feed").slick(slick_feed_settings);
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
      '<iframe class="embed-responsive-item" src="' + firstEmbed + '"></iframe>'
    );
  }

  // Handle all Attraction Events
  if ($("#attractions-block").length) {
    var defaultHt = 0;
    $(".attractions-slick").slick(slick_attractions_settings);
    $(".slick-shows")
      .slick(slick_shows_settings)
      .on("afterChange", function(ev, slick, cur) {
        $(slick.$slides.get(cur))
          .find(".slick-days .slick-slide:not(.slick-cloned):first")
          .trigger("click");
      });
    $(".slick-media").slick(slick_media_settings);
    $(".slick-media-nav").slick(slick_media_nav_settings);
    $(".slick-days").slick(slick_days_settings);
    $(".slick-times")
      .slick(slick_times_settings)
      .on("beforeChange", function(ev, slick, cur, next) {
        $(".available-dates > .btn-twobit")
          .removeClass("show visible")
          .addClass("invisible");
      });
    // Append to Filter show
    $("#filters a.nav-link").on("click", function(e) {
      e.preventDefault();
      if (!$(this).hasClass("active")) {
        $("#filters a.nav-link").removeClass("active");
        $(this).addClass("active");
        let slug = $(this).attr("aria-controls");
        if ($("#" + slug).length) {
          let index = $("#" + slug)
            .parents(".slick-slide")
            .data("slick-index");
          $(".attractions-slick").slick("slickGoTo", index);
          $("#" + slug)
            .find(".slick-days .slick-slide:not(.slick-cloned):first")
            .trigger("click");
        }
      }
    });
    $("#filters .nav-item:first-child a").trigger("click");

    //Extend Days slick
    $(".slick-days .slick-slide").on("click", function(evt) {
      evt.preventDefault();
      let _ht = $(this)
        .parents(".show-content-block")
        .outerHeight();
      let realHt = parseInt(_ht + 60);
      $(this)
        .parents(".slick-shows")
        .find("> .slick-list")
        .height(realHt + "px");
      $(".attractions-slick > .slick-list").height(realHt + "px");
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
    $(".show-content-block .btn-group .btn-twobit").on("click", function(evt) {
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
        .find(".available-dates > .btn-twobit")
        .removeClass("invisible")
        .addClass("show visible")
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
  $('#menu-main-menu a[href="#direction"]').on("click", function(evt) {
    evt.preventDefault();
    $("#map-modal").modal("toggle");
  });
  // Handle Arrow Scroll Top
  $("#return-to-top").on("click", function(evt) {
    evt.preventDefault();
    $("html, body").animate({scrollTop: 0}, "slow");
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
        $iso.arrange({filter: subfilter});
      }
    });
  }
  if ($("#promo-block").length) {
    $("#promo-block .grid-item .event-link").on("click", function(evt) {
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
  }
  if ($("#parties-block").length) {
    $("#parties-block .grid-item .event-link").on("click", function(evt) {
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
    $("#parties-block .link-wrapper .btn").on("click", function(evt) {
      evt.preventDefault();
      let _event = $(this)
        .parents(".grid-item")
        .data("event");
      let $select = $("#event-form select[name='inquiry']");
      $('option[value="' + _event + '"]', $select).prop("selected", true);
      $select.trigger("click");
      $("#event-form").addClass("active");
      $("#hidden-block").modal("show");
    });
    $("#hidden-block").on("shown.bs.modal", function(e) {
      $(".modal-backdrop.show, #event-form .close").on("click", function() {
        $("#event-form").removeClass("active");
        $("#hidden-block").modal("hide");
      });
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
      header: {
        left: "dayGridMonth,timeGridWeek,timeGridDay",
        center: "title"
      },
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
});

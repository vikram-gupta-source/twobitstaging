// Custom Scripts
import "bootstrap";
import "lazyloadxt/src/jquery.lazyloadxt";
import "lazyloadxt/src/jquery.lazyloadxt.bg";
import "waypoints/lib/jquery.waypoints";
import $ from "jquery";
import "slick-carousel";
import imagesLoaded from "imagesloaded";
import parallax from "./jquery.parallax.js";

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
        if (lt > lastY) {
          // Down
          //console.log("down");
          $("#main-nav").addClass("hide-away");
        } else {
          //console.log("up");
          $("#main-nav").removeClass("hide-away");
        }
        lastY = lt;
      }
    })
    .trigger("scroll");

  // Handle Slider Slick
  if ($(".slick").length) {
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
  }
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
});

// Custom Scripts
import "bootstrap";
import "lazyloadxt/src/jquery.lazyloadxt";
import "lazyloadxt/src/jquery.lazyloadxt.bg";
import "waypoints/lib/jquery.waypoints";
import $ from "jquery";
import "slick-carousel";
import imagesLoaded from "imagesloaded";
import {backgroundShapes} from "./backgroundShapes.js";
import parallax from "./jquery.parallax.js";

$(function() {
  //Wait for Preload Sprite before Starting
  var loadedItems = 0,
    $headerElem = $("#main-nav"),
    $splashElem = $("#splash-intro"),
    $shapesElem = $("#background-shapes"),
    $articleElem = $("article.page.type-page"),
    playIntro = true,
    scrollHeightTop = 800,
    scrollHeightNav = 200,
    scrollHide = 200,
    handleWaypoints = () => {
      if ($(".inview").length) {
        $(".inview").each(function() {
          let delay = $(this).data("offset") ? $(this).data("offset") : "80%";
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
  // Allow Intro to playing
  if ($splashElem.length && !sessionStorage.getItem("intro")) {
    sessionStorage.setItem("intro", 1);
  } else {
    playIntro = false;
  }
  // Test if home page for intro
  if ($splashElem.length && playIntro == true) {
    $splashElem.addClass("start");
    imagesLoaded("#splash-intro", {background: true}, () => {
      $(".preloader-bar", $splashElem).css("width", "100%");
      $("#background-shapes", $splashElem).addClass("active");
      setTimeout(() => {
        backgroundShapes.initializr();
        $(".preloader", $splashElem).addClass("d-none");
        $("#logo-animate").addClass("start");
        setTimeout(() => {
          $splashElem.addClass("bounceOutUp");
          $shapesElem.addClass("animate bounceOutUp");
          setTimeout(() => {
            $headerElem.addClass("start");
            $articleElem.addClass("start");
            $splashElem.addClass("d-none");
            $shapesElem.remove();
            $("body").addClass("scroll");
            handleWaypoints();
          }, 500);
        }, 2000);
      }, 1000);
    });
  } else {
    handleWaypoints();
    $headerElem.addClass("start");
    $articleElem.addClass("start");
    $splashElem.addClass("d-none");
    $shapesElem.remove();
    $("body").addClass("scroll");
  }
  // Trigger Scroll to activate lazyload
  // Close Main Menu
  $("#close-btn").on("click", function() {
    $("#main-nav .navbar-toggler").trigger("click");
  });
  // Bind to Mobile Nav click
  $("#main-nav .navbar-toggler").on("click", function() {
    if ($(this).hasClass("collapsed")) {
      $("body")
        .removeClass("scroll")
        .addClass("scroll-hidden");
    } else {
      $("body")
        .removeClass("scroll-hidden")
        .addClass("scroll");
    }
  });
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
      arrows: false,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 767,
          settings: "unslick"
        }
      ]
    };
  }
  if ($(".timeline-slick").length) {
    var slick_settings = {
      dots: true,
      infinite: false,
      speed: 300,
      arrows: true,
      slidesToShow: 5,
      slidesToScroll: 5,
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
          settings: "unslick"
        }
      ]
    };
  }
  if ($(".slick-init").length) {
    let $slick_slider = $(".slick-init").slick(slick_settings);
    $(window).on("resize", function() {
      if ($(window).width() > 690) {
        if (!$slick_slider.hasClass("slick-initialized")) {
          console.log(1);
          return $slick_slider.slick(slick_settings);
        }
        return;
      }
    });
  }
  if ($("#studio-section").length) {
    $("#studio-section .grid-item .bio").on("click", function(evt) {
      evt.preventDefault();
      let $parent = $(this).parent();
      if (!$parent.hasClass("active")) {
        $parent.addClass("active");
      } else {
        $parent.removeClass("active");
      }
    });
  }
  if ($("#jv_careersite_iframe_id").length) {
    $("#jv_careersite_iframe_id").on("load", function() {
      setTimeout(() => {
        let $parent = $(this).parents("#careers-apply");
        let $frame = $(this)
          .contents()
          .find("body article.jv-page-body");
        let header = $frame.find("h2.jv-header").text();
        let location = $frame.find("p.jv-apply-meta").html();
        //$parent.find("h1.headline").text(header);
        //$parent.find("h3.sub-headline").html(location);
        $(this).height(
          $(this)
            .contents()
            .find("html")
            .height()
        );
      }, 200);
    });
    //var iframe = document.getElementById("jv_careersite_iframe_id");
    //iframe.onload = function() {
    //  iframe.style.height =
    //    iframe.contentWindow.document.body.scrollHeightTop + "px";
    //};
  }
  // Handle Arrow Scroll Top
  $("#return-to-top").on("click", function(evt) {
    evt.preventDefault();
    $("html, body").animate({scrollTop: 0}, "slow");
  });
  if ($(".search-form").length) {
    // Popuplate Filter Options
    let departJson;
    let locationJson;
    if ($("#department-list").text()) {
      let toAppend = "";
      departJson = JSON.parse($("#department-list").text());
      $.each(departJson, function(k, v) {
        toAppend += '<option value=".' + k + '">' + v + "</option>";
      });
      $(".search-form .department-select").append(toAppend);
    }
    if ($("#location-list").text()) {
      let toAppend = "";
      locationJson = JSON.parse($("#location-list").text());
      $.each(locationJson, function(k, v) {
        toAppend += '<option value=".' + k + '">' + v + "</option>";
      });
      $(".search-form .location-select").append(toAppend);
    }
    // Handle Events for Search Options Filter
    $(".search-form .filter-select").on("change", function() {
      $(".search-form #search").val("");
      $(".empty-message").hide();
      let matchSearch = [];
      let is_empty = 0;
      if ($(".search-form .location-select").val())
        matchSearch.push($(".search-form .location-select").val());
      if ($(".search-form .department-select").val())
        matchSearch.push($(".search-form .department-select").val());
      let search_result =
        matchSearch.length > 0 ? $.trim(matchSearch.join(", ")) : "";
      if (search_result == "") {
        $("#careers-accordion .card").show();
        $(".empty-message").hide();
        return false;
      }
      $("#careers-accordion .card").each(function() {
        if ($(this).is(search_result)) {
          $(this).show();
          is_empty++;
        } else {
          $(this).hide();
        }
      });
      if (is_empty == 0) {
        $(".empty-message").show();
      }
    });
    $(".search-form #search")
      .on("keyup", function() {
        $(".search-form .filter-select").prop("selectedIndex", 0);
        let value = $(this)
          .val()
          .toLowerCase();
        if (value.length > 3) {
          $("#careers-accordion .card").filter(function() {
            $(this).toggle(
              $(".search-title", this)
                .text()
                .toLowerCase()
                .indexOf(value) > -1
            );
            if (!$("#careers-accordion .card").is(":visible")) {
              $(".empty-message").show();
            }
          });
        }
      })
      .on("search", function() {
        $("#careers-accordion .card").show();
        $(".empty-message").hide();
      });
  }
  // Enable parallax
  if ($(".parallax").length) {
    $(".parallax").parallax();
  }

  // Scroll to Top
  $(window).scroll(function() {
    if ($(this).scrollTop() >= 400) {
      $("#return-to-top").addClass("active");
    } else {
      $("#return-to-top").removeClass("active");
    }
  });
});

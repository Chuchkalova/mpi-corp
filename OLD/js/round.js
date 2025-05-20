$(document).ready(function () {
  if ($(window).width() < 768 ) {
    $('.wrap-title-filter').on('click', function(){
      $(this).closest('.dev-filter').find('.wrap-dev-filter-section').toggleClass('open');
    });
  };

    const $header = $(".main-page header");
    const $secondHeader = $(".second-page-template header");
    const $thirdHeader = $(".third-page-template header");

    const $main = $(".main-page .eff-type-1");
    const $second = $(".second-page-template .second-template");
    const $third = $(".third-page-template .third-template");

    const $headerHeight = $header.height();
    const $headerSecondHeight = $secondHeader.height();
    const $headerThirdHeight = $thirdHeader.height();

    const $mainHeight = $main.height();
    const $secondHeight = $second.height();
    const $thirdHeight = $third.height();

    $(window).scroll(function () {
        if ($(this).scrollTop() >= $mainHeight - $headerHeight) {
            $header.addClass("prefix");
            $header.addClass("developer");
        } else {
            $header.removeClass("prefix");
            $header.removeClass("developer");
        }
        if ($(this).scrollTop() >= $mainHeight) {
            $header.addClass("fix");
        } else {
            $header.removeClass("fix");
        }

        if ($(this).scrollTop() >= $secondHeight - $headerSecondHeight ) {
            $secondHeader.addClass("prefix");
            $secondHeader.addClass("developer");
        } else {
            $secondHeader.removeClass("prefix");
            $secondHeader.removeClass("developer");
        }
        if ($(this).scrollTop() >= $secondHeight) {
            $secondHeader.addClass("fix");
        } else {
            $secondHeader.removeClass("fix");
        }

        if ($(this).scrollTop() >= $thirdHeight - $headerThirdHeight + 30 ) {
            $thirdHeader.addClass("prefix");
        } else {
            $thirdHeader.removeClass("prefix");
        }
        if ($(this).scrollTop() >= $thirdHeight) {
            $thirdHeader.addClass("fix");
        } else {
            $thirdHeader.removeClass("fix");
        }
    });
    if($('#slider').length) {
      let slider = document.getElementById('slider');

        noUiSlider.create(slider, {
            start: [100000, 100000000],
            connect: true,
            range: {
                'min': 0,
                'max': 100000000
             },
            format: {
                to: function(value) {
                    return parseFloat(value).toFixed(0);
                },
                from: function(value) {
                    return parseFloat(value).toFixed(0);
                }
            }
        });
        function formatCurrency(value) {
            return Number(value).toLocaleString() + ' ₽';
        }

        function parseCurrency(value) {
            return Number(value.replace(/[^0-9.-]+/g, ""));
        }
        var lowerValue = document.getElementById('lower-value');
        var upperValue = document.getElementById('upper-value');

        slider.noUiSlider.on('update', function (values, handle) {
            var value = Math.round(values[handle]);
            if (handle === 0) {
                lowerValue.value = formatCurrency(value);
            } else {
                upperValue.value = formatCurrency(value);
            }
        });

        // Listen to input field changes and update slider
        lowerValue.addEventListener('change', function () {
            slider.noUiSlider.set([parseCurrency(this.value), null]);
        });

        upperValue.addEventListener('change', function () {
            slider.noUiSlider.set([null, parseCurrency(this.value)]);
        });

        // Format input fields on blur
        lowerValue.addEventListener('blur', function () {
            this.value = formatCurrency(parseCurrency(this.value));
        });

        upperValue.addEventListener('blur', function () {
            this.value = formatCurrency(parseCurrency(this.value));
        });

        // Prevent non-numeric characters
        lowerValue.addEventListener('input', function (event) {
            this.value = this.value.replace(/[^\d.,-]/g, '');
        });

        upperValue.addEventListener('input', function (event) {
            this.value = this.value.replace(/[^\d.,-]/g, '');
        });
      }
  var counters = $('.counter');
counters.each(function() {
    var input = $(this).find('.counter-input input');
    var minusBtn = $(this).find('.counter-minus');
    var plusBtn = $(this).find('.counter-plus');
    minusBtn.click(function() {
        var value = parseInt(input.val());
        if (value > 1) {
            value--;
            input.val(value);
            input.trigger('change');
        }
        if (value === 1) {
            minusBtn.addClass('disabled');
        } else {
            minusBtn.removeClass('disabled');
        }
    });
    plusBtn.click(function() {
        var value = parseInt(input.val());
        value++;
        input.val(value);
        input.trigger('change');
        minusBtn.removeClass('disabled');
    });
    if (parseInt(input.val()) === 1) {
        minusBtn.addClass('disabled');
    }
});
$('.service-accordion-item-title').on('click', function() {
    var $accordionItem = $(this).closest('.service-accordion-item');
    if ($accordionItem.hasClass('open')) {
      $accordionItem.removeClass('open');
      $accordionItem.find('.service-accordion-content').slideUp();
    } else {
      $('.service-accordion-item.open').removeClass('open').find('.service-accordion-content').slideUp();
      $accordionItem.addClass('open');
      $accordionItem.find('.service-accordion-content').slideDown();
    }
  });
      if ($(".wrap-partners-item").length) {
        $(function () {
            var mouseX = 0, mouseY = 0, limitX = 2000, limitY = 2000;
            $(window).mousemove(function (e) {
                var offset = $('.wrap-partners-item').offset();
                mouseX = Math.min(e.pageX - offset.left, limitX);
                mouseY = Math.min(e.pageY - offset.top, limitY);
                if (mouseX < 0) mouseX = 0;
                if (mouseY < 0) mouseY = 0;
            });
            var follower = $("#follower");
            var xp = 0, yp = 0;
            var loop = setInterval(function () {
                xp += (mouseX - xp) / 10;
                yp += (mouseY - yp) / 10;
                follower.css({left: xp - 400, top: yp - 400});
            }, 10);

        });
    };
    if ($(window).width() < 768 ) {
     $('.wrap-title-filter h4').click(function() {
            let wrapBlock = $(this).closest('.dev-filter').find('.wrap-dev-filter-section');
            $(this).toggleClass('open');
            wrapBlock.slideToggle();
        }); 
    $('.fade-block h5').click(function() {
            let wrapBlock = $(this).next('.wrap-fade-block');
            $(this).toggleClass('open');
            wrapBlock.slideToggle();
        });
     $('.gamb-col-item h5').click(function() {
            let wrapBlock = $(this).next('.wrap-gamb-col-link');
            $(this).toggleClass('open');
            wrapBlock.slideToggle();
        });
   }
  const elements1 = document.querySelectorAll(".list-box-items p");
  elements1.forEach((element) => {
    $clamp(element, {
      clamp: 3,
      useNativeClamp: true,
    });
  });
    const elements2 = document.querySelectorAll(".dev-content-item-info p");
  elements2.forEach((element) => {
    $clamp(element, {
      clamp: 3,
      useNativeClamp: true,
    });
  });
      const elements3 = document.querySelectorAll(".developer-item-info p");
  elements3.forEach((element) => {
    $clamp(element, {
      clamp: 3,
      useNativeClamp: true,
    });
  });      
  const elements4 = document.querySelectorAll(".similar-slide p");
  elements4.forEach((element) => {
    $clamp(element, {
      clamp: 3,
      useNativeClamp: true,
    });
  });
  const elements5 = document.querySelectorAll(".cart-block-item-info p");
  elements5.forEach((element) => {
    $clamp(element, {
      clamp: 3,
      useNativeClamp: true,
    });
  });
   $('.wrap-po-filter span').click(function() {
        $('.wrap-po-filter span').removeClass('active');
        $(this).addClass('active');

        let category = $(this).data('po');

        if (category === 'all') {
            $(this).closest('.po-block').find('.po-item-filter .po-item').show();
        } else {
            $(this).closest('.po-block').find('.po-item-filter .po-item').hide();
            $(this).closest('.po-block').find('.po-item-filter .po-item[data-po="' + category + '"]').show();
        }
    });
    $('.filter-tab').click(function() {
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');

        let category = $(this).data('category');

        if (category === 'all') {
            $('.filter-product').show();
        } else {
            $('.filter-product').hide();
            $('.filter-product[data-category="' + category + '"]').show();
        }
    });
    var $window = $(window);
            var $targetBlock = $('.footer-form-block');
            var offset = 50;

            function checkVisibility() {
                var windowTop = $window.scrollTop();
                var windowBottom = windowTop + $window.height();
                var targetTop = $targetBlock.offset().top - offset;
                var targetBottom = targetTop + $targetBlock.outerHeight();

                if (windowBottom > targetTop && windowTop < targetBottom) {
                    $targetBlock.addClass('visible');
                } else {
                    $targetBlock.removeClass('visible');
                }
            }
            checkVisibility();
            $window.on('scroll', function() {
                checkVisibility();
            });
            $window.on('resize', function() {
                checkVisibility();
            });
  if($('.edu-center-slider').length) {
      $('.edu-center-slider').slick({
      dots: true,
      infinite: true,
      speed: 500,
      fade: true,
      cssEase: 'linear',
      slidesToShow: 1,
      slidesToScroll: 1
    });
  }
    if($('.similar-slider').length) {
      $('.similar-slider').slick({
      dots: true,
      infinite: true,
      speed: 500,
      slidesToShow: 3,
      slidesToScroll: 1,
      responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 720,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 320,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    });
  }
      if($('.about-slider').length) {
      $('.about-slider').slick({
      dots: true,
      infinite: true,
      speed: 500,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 769,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 740,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    });
  }
        var currentRotation = 0;
      var rotationStep = 45; 
  $(document).on('click', '.round .menu-item', function () {
      currentRotation += rotationStep;
      let div = $(this).attr('data-tab');
      $('.round .menu-item').removeClass('active');
      $(this).addClass('active');
      $('.tab-box .tab').removeClass('active').hide();
       $('.tab-box .tab').filter('#' + div).show().addClass('active');
       $('#round-earth').css({
        'transform': 'rotate(' + currentRotation + 'deg)'
      });
      return false;
  });
   $(document).on('click', '[data-popup]', function() {
        const popupId = $(this).data('popup');
        $('.popup').removeClass('active');
        $('#' + popupId).addClass('active');
        $("body, html").addClass('overflow');
    });
    $(document).on('click', '.popup-close, .popup-back-close-btn', function() {
        $(this).closest('.popup').removeClass('active');
        $("body, html").removeClass('overflow');
    });
   if ($(window).width() < 1200 ) {
    let currentIndex = 0;
    const interval = 3000;
    const menuItems = $(".menu-item");

    function switchMenuItem() {
      // menuItems.eq(currentIndex).removeClass("active");
      currentIndex = (currentIndex + 1) % menuItems.length;
      menuItems.eq(currentIndex).addClass("active");
      menuItems.eq(currentIndex).trigger("click");
    }
    setInterval(switchMenuItem, interval);
  }




  $(document).on('click', '.developer-tab-list li a', function () {
      let div = $(this).attr('href');
      $('.developer-tab-list li').removeClass('curent');
      $(this).closest('.developer-tab-list li').addClass('curent');
      $('.developer-tab-box .developer-tab').removeClass('active').hide();
       $('.developer-tab-box .developer-tab').filter(div).show().addClass('active');
      return false;
  });
  $(document).on('click', '.wrap-tabs-list li a', function() {
    let div = $(this).attr('href');
    $('.wrap-tabs-list li.curent').removeClass('curent');
    $(this).closest('.wrap-tabs-list li').addClass('curent');
    $('.tabs-list-box').removeClass('active').hide();
    $(div).show().addClass('active');
    $(div).closest('.tabs-list-box').show();
    return false;
  });
    if ($(window).width() > 768 ) {
    $('#marquee').liMarquee({
        scrollamount: 20,
    });
      $('#marquee-2').liMarquee({
          scrollamount: 20,
          direction: 'right'  
      });
    } else {
      $('#marquee').liMarquee({
        scrollamount: 15,
    });
      $('#marquee-2').liMarquee({
          scrollamount: 15,
          direction: 'right'  
      });
    };
    $.fn.parallax = function (resistance, mouse) {
  $el = $(this);
  TweenLite.to($el, 0.6, {
    x: -((mouse.clientX - window.innerWidth / 2) / resistance),
    y: -((mouse.clientY - window.innerHeight / 2) / resistance)
  });
};
$('.wrap-input input').on('input', function() {
    if ($(this).val().trim() !== '') {
        $(this).closest('.wrap-input').addClass('not-empty');
      } else {
        $(this).closest('.wrap-input').removeClass('not-empty');
      }
    });
  let telElements = document.querySelectorAll('input[type="tel"]');
  for (var telElement of telElements) {
    var maskOptions = {
      mask: '+7(000)000-00-00',
      lazy: false
    };
    var mask = new IMask(telElement, maskOptions);
  }
  function validatePhoneNumber(element) {
    var phoneNumber = $(element).val();
    var digitsOnly = phoneNumber.replace(/\D/g, '');
    if (digitsOnly.length === 11) {
      $(element).closest(".wrap-input").removeClass("error");
    } else {
      $(element).closest(".wrap-input").addClass("error");
    }
  }
$('.about-obj').mousemove(function (e) {
  $(".object-1").parallax(10, e);
  $(".object-2").parallax(30, e);
  $(".object-3").parallax(50, e);
  $(".object-4").parallax(10, e);
  $(".object-5").parallax(30, e);
  $(".object-6").parallax(10, e);
});
    particlesJS("particles-js", {
  particles: {
    number: { value: 90, density: { enable: true, value_area: 800 } },
    color: { value: "#ffffff" },
    shape: {
      type: "circle",
      stroke: { width: 0, color: "#000000" },
      polygon: { nb_sides: 5 },
      image: { src: "img/github.svg", width: 100, height: 100 }
    },
    opacity: {
      value: 0.5,
      random: false,
      anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false }
    },
    size: {
      value: 3,
      random: true,
      anim: { enable: false, speed: 40, size_min: 0.1, sync: false }
    },
    line_linked: {
      enable: true,
      distance: 150,
      color: "#ffffff",
      opacity: 0.4,
      width: 1
    },
    move: {
      enable: true,
      speed: 6,
      direction: "none",
      random: false,
      straight: false,
      out_mode: "out",
      bounce: false,
      attract: { enable: false, rotateX: 600, rotateY: 1200 }
    }
  },
  interactivity: {
    detect_on: "canvas",
    events: {
      onhover: { enable: true, mode: "repulse" },
      onclick: { enable: true, mode: "push" },
      resize: true
    },
    modes: {
      grab: { distance: 400, line_linked: { opacity: 1 } },
      bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 },
      repulse: { distance: 200, duration: 0.4 },
      push: { particles_nb: 4 },
      remove: { particles_nb: 2 }
    }
  },
  retina_detect: true
});


const all = document.querySelectorAll(".blob-item");
    document.addEventListener("mousemove", (ev) => {
        all.forEach((e) => {
            const blob = e.querySelector(".blob");
            const fblob = e.querySelector(".fakeblob");
            const rec = fblob.getBoundingClientRect();
            blob.style.opacity = "1";
            blob.animate(
                [
                    {
                        transform: `translate(${
                            (ev.clientX - rec.left) - (rec.width / 2)
                        }px,${(ev.clientY - rec.top) - (rec.height / 2)}px)`
                    }
                ],
                {
                    duration: 300,
                    fill: "forwards"
                }
            );
        });
    });
// all.forEach((e) => {
//   const blob = e.querySelector(".blob");
//   const fblob = e.querySelector(".fakeblob");

//   const updateBlobPosition = (x, y) => {
//     blob.style.transform = `translate(${x}px, ${y}px)`;
//     blob.style.opacity = "1";
//   };

//   e.addEventListener("mousemove", (ev) => {
//     const rec = fblob.getBoundingClientRect();
//     const relX = ev.clientX - rec.left;
//     const relY = ev.clientY - rec.top;

//     const blobX = relX - (blob.offsetWidth / 2);
//     const blobY = relY - (blob.offsetHeight / 2);

//     updateBlobPosition(blobX, blobY);
//   });

//   e.addEventListener("mouseleave", () => {
//     blob.style.opacity = "0";
//   });
// });

// document.addEventListener("mousemove", (ev) => {
//   const blobs = document.querySelectorAll(".blob");
//   blobs.forEach((blob) => {
//     const rec = blob.parentElement.getBoundingClientRect();
//     const relX = ev.clientX - rec.left;
//     const relY = ev.clientY - rec.top;

//     const blobX = relX - (blob.offsetWidth / 2);
//     const blobY = relY - (blob.offsetHeight / 2);

//     blob.style.transform = `translate(${blobX}px, ${blobY}px)`;
//   });
// });
$(document).on('click','.gamb', function() {
  $('.gamb-menu').show();
  $("body, html").addClass('overflow');
});
$(document).on('click','.close-gamb', function() {
  $('.gamb-menu').hide();
  $("body, html").removeClass('overflow');
});
  // const menu = $('.circle-menu');
  // const items = $('.menu-item');

  // const totalItems = items.length;
  // const angle = 360 / totalItems;

  //   items.each(function (index) {
  //   const rotateValue = angle * index;
  //   const translateValue = 90; 
  //   const x = Math.cos((rotateValue * Math.PI) / 180) * translateValue;
  //   const y = Math.sin((rotateValue * Math.PI) / 180) * translateValue;

  //   const content = $(this).find('.content');
  //   const contentRotation = -rotateValue; 

  //   content.css({
  //     'transform': `rotate(360deg)`
  //   });

  //   $(this).css({
  //     'transform': `translate(-50%, -50%) translate(${x}px, ${y}px)`,
  //     'transform-origin': 'center center'
  //   });

  //   $(this).attr('data-angle', rotateValue); 
  // });

  // items.click(function () {
  //   items.removeClass('active');
  //   $(this).addClass('active');
  //   const rotation = -$(this).data('angle');
  //   menu.css('transform', `rotate(${rotation}deg)`);
  //   const content = $(this).find('.content');
  //   const contentRotation = -rotateValue; 

  //   content.css({
  //     'transform': `rotate(360deg)`
  //   });
  // });

  // menu.mouseleave(function () {
  //   menu.removeClass('rotate');
  //   setTimeout(function () {
  //     menu.addClass('rotate');
  //   }, 10);
  // });

  // let isDragging = false;
  // let startAngle;

  // menu.mousedown(function (e) {
  //   isDragging = true;
  //   startAngle = getMouseAngle(e);
  //   menu.removeClass('rotate');
  // });

  // $(document).mousemove(function (e) {
  //   if (isDragging) {
  //     const currentAngle = getMouseAngle(e);
  //     const rotation = currentAngle - startAngle;
  //     menu.css('transform', `rotate(${rotation}deg)`);
  //   }
  // });

  // $(document).mouseup(function () {
  //   if (isDragging) {
  //     isDragging = false;
  //     menu.addClass('rotate');
  //   }
  // });

  // function getMouseAngle(e) {
  //   const centerX = menu.offset().left + menu.width() / 2;
  //   const centerY = menu.offset().top + menu.height() / 2;
  //   const angle = Math.atan2(e.pageY - centerY, e.pageX - centerX);
  //   return angle * (180 / Math.PI);
  // }
});



if($('.round').length) {

(function(){
  "use strict";

  var Delaunay;

  (function() {

      var EPSILON = 1.0 / 1048576.0;

      function supertriangle(vertices) {
          var xmin = Number.POSITIVE_INFINITY,
              ymin = Number.POSITIVE_INFINITY,
              xmax = Number.NEGATIVE_INFINITY,
              ymax = Number.NEGATIVE_INFINITY,
              i, dx, dy, dmax, xmid, ymid;

          for(i = vertices.length; i--; ) {
              if(vertices[i][0] < xmin) xmin = vertices[i][0];
              if(vertices[i][0] > xmax) xmax = vertices[i][0];
              if(vertices[i][1] < ymin) ymin = vertices[i][1];
              if(vertices[i][1] > ymax) ymax = vertices[i][1];
          }

          dx = xmax - xmin;
          dy = ymax - ymin;
          dmax = Math.max(dx, dy);
          xmid = xmin + dx * 0.5;
          ymid = ymin + dy * 0.5;

          return [
              [xmid - 20 * dmax, ymid -      dmax],
              [xmid            , ymid + 20 * dmax],
              [xmid + 20 * dmax, ymid -      dmax]
          ];
      }

      function circumcircle(vertices, i, j, k) {
          var x1 = vertices[i][0],
              y1 = vertices[i][1],
              x2 = vertices[j][0],
              y2 = vertices[j][1],
              x3 = vertices[k][0],
              y3 = vertices[k][1],
              fabsy1y2 = Math.abs(y1 - y2),
              fabsy2y3 = Math.abs(y2 - y3),
              xc, yc, m1, m2, mx1, mx2, my1, my2, dx, dy;

        /* Check for coincident points */
          if(fabsy1y2 < EPSILON && fabsy2y3 < EPSILON)
              throw new Error("Eek! Coincident points!");

          if(fabsy1y2 < EPSILON) {
              m2  = -((x3 - x2) / (y3 - y2));
              mx2 = (x2 + x3) / 2.0;
              my2 = (y2 + y3) / 2.0;
              xc  = (x2 + x1) / 2.0;
              yc  = m2 * (xc - mx2) + my2;
          }

          else if(fabsy2y3 < EPSILON) {
              m1  = -((x2 - x1) / (y2 - y1));
              mx1 = (x1 + x2) / 2.0;
              my1 = (y1 + y2) / 2.0;
              xc  = (x3 + x2) / 2.0;
              yc  = m1 * (xc - mx1) + my1;
          }

          else {
              m1  = -((x2 - x1) / (y2 - y1));
              m2  = -((x3 - x2) / (y3 - y2));
              mx1 = (x1 + x2) / 2.0;
              mx2 = (x2 + x3) / 2.0;
              my1 = (y1 + y2) / 2.0;
              my2 = (y2 + y3) / 2.0;
              xc  = (m1 * mx1 - m2 * mx2 + my2 - my1) / (m1 - m2);
              yc  = (fabsy1y2 > fabsy2y3) ?
                  m1 * (xc - mx1) + my1 :
                  m2 * (xc - mx2) + my2;
          }

          dx = x2 - xc;
          dy = y2 - yc;
          return {i: i, j: j, k: k, x: xc, y: yc, r: dx * dx + dy * dy};
      }

      function dedup(edges) {
          var i, j, a, b, m, n;

          for(j = edges.length; j; ) {
              b = edges[--j];
              a = edges[--j];

              for(i = j; i; ) {
                  n = edges[--i];
                  m = edges[--i];

                  if((a === m && b === n) || (a === n && b === m)) {
                      edges.splice(j, 2);
                      edges.splice(i, 2);
                      break;
                  }
              }
          }
      }

      Delaunay = {
          triangulate: function(vertices, key) {
              var n = vertices.length,
                  i, j, indices, st, open, closed, edges, dx, dy, a, b, c;

            /* Bail if there aren't enough vertices to form any triangles. */
              if(n < 3)
                  return [];

            /* Slice out the actual vertices from the passed objects. (Duplicate the
             * array even if we don't, though, since we need to make a supertriangle
             * later on!) */
              vertices = vertices.slice(0);

              if(key)
                  for(i = n; i--; )
                      vertices[i] = vertices[i][key];

            /* Make an array of indices into the vertex array, sorted by the
             * vertices' x-position. */
              indices = new Array(n);

              for(i = n; i--; )
                  indices[i] = i;

              indices.sort(function(i, j) {
                  return vertices[j][0] - vertices[i][0];
              });

            /* Next, find the vertices of the supertriangle (which contains all other
             * triangles), and append them onto the end of a (copy of) the vertex
             * array. */
              st = supertriangle(vertices);
              vertices.push(st[0], st[1], st[2]);

            /* Initialize the open list (containing the supertriangle and nothing
             * else) and the closed list (which is empty since we havn't processed
             * any triangles yet). */
              open   = [circumcircle(vertices, n + 0, n + 1, n + 2)];
              closed = [];
              edges  = [];

            /* Incrementally add each vertex to the mesh. */
              for(i = indices.length; i--; edges.length = 0) {
                  c = indices[i];

                /* For each open triangle, check to see if the current point is
                 * inside it's circumcircle. If it is, remove the triangle and add
                 * it's edges to an edge list. */
                  for(j = open.length; j--; ) {
                    /* If this point is to the right of this triangle's circumcircle,
                     * then this triangle should never get checked again. Remove it
                     * from the open list, add it to the closed list, and skip. */
                      dx = vertices[c][0] - open[j].x;
                      if(dx > 0.0 && dx * dx > open[j].r) {
                          closed.push(open[j]);
                          open.splice(j, 1);
                          continue;
                      }

                    /* If we're outside the circumcircle, skip this triangle. */
                      dy = vertices[c][1] - open[j].y;
                      if(dx * dx + dy * dy - open[j].r > EPSILON)
                          continue;

                    /* Remove the triangle and add it's edges to the edge list. */
                      edges.push(
                          open[j].i, open[j].j,
                          open[j].j, open[j].k,
                          open[j].k, open[j].i
                      );
                      open.splice(j, 1);
                  }

                /* Remove any doubled edges. */
                  dedup(edges);

                /* Add a new triangle for each edge. */
                  for(j = edges.length; j; ) {
                      b = edges[--j];
                      a = edges[--j];
                      open.push(circumcircle(vertices, a, b, c));
                  }
              }

            /* Copy any remaining open triangles to the closed list, and then
             * remove any triangles that share a vertex with the supertriangle,
             * building a list of triplets that represent triangles. */
              for(i = open.length; i--; )
                  closed.push(open[i]);
              open.length = 0;

              for(i = closed.length; i--; )
                  if(closed[i].i < n && closed[i].j < n && closed[i].k < n)
                      open.push(closed[i].i, closed[i].j, closed[i].k);

            /* Yay, we're done! */
              return open;
          },
          contains: function(tri, p) {
            /* Bounding box test first, for quick rejections. */
              if((p[0] < tri[0][0] && p[0] < tri[1][0] && p[0] < tri[2][0]) ||
                  (p[0] > tri[0][0] && p[0] > tri[1][0] && p[0] > tri[2][0]) ||
                  (p[1] < tri[0][1] && p[1] < tri[1][1] && p[1] < tri[2][1]) ||
                  (p[1] > tri[0][1] && p[1] > tri[1][1] && p[1] > tri[2][1]))
                  return null;

              var a = tri[1][0] - tri[0][0],
                  b = tri[2][0] - tri[0][0],
                  c = tri[1][1] - tri[0][1],
                  d = tri[2][1] - tri[0][1],
                  i = a * d - b * c;

            /* Degenerate tri. */
              if(i === 0.0)
                  return null;

              var u = (d * (p[0] - tri[0][0]) - b * (p[1] - tri[0][1])) / i,
                  v = (a * (p[1] - tri[0][1]) - c * (p[0] - tri[0][0])) / i;

            /* If we're outside the tri, fail. */
              if(u < 0.0 || v < 0.0 || (u + v) > 1.0)
                  return null;

              return [u, v];
          }
      };

      if(typeof module !== "undefined")
          module.exports = Delaunay;
  })();

  var FSS = {
      FRONT  : 0,
      BACK   : 1,
      DOUBLE : 2,
      SVGNS  : 'http://www.w3.org/2000/svg'
  };

  /**
   * @class Array
   * @author Matthew Wagerfield
   */
  FSS.Array = typeof Float32Array === 'function' ? Float32Array : Array;

  /**
   * @class Utils
   * @author Matthew Wagerfield
   */
  FSS.Utils = {
      isNumber: function(value) {
          return !isNaN(parseFloat(value)) && isFinite(value);
      }
  };



  /**
   * @object Math Augmentation
   * @author Matthew Wagerfield
   */
  Math.PIM2 = Math.PI*2;
  Math.PID2 = Math.PI/2;
  Math.randomInRange = function(min, max) {
      return min + (max - min) * Math.random();
  };
  Math.clamp = function(value, min, max) {
      value = Math.max(value, min);
      value = Math.min(value, max);
      return value;
  };

  /**
   * @object Vector3
   * @author Matthew Wagerfield
   */
  FSS.Vector3 = {
      create: function(x, y, z) {
          var vector = new FSS.Array(3);
          this.set(vector, x, y, z);
          return vector;
      },
      clone: function(a) {
          var vector = this.create();
          this.copy(vector, a);
          return vector;
      },
      set: function(target, x, y, z) {
          target[0] = x || 0;
          target[1] = y || 0;
          target[2] = z || 0;
          return this;
      },
      setX: function(target, x) {
          target[0] = x || 0;
          return this;
      },
      setY: function(target, y) {
          target[1] = y || 0;
          return this;
      },
      setZ: function(target, z) {
          target[2] = z || 0;
          return this;
      },
      copy: function(target, a) {
          target[0] = a[0];
          target[1] = a[1];
          target[2] = a[2];
          return this;
      },
      add: function(target, a) {
          target[0] += a[0];
          target[1] += a[1];
          target[2] += a[2];
          return this;
      },
      addVectors: function(target, a, b) {
          target[0] = a[0] + b[0];
          target[1] = a[1] + b[1];
          target[2] = a[2] + b[2];
          return this;
      },
      addScalar: function(target, s) {
          target[0] += s;
          target[1] += s;
          target[2] += s;
          return this;
      },
      subtract: function(target, a) {
          target[0] -= a[0];
          target[1] -= a[1];
          target[2] -= a[2];
          return this;
      },
      subtractVectors: function(target, a, b) {
          target[0] = a[0] - b[0];
          target[1] = a[1] - b[1];
          target[2] = a[2] - b[2];
          return this;
      },
      subtractScalar: function(target, s) {
          target[0] -= s;
          target[1] -= s;
          target[2] -= s;
          return this;
      },
      multiply: function(target, a) {
          target[0] *= a[0];
          target[1] *= a[1];
          target[2] *= a[2];
          return this;
      },
      multiplyVectors: function(target, a, b) {
          target[0] = a[0] * b[0];
          target[1] = a[1] * b[1];
          target[2] = a[2] * b[2];
          return this;
      },
      multiplyScalar: function(target, s) {
          target[0] *= s;
          target[1] *= s;
          target[2] *= s;
          return this;
      },
      divide: function(target, a) {
          target[0] /= a[0];
          target[1] /= a[1];
          target[2] /= a[2];
          return this;
      },
      divideVectors: function(target, a, b) {
          target[0] = a[0] / b[0];
          target[1] = a[1] / b[1];
          target[2] = a[2] / b[2];
          return this;
      },
      divideScalar: function(target, s) {
          if (s !== 0) {
              target[0] /= s;
              target[1] /= s;
              target[2] /= s;
          } else {
              target[0] = 0;
              target[1] = 0;
              target[2] = 0;
          }
          return this;
      },
      cross: function(target, a) {
          var x = target[0];
          var y = target[1];
          var z = target[2];
          target[0] = y*a[2] - z*a[1];
          target[1] = z*a[0] - x*a[2];
          target[2] = x*a[1] - y*a[0];
          return this;
      },
      crossVectors: function(target, a, b) {
          target[0] = a[1]*b[2] - a[2]*b[1];
          target[1] = a[2]*b[0] - a[0]*b[2];
          target[2] = a[0]*b[1] - a[1]*b[0];
          return this;
      },
      min: function(target, value) {
          if (target[0] < value) { target[0] = value; }
          if (target[1] < value) { target[1] = value; }
          if (target[2] < value) { target[2] = value; }
          return this;
      },
      max: function(target, value) {
          if (target[0] > value) { target[0] = value; }
          if (target[1] > value) { target[1] = value; }
          if (target[2] > value) { target[2] = value; }
          return this;
      },
      clamp: function(target, min, max) {
          this.min(target, min);
          this.max(target, max);
          return this;
      },
      limit: function(target, min, max) {
          var length = this.length(target);
          if (min !== null && length < min) {
              this.setLength(target, min);
          } else if (max !== null && length > max) {
              this.setLength(target, max);
          }
          return this;
      },
      dot: function(a, b) {
          return a[0]*b[0] + a[1]*b[1] + a[2]*b[2];
      },
      normalise: function(target) {
          return this.divideScalar(target, this.length(target));
      },
      negate: function(target) {
          return this.multiplyScalar(target, -1);
      },
      distanceSquared: function(a, b) {
          var dx = a[0] - b[0];
          var dy = a[1] - b[1];
          var dz = a[2] - b[2];
          return dx*dx + dy*dy + dz*dz;
      },
      distance: function(a, b) {
          return Math.sqrt(this.distanceSquared(a, b));
      },
      lengthSquared: function(a) {
          return a[0]*a[0] + a[1]*a[1] + a[2]*a[2];
      },
      length: function(a) {
          return Math.sqrt(this.lengthSquared(a));
      },
      setLength: function(target, l) {
          var length = this.length(target);
          if (length !== 0 && l !== length) {
              this.multiplyScalar(target, l / length);
          }
          return this;
      }
  };

  /**
   * @object Vector4
   * @author Matthew Wagerfield
   */
  FSS.Vector4 = {
      create: function(x, y, z, w) {
          var vector = new FSS.Array(4);
          this.set(vector, x, y, z);
          return vector;
      },
      set: function(target, x, y, z, w) {
          target[0] = x || 0;
          target[1] = y || 0;
          target[2] = z || 0;
          target[3] = w || 0;
          return this;
      },
      setX: function(target, x) {
          target[0] = x || 0;
          return this;
      },
      setY: function(target, y) {
          target[1] = y || 0;
          return this;
      },
      setZ: function(target, z) {
          target[2] = z || 0;
          return this;
      },
      setW: function(target, w) {
          target[3] = w || 0;
          return this;
      },
      add: function(target, a) {
          target[0] += a[0];
          target[1] += a[1];
          target[2] += a[2];
          target[3] += a[3];
          return this;
      },
      multiplyVectors: function(target, a, b) {
          target[0] = a[0] * b[0];
          target[1] = a[1] * b[1];
          target[2] = a[2] * b[2];
          target[3] = a[3] * b[3];
          return this;
      },
      multiplyScalar: function(target, s) {
          target[0] *= s;
          target[1] *= s;
          target[2] *= s;
          target[3] *= s;
          return this;
      },
      min: function(target, value) {
          if (target[0] < value) { target[0] = value; }
          if (target[1] < value) { target[1] = value; }
          if (target[2] < value) { target[2] = value; }
          if (target[3] < value) { target[3] = value; }
          return this;
      },
      max: function(target, value) {
          if (target[0] > value) { target[0] = value; }
          if (target[1] > value) { target[1] = value; }
          if (target[2] > value) { target[2] = value; }
          if (target[3] > value) { target[3] = value; }
          return this;
      },
      clamp: function(target, min, max) {
          this.min(target, min);
          this.max(target, max);
          return this;
      }
  };

  /**
   * @class Color
   * @author Matthew Wagerfield
   */
  FSS.Color = function(hex, opacity) {
      this.rgba = FSS.Vector4.create();
      this.hex = hex || '#000000';
      this.opacity = FSS.Utils.isNumber(opacity) ? opacity : 1;
      this.set(this.hex, this.opacity);
  };

  FSS.Color.prototype = {
      set: function(hex, opacity) {
          hex = hex.replace('#', '');
          var size = hex.length / 3;
          this.rgba[0] = parseInt(hex.substring(size*0, size*1), 16) / 255;
          this.rgba[1] = parseInt(hex.substring(size*1, size*2), 16) / 255;
          this.rgba[2] = parseInt(hex.substring(size*2, size*3), 16) / 255;
          this.rgba[3] = FSS.Utils.isNumber(opacity) ? opacity : this.rgba[3];
          return this;
      },
      hexify: function(channel) {
          var hex = Math.ceil(channel*255).toString(16);
          if (hex.length === 1) { hex = '0' + hex; }
          return hex;
      },
      format: function() {
          var r = this.hexify(this.rgba[0]);
          var g = this.hexify(this.rgba[1]);
          var b = this.hexify(this.rgba[2]);
          this.hex = '#' + r + g + b;
          return this.hex;
      }
  };

  /**
   * @class Object
   * @author Matthew Wagerfield
   */
  FSS.Object = function() {
      this.position = FSS.Vector3.create();
  };

  FSS.Object.prototype = {
      setPosition: function(x, y, z) {
          FSS.Vector3.set(this.position, x, y, z);
          return this;
      }
  };

  /**
   * @class Light
   * @author Matthew Wagerfield
   */
  FSS.Light = function(ambient, diffuse) {
      FSS.Object.call(this);
      this.ambient = new FSS.Color(ambient);
      this.diffuse = new FSS.Color(diffuse);
      this.ray = FSS.Vector3.create();
  };

  FSS.Light.prototype = Object.create(FSS.Object.prototype);

  /**
   * @class Vertex
   * @author Matthew Wagerfield
   */
  FSS.Vertex = function(x, y, z) {
      this.position = FSS.Vector3.create(x, y, z);
  };

  /**
   * @class Triangle
   * @author Matthew Wagerfield
   */
  FSS.Triangle = function(a, b, c) {
      this.a = a || new FSS.Vertex();
      this.b = b || new FSS.Vertex();
      this.c = c || new FSS.Vertex();
      this.vertices = [this.a, this.b, this.c];
      this.u = FSS.Vector3.create();
      this.v = FSS.Vector3.create();
      this.centroid = FSS.Vector3.create();
      this.normal = FSS.Vector3.create();
      this.color = new FSS.Color();
      this.polygon = document.createElementNS(FSS.SVGNS, 'polygon');
      this.polygon.setAttributeNS(null, 'stroke-linejoin', 'round');
      this.polygon.setAttributeNS(null, 'stroke-miterlimit', '1');
      this.polygon.setAttributeNS(null, 'stroke-width', '1');
      this.computeCentroid();
      this.computeNormal();
  };

  FSS.Triangle.prototype = {
      computeCentroid: function() {
          this.centroid[0] = this.a.position[0] + this.b.position[0] + this.c.position[0];
          this.centroid[1] = this.a.position[1] + this.b.position[1] + this.c.position[1];
          this.centroid[2] = this.a.position[2] + this.b.position[2] + this.c.position[2];
          FSS.Vector3.divideScalar(this.centroid, 3);
          return this;
      },
      computeNormal: function() {
          FSS.Vector3.subtractVectors(this.u, this.b.position, this.a.position);
          FSS.Vector3.subtractVectors(this.v, this.c.position, this.a.position);
          FSS.Vector3.crossVectors(this.normal, this.u, this.v);
          FSS.Vector3.normalise(this.normal);
          return this;
      }
  };

  /**
   * @class Geometry
   * @author Matthew Wagerfield
   */
  FSS.Geometry = function() {
      this.vertices = [];
      this.triangles = [];
      this.dirty = false;
  };

  FSS.Geometry.prototype = {
      update: function() {
          if (this.dirty) {
              var t,triangle;
              for (t = this.triangles.length - 1; t >= 0; t--) {
                  triangle = this.triangles[t];
                  triangle.computeCentroid();
                  triangle.computeNormal();
              }
              this.dirty = false;
          }
          return this;
      }
  };

  /**
   * @class Plane
   * @author Matthew Wagerfield, modified by Maksim Surguy to implement Delaunay triangulation
   */
  FSS.Plane = function(width, height, howmany) {
      FSS.Geometry.call(this);
      this.width = width || 100;
      this.height = height || 100;

      // Cache Variables
      var x, y, vertices = new Array(howmany),
          offsetX = this.width * -0.5,
          offsetY = this.height * 0.5;

      for(i = vertices.length; i--; ) {
          x =  offsetX + Math.random()*width;
          y =  offsetY - Math.random()*height;

          vertices[i] = [x, y];
      }

      // Generate additional points on the perimeter so that there are no holes in the pattern
      vertices.push([offsetX, offsetY]);
      vertices.push([offsetX + width/2, offsetY]);
      vertices.push([offsetX + width, offsetY]);
      vertices.push([offsetX + width, offsetY - height/2]);
      vertices.push([offsetX + width, offsetY - height]);
      vertices.push([offsetX + width/2, offsetY - height]);
      vertices.push([offsetX, offsetY - height]);
      vertices.push([offsetX, offsetY - height/2]);

      // Generate additional randomly placed points on the perimeter
      for (var i = 6; i >= 0; i--) {
          vertices.push([ offsetX + Math.random()*width, offsetY]);
          vertices.push([ offsetX, offsetY - Math.random()*height]);
          vertices.push([ offsetX + width, offsetY - Math.random()*height]);
          vertices.push([ offsetX + Math.random()*width, offsetY-height]);
      }

      // Create an array of triangulated coordinates from our vertices
      var triangles = Delaunay.triangulate(vertices);

      for(i = triangles.length; i; ) {
          --i;
          var p1 = [Math.ceil(vertices[triangles[i]][0]), Math.ceil(vertices[triangles[i]][1])];
          --i;
          var p2 = [Math.ceil(vertices[triangles[i]][0]), Math.ceil(vertices[triangles[i]][1])];
          --i;
          var p3 = [Math.ceil(vertices[triangles[i]][0]), Math.ceil(vertices[triangles[i]][1])];

          var t1 = new FSS.Triangle(new FSS.Vertex(p1[0],p1[1]), new FSS.Vertex(p2[0],p2[1]), new FSS.Vertex(p3[0],p3[1]));
          this.triangles.push(t1);
      }
  };

  FSS.Plane.prototype = Object.create(FSS.Geometry.prototype);

  /**
   * @class Material
   * @author Matthew Wagerfield
   */
  FSS.Material = function(ambient, diffuse) {
      this.ambient = new FSS.Color(ambient || '#444444');
      this.diffuse = new FSS.Color(diffuse || '#FFFFFF');
      this.slave = new FSS.Color();
  };

  /**
   * @class Mesh
   * @author Matthew Wagerfield
   */
  FSS.Mesh = function(geometry, material) {
      FSS.Object.call(this);
      this.geometry = geometry || new FSS.Geometry();
      this.material = material || new FSS.Material();
      this.side = FSS.FRONT;
      this.visible = true;
  };

  FSS.Mesh.prototype = Object.create(FSS.Object.prototype);

  FSS.Mesh.prototype.update = function(lights, calculate) {
      var t,triangle, l,light, illuminance;

      // Update Geometry
      this.geometry.update();

      // Calculate the triangle colors
      if (calculate) {

          // Iterate through Triangles
          for (t = this.geometry.triangles.length - 1; t >= 0; t--) {
              triangle = this.geometry.triangles[t];

              // Reset Triangle Color
              FSS.Vector4.set(triangle.color.rgba);

              // Iterate through Lights
              for (l = lights.length - 1; l >= 0; l--) {
                  light = lights[l];

                  // Calculate Illuminance
                  FSS.Vector3.subtractVectors(light.ray, light.position, triangle.centroid);
                  FSS.Vector3.normalise(light.ray);
                  illuminance = FSS.Vector3.dot(triangle.normal, light.ray);
                  if (this.side === FSS.FRONT) {
                      illuminance = Math.max(illuminance, 0);
                  } else if (this.side === FSS.BACK) {
                      illuminance = Math.abs(Math.min(illuminance, 0));
                  } else if (this.side === FSS.DOUBLE) {
                      illuminance = Math.max(Math.abs(illuminance), 0);
                  }

                  // Calculate Ambient Light
                  FSS.Vector4.multiplyVectors(this.material.slave.rgba, this.material.ambient.rgba, light.ambient.rgba);
                  FSS.Vector4.add(triangle.color.rgba, this.material.slave.rgba);

                  // Calculate Diffuse Light
                  FSS.Vector4.multiplyVectors(this.material.slave.rgba, this.material.diffuse.rgba, light.diffuse.rgba);
                  FSS.Vector4.multiplyScalar(this.material.slave.rgba, illuminance);
                  FSS.Vector4.add(triangle.color.rgba, this.material.slave.rgba);
              }

              // Clamp & Format Color
              FSS.Vector4.clamp(triangle.color.rgba, 0, 1);
          }
      }
      return this;
  };

  /**
   * @class Scene
   * @author Matthew Wagerfield
   */
  FSS.Scene = function() {
      this.meshes = [];
      this.lights = [];
  };

  FSS.Scene.prototype = {
      add: function(object) {
          if (object instanceof FSS.Mesh && !~this.meshes.indexOf(object)) {
              this.meshes.push(object);
          } else if (object instanceof FSS.Light && !~this.lights.indexOf(object)) {
              this.lights.push(object);
          }
          return this;
      }
  };

  /**
   * @class Renderer
   * @author Matthew Wagerfield
   */
  FSS.Renderer = function() {
      this.width = 0;
      this.height = 0;
      this.halfWidth = 0;
      this.halfHeight = 0;
  };

  FSS.Renderer.prototype = {
      setSize: function(width, height) {
          if (this.width === width && this.height === height) return;
          this.width = width;
          this.height = height;
          this.halfWidth = this.width * 0.5;
          this.halfHeight = this.height * 0.5;
          return this;
      },
      clear: function() {
          return this;
      },
      render: function(scene) {
          return this;
      }
  };

  /**
   * @class Canvas Renderer
   * @author Matthew Wagerfield
   */
  FSS.CanvasRenderer = function() {
      FSS.Renderer.call(this);
      this.element = document.createElement('canvas');
      this.element.style.display = 'block';
      this.context = this.element.getContext('2d');
      this.setSize(this.element.width, this.element.height);
  };

  FSS.CanvasRenderer.prototype = Object.create(FSS.Renderer.prototype);

  FSS.CanvasRenderer.prototype.setSize = function(width, height) {
      FSS.Renderer.prototype.setSize.call(this, width, height);
      this.element.width = width;
      this.element.height = height;
      this.context.setTransform(1, 0, 0, -1, this.halfWidth, this.halfHeight);
      return this;
  };

  FSS.CanvasRenderer.prototype.clear = function() {
      FSS.Renderer.prototype.clear.call(this);
      this.context.clearRect(-this.halfWidth, -this.halfHeight, this.width, this.height);
      return this;
  };

  FSS.CanvasRenderer.prototype.render = function(scene) {
      FSS.Renderer.prototype.render.call(this, scene);
      var m,mesh, t,triangle, color;

      // Clear Context
      this.clear();

      // Configure Context
      this.context.lineJoin = 'round';
      this.context.lineWidth = 1;

      // Update Meshes
      for (m = scene.meshes.length - 1; m >= 0; m--) {
          mesh = scene.meshes[m];
          if (mesh.visible) {
              mesh.update(scene.lights, true);

              // Render Triangles
              for (t = mesh.geometry.triangles.length - 1; t >= 0; t--) {
                  triangle = mesh.geometry.triangles[t];
                  color = triangle.color.format();
                  this.context.beginPath();
                  this.context.moveTo(triangle.a.position[0], triangle.a.position[1]);
                  this.context.lineTo(triangle.b.position[0], triangle.b.position[1]);
                  this.context.lineTo(triangle.c.position[0], triangle.c.position[1]);
                  this.context.closePath();
                  this.context.strokeStyle = color;
                  this.context.fillStyle = color;
                  this.context.stroke();
                  this.context.fill();
              }
          }
      }
      return this;
  };

  //------------------------------
  // Mesh Properties
  //------------------------------
  var MESH = {
      width: 1.2,
      height: 1.2,
      slices: 250,
      ambient: '#999999',
      diffuse: '#AAAAAA'
  };

  //------------------------------
  // Light Properties
  //------------------------------
  var LIGHT = {
      count: 1,
      xPos : 0,
      yPos : 200,
      zOffset: 100,
      ambient: '#1A4568',
      diffuse: '#393D42',
      pickedup :true,
      proxy : false
  };

  //------------------------------
  // Render Properties
  //------------------------------
  var CANVAS = 'canvas';
  var RENDER = {
      renderer: CANVAS
  };

  //------------------------------
  // Global Properties
  //------------------------------
  var center = FSS.Vector3.create();
  var container = document.getElementById('angle-bg');
  var output = document.getElementById('angle-bg');
  var renderer, scene, mesh, geometry, material;
  var canvasRenderer;
  var gui;

  //------------------------------
  // Methods
  //------------------------------
  function initialise() {
      createRenderer();
      createScene();
      createMesh();
      addLight();
      addEventListeners();
      resize(container.offsetWidth, container.offsetHeight);
      animate();
  }

  function createRenderer() {
      canvasRenderer = new FSS.CanvasRenderer();
      setRenderer(RENDER.renderer);
  }

  function setRenderer(index) {
      renderer = canvasRenderer;
      renderer.setSize(container.offsetWidth, container.offsetHeight);
      output.appendChild(renderer.element);
  }

  function createScene() {
      scene = new FSS.Scene();
  }

  function createMesh() {
      renderer.clear();
      geometry = new FSS.Plane(MESH.width * renderer.width, MESH.height * renderer.height, MESH.slices);
      material = new FSS.Material(MESH.ambient, MESH.diffuse);
      mesh = new FSS.Mesh(geometry, material);
      scene.add(mesh);
  }

  // Add a single light
  function addLight() {
      renderer.clear();
      var light = new FSS.Light(LIGHT.ambient, LIGHT.diffuse);
      light.ambientHex = light.ambient.format();
      light.diffuseHex = light.diffuse.format();
      light.setPosition(LIGHT.xPos, LIGHT.yPos, LIGHT.zOffset);
      scene.add(light);
      LIGHT.proxy = light;
      LIGHT.pickedup = true;
  }

  // Resize canvas
  function resize(width, height) {
      renderer.setSize(width, height);
      FSS.Vector3.set(center, renderer.halfWidth, renderer.halfHeight);
      createMesh();
  }

  function animate() {
      render();
      requestAnimationFrame(animate);
  }

  function render() {
      renderer.render(scene);
  }

  function addEventListeners() {
      window.addEventListener('resize', onWindowResize);
      window.addEventListener('mousemove', onMouseMove);
  }

  //------------------------------
  // Callbacks
  //------------------------------

  function onWindowResize(event) {
      resize(container.offsetWidth, container.offsetHeight);
      render();
  }

  function onMouseMove(event) {
      if(LIGHT.pickedup){
          LIGHT.xPos = event.x - renderer.width/2;
          LIGHT.yPos = renderer.height/2 -event.y;
          LIGHT.proxy.setPosition(LIGHT.xPos, LIGHT.yPos, LIGHT.proxy.position[2]);
      }
  }

  initialise();


})();

};


new Vue({
  el: '#app',
  data: {
    tWidth: 20,
    gap: 0,
    rows: [],
  },
  methods: {
    rTransform: (function () {
      const cache = {};
      return function (i) {
        if (cache[i] !== undefined) return cache[i];

        const offset = i % 2 === 0 ? 0 : (this.tWidth + this.gap) * -1;
        const result = `translate(${offset} ${(i * this.halfWidthAndGap) - this.tWidth / 2})`;
        cache[i] = result;
        return result;
      };
    })(),
    tTransform: (function () {
      const cache = {};
      return function (i) {
        if (cache[i] !== undefined) return cache[i];

        const offset = i % 2 === 0 ? 0 : this.tWidth;
        const translate = `translate(${i * (this.tWidth + this.gap) + offset} 0)`;
        const scale = i % 2 === 0 ? 'scale(1)' : 'scale(-1, 1)';
        const result = `${translate} ${scale}`;
        cache[i] = result;
        return result;
      };
    })(),
  },
  mounted() {
    this.halfWidthAndGap = this.tWidth / 2 + this.gap;

    while (this.rows.length < 84) {
      const row = [];

      while (row.length < 46) {
        row.push({
          colorCode: Math.floor(Math.random() * 4),
          fadeModifier: Math.random() * 4 + 1,
        });
      }

      this.gap = this.tWidth * 0.1;
      this.rows.push(row);
    }
  },
});


// (function(e) {
//       e.fn.circle = function(t) {
//           var n = e.extend({
//               speed: "5000"
//           }, t);
//           return this.each(function() {
//               function t() {
//                   var e = i.find("li.block.active").index();
//                   c.removeClass("active"), c.eq(e).addClass("active")
//               }

//               function o() {
//                   var n;
//                   i.addClass("disable-hover"), i.stop(!0, !0).animate({
//                       rotatedeg: p.deg += p.step
//                   }, {
//                       duration: 400,
//                       step: function(t) {
//                           t >= 360 ? t -= 360 : t <= -360 && (t += 360), e(this).css("transform", "rotate(" + t + "deg)"), e(this).css("-webkit-transform", "rotate(" + t + "deg)")
//                       },
//                       complete: function() {
//                           p.active = i.find("li.active").removeClass("active"), "right" == p.direction && p.step == d && (p.active.prev() && p.active.prev().length ? (n = p.active.prev().index(), p.active.prev().addClass("active")) : (p.active.siblings(":last-child").addClass("active"), n = 9)), "left" == p.direction && p.step == u && (p.active.next() && p.active.next().length ? (n = p.active.next().index(), p.active.next().addClass("active")) : (p.active.siblings(":first-child").addClass("active"), n = 0)), i.is(":animated"), i.removeClass("disable-hover"), t()
//                       }
//                   }, "ease")
//               }

//               function r() {
//                   i.addClass("disable-hover"), 
//                     i.stop(!0, !0).animate(
//                     {
//                       rotatedeg: p.deg += p.step
//                     }, 
//                     {
//                       duration: 400,
//                       step: function(t) {
//                           t >= 360 ? t -= 360 : t <= -360 && (t += 360), 
//                             e(this).css("transform", "rotate(" + t + "deg)"), 
//                             e(this).css("-webkit-transform", "rotate(" + t + "deg)")
//                       },
//                       complete: function() {
//                           p.active = i.find("li.active"), 
//                             i.is(":animated"), 
//                             i.removeClass("disable-hover")
//                       }
//                   }, "ease")
//               }
//               var i = e(this),
//                   s = i.find("li").length,
//                   a = i.find(" > li .icon"),
//                   l = "count" + s,
//                   u = 0,
//                   c = i.next().find(".animate"),
//                   p = {
//                       duration: n.speed,
//                       deg: 0,
//                       step: u,
//                       active: i.find("li.active"),
//                       direction: "right"
//                   };
//               switch (s) {
//                   case 10:
//                       u = -36;
//                       break;
//                   case 9:
//                       u = -40;
//                       break;
//                   case 8:
//                       u = -45;
//                       break;
//                   case 7:
//                       u = -51.5;
//                       break;
//                   case 6:
//                       u = -60;
//                       break;
//                   case 5:
//                       u = -72;
//                       break;
//                   case 4:
//                       u = 20;
//                       break;
//                   case 3:
//                       u = -120;
//                       break;
//                   case 2:
//                       u = -180;
//                       break;
//                   case 1:
//                       u = -360
//               }
//               i.addClass(l);
//               var d = u - 2 * u;
//               i.find("> li").first().addClass("active"),
//                 i.find("> li").first().find("a").attr("href"),
//                 c.eq(0).addClass("active"), 
//                 e(a).on("click", function() {
//                   var n = e(this).parent().index() - i.find("li.active").index();
//                   i.children("li").removeClass("active"), 
//                     e(this).parent().addClass("active"), 
//                     p.step = -n * d, n * d >= 288 && (p.step = -n * d + 360), 
//                     n * d <= -288 && (p.step = -n * d - 360), 
//                     r(), p.step = u, p.direction = "left", t()
//               });
//               var f = i.parent().find("div.next"),
//                   h = i.parent().find("div.prev");
//               f.on("click", function() {
//                   i.is(":animated") || (p.direction = "left", p.step = u, o())
//               }), h.on("click", function() {
//                   i.is(":animated") || (p.direction = "right", p.step = d, o())
//               })
//           })
//       }
//   }(jQuery));















if($('.et-hero-tabs').length) {
class StickyNavigation {
  
  constructor() {
    this.currentId = null;
    this.currentTab = null;
    this.tabContainerHeight = 70;
    let self = this;
    $('.et-hero-tab').click(function(event) { 
      self.onTabClick(event, $(this)); 
    });
    $(window).scroll(() => { this.onScroll(); });
    $(window).resize(() => { this.onResize(); });
  }
  
  onTabClick(event, element) {
    event.preventDefault();
    let scrollTop = $(element.attr('href')).offset().top - this.tabContainerHeight + 1;
    $('html, body').animate({ scrollTop: scrollTop }, 600);
  }
  
  onScroll() {
    this.checkTabContainerPosition();
    this.findCurrentTabSelector();
  }
  
  onResize() {
    if(this.currentId) {
      this.setActiveTabClass();
    }
  }
  
 checkTabContainerPosition() {
    let offset = $('.et-hero-tabs').offset().top + $('.et-hero-tabs').height() - this.tabContainerHeight;
    let mainOffset = $('.et-main').offset().top + $('.et-main').height() - this.tabContainerHeight;
    
    if($(window).scrollTop() > offset) {
      if ($(window).scrollTop() + this.tabContainerHeight > mainOffset) {
        $('.et-hero-tabs-container').removeClass('et-hero-tabs-container--top');
        $('.et-hero-tabs-container').addClass('et-hero-tabs-container--bottom');
      } else {
        $('.et-hero-tabs-container').removeClass('et-hero-tabs-container--bottom');
        $('.et-hero-tabs-container').addClass('et-hero-tabs-container--top');
      }
    } else {
      $('.et-hero-tabs-container').removeClass('et-hero-tabs-container--top');
    }
  }
  
  findCurrentTabSelector() {
    let newCurrentId;
    let newCurrentTab;
    let self = this;
    $('.et-hero-tab').each(function() {
      let id = $(this).attr('href');
      let offsetTop = $(id).offset().top - self.tabContainerHeight;
      let offsetBottom = $(id).offset().top + $(id).height() - self.tabContainerHeight;
      if($(window).scrollTop() > offsetTop && $(window).scrollTop() < offsetBottom) {
        newCurrentId = id;
        newCurrentTab = $(this);
      }
    });
    if(this.currentId != newCurrentId || this.currentId === null) {
      this.currentId = newCurrentId;
      this.currentTab = newCurrentTab;
      this.setActiveTabClass();
    }
  }
  
  setActiveTabClass() {
    $('.et-hero-tab').removeClass('active');
    if(this.currentTab) {
      this.currentTab.addClass('active');
    }
  }
}

new StickyNavigation();
}

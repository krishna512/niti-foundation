jQuery(window).on('elementor/frontend/init', function () {
  if (typeof elementorFrontend === 'undefined') {
    return;
  }

  elementorFrontend.on('components:init', function () {
    elementorFrontend.utils.anchors.setSettings('selectors.targets', '.dummy-selector');
  });
});

jQuery(function ($) {
  /**
   * =================================================
   *  Accordion side content
   * =================================================
   */
  $('.accordion .accordion-title').on('click', function () {
    $(this).closest('.accordion').toggleClass('active');
  });

  /**
   * =================================================
   *  Sticky Header
   * =================================================
   */

  $(function () {
    const mainHeader = $('header');
    let scrolling = false;
    let previousTop = 0;

    function scrollTrigger() {
      const scrollTop = $(window).scrollTop();

      mainHeader.toggleClass('scrolled', scrollTop > 5);

      checkSimpleNavigation(scrollTop);
    }

    function checkSimpleNavigation(currentTop) {
      const scrollDelta = 1;
      const scrollOffset = 0;
      const isScrollingUp = currentTop < previousTop;

      if (currentTop === 0 || isScrollingUp) {
        mainHeader.removeClass('is-hidden');
      } else if (currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
        mainHeader.addClass('is-hidden');
      }

      previousTop = currentTop;
    }

    function autoHideHeader() {
      const currentTop = $(window).scrollTop();
      checkSimpleNavigation(currentTop);
      scrolling = false;
    }

    $(window).on('load scroll', function () {
      scrollTrigger();
      if (!scrolling) {
        scrolling = true;
        !window.requestAnimationFrame ? setTimeout(autoHideHeader, 0) : requestAnimationFrame(autoHideHeader);
      }
    });
  });

  /**
   * =================================================
   * Sticky navbar
   * =================================================
   */

  $(function () {
    const navItem = $('.nav-item');
    if ($(navItem).length > 0) {
      let navItemOffset = navItem.offset().top;
      let navItemHeight = navItem.outerHeight();
      let navOffsetValue = 0;

      function updateStickyNav() {
        let scrollPos = $(window).scrollTop();

        if (scrollPos >= navItemOffset - navItemHeight) {
          navItem.addClass('sticky');
        } else {
          navItem.removeClass('sticky');
        }
      }

      function navHeight() {
        if (navItem.hasClass('sticky')) {
          navOffsetValue = navItem.outerHeight();
        } else {
          navOffsetValue = window.innerWidth < 640 ? 80 : 80;
        }

        return navOffsetValue;
      }

      function updateActiveClass() {
        let cutoff = $(window).scrollTop();
        let totalHeight = $('header').outerHeight() + navHeight();

        $('.nav-items').each(function () {
          if ($(this).offset().top + $(this).height() - totalHeight > cutoff) {
            $('.nav-items').removeClass('current');
            $(this).addClass('current');
            let currSection = $(this).attr('id');

            $('.nav-item .elementor-icon-list-item a').removeClass('active');
            $('a[href="#' + currSection + '"]').addClass('active');
            return false;
          }
        });
      }

      $(navItem).on('click', '.elementor-icon-list-item a', function (e) {
        e.preventDefault();
        let totalHeight = $('header').outerHeight() + navHeight();

        let target = $(this).attr('href');

        if ($(target).length) {
          $('html, body').animate(
            {
              scrollTop: $(target).offset().top - totalHeight,
            },
            600
          );
        }
      });

      $(window).on('scroll', function () {
        navHeight();
        updateStickyNav();
        updateActiveClass();
      });

      navHeight();
      updateStickyNav();
      updateActiveClass();
    }
  });

  /**
   * =================================================
   * Calcuate the height of Header and pass to sticky nav
   * =================================================
   */

  $(function () {
    let stickyHeader = $('header');
    let tabMenu = $('.nav-item');

    function adjustTabMenuPosition() {
      let headerHeight = stickyHeader.height();

      if (stickyHeader.hasClass('scrolled') && tabMenu.hasClass('sticky')) {
        tabMenu.addClass('sticky-tab').css('top', headerHeight + 'px');
      } else {
        tabMenu.removeClass('sticky-tab').css('top', '0px');
      }
    }

    $(window).on('resize', function () {
      adjustTabMenuPosition();
    });

    $(window).on('scroll', function () {
      adjustTabMenuPosition();
    });

    adjustTabMenuPosition();
  });

  /**
   * =================================================
   * place this placeholder ath bottom of the code
   *
   * @if no bugs this code will appear in console
   * =================================================
   */
  console.log('App Loaded Successfully.');
});

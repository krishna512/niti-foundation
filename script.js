jQuery(function ($) {
  /**
   * ======================================================
   * Click Event
   *
   * Highllight the menu until page redirects
   * ======================================================
   */
  $(document).on("click", "a", function () {
    highlightCurrentMenuItem($(this));
  });

  // Call the highlightCurrentMenuItem function on page load
  highlightCurrentMenuItem();

  /**
   * ======================================================
   *  Highlight Current menu item
   *
   * @param {*} clickedLink
   * ======================================================
   */
  function highlightCurrentMenuItem(clickedLink) {
    // Get the current URL
    let currentURL = window.location.href;

    // Remove existing 'current-menu-item' class from all menu items
    $(
      ".e-n-menu-heading .elementor-widget-container .elementor-icon-list-items > .elementor-icon-list-item .menu-item"
    ).removeClass("current-menu-item");

    // Add 'current-menu-item' class to the corresponding menu item
    let $currentMenuItem;

    if (clickedLink) {
      // If a link is clicked, use its href attribute
      $currentMenuItem = $(
        '.elementor-widget-container .elementor-icon-list-items > .elementor-icon-list-item a[href="' +
          clickedLink.attr("href") +
          '"]'
      ).parent();
    } else {
      // If not clicked, use the current URL
      $(
        ".elementor-widget-container .elementor-icon-list-items > .elementor-icon-list-item a"
      ).each(function () {
        if (this.href === currentURL) {
          $currentMenuItem = $(this).parent();
        }
      });
    }

    if ($currentMenuItem) {
      $currentMenuItem.addClass("current-menu-item");
    }
  }

  /**
   * =================================================
   * place this placeholder ath bottom of the code
   *
   * @if no bugs this code will appear in console
   * =================================================
   */
  console.log("App Loaded Successfully.");
});

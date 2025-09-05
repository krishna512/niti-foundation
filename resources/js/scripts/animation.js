jQuery(function ($) {
  /**
   * =================================================
   * ScrollReveal Animation
   * =================================================
   */

  $(function () {
    ScrollReveal().reveal('.animate-wrapper .e-loop-item', {
      interval: 180,
      duration: 400,
      origin: 'bottom',
      opacity: 0,
      distance: '20%',
      easing: 'ease-in-out',
    });
  });
  /**
   * =================================================
   * place this placeholder ath bottom of the code
   *
   * @if no bugs this code will appear in console
   * =================================================
   */
  console.log('animate Loaded Successfully.');
});

<?php
/**
 * ==================================================
 * Enqueue 
 * ==================================================
 */
class Theme
{

    public function __construct()
    {

        // enqueue admin styles scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles_scripts'], 20);

    }

    /**
     * @return void
     * @throws Exception
     */
    public function enqueue_styles_scripts(): void
    {

        /**
         * Custom Scroll bar
         */
        wp_enqueue_style('overlayscrollbars', 'https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.9.1/styles/overlayscrollbars.min.css', [], null, 'screen');
        wp_enqueue_script('overlayscrollbars', 'https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.9.1/browser/overlayscrollbars.browser.es6.min.js', [], null, true);

        /**
         * Reveal Animation Cdn 
         */
        wp_enqueue_script('scrollReveal', 'https://unpkg.com/scrollreveal', [], null, true);

        /**
         * Gsap Animation CDN
         */
        // wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], null, true);
        // wp_enqueue_script('scrollTrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', [], null, true);

        // enqueue the Vite module
        Vite::enqueue_module();

        // enqueue theme-style-css into our head
        wp_enqueue_style('theme-style', Vite::asset('resources/scss/main.scss'), [], null, 'screen');



        // enqueue theme-script-js into our head (change false to true for footer)
        wp_enqueue_script('theme-script', Vite::asset('resources/js/app.js'), ['jquery'], null, true);

        // Live filter resources
        // wp_register_script('form-filter', Vite::asset('resources/js/filter-form.js'), ['jquery'], null, true);

        // wp_register_style('form-filter', Vite::asset('resources/scss/filter-form.scss'), [], null, 'screen');

        // single event page
        // wp_register_style('single-event', Vite::asset('resources/scss/event-single.scss'), [], null, 'screen');


        /**
         * Fix for elementor editor
         */
        if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
            wp_enqueue_style('form-filter');
            wp_enqueue_script('form-filter');

            wp_enqueue_style('single-event');

        }

        // update html script type to module wp hack
        Vite::script_type_module('theme-script');
    }

}

new Theme();
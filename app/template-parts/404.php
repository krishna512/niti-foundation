<?php

/**
 * error404 page template part
 * @package drschool
 */

?>

<div class="drschool-error404">
    <div
        class="content-wrap page-404 min-h-[calc(100vh_-_74px)] flex flex-col items-center justify-center text-center relative">
        <div
            class="content-404-main inline-flex items-center relative uppercase text-[128px] sm:text-[142px] leading-[0] font-bold">
            <span>4</span>
            <span class="relative">
                <div class=" text-2xl sm:text-[26px] leading-[0] absolute top-0 left-0 float-animation">
                    <?php echo useSvg('cloud'); ?>
                </div>
                <div class="text-[102px] sm:text-[121px] leading-[0]"><?php echo useSvg('404-main'); ?> </div>
            </span>
            <span>4</span>
        </div>

        <div class="">

            <h2 class="leading-[1.36] mt-3">Page not found
            </h2>
            <p class="text-sm sm:text-base text-g-70">Sorry, we can't find the page you're looking for.</p>


            <?php
            $args = [
                'text' => 'Back to Home',
                'link' => '/home',
                'class_name' => ' mt-4',
                'button_type' => 'primary',
            ];
            echo button_layout($args);
            ?>
            
        </div>

        <!-- Background Image -->
        
</div>
<?php

/**
 * search page template part
 * @package drschool
 */

$GET_search = (isset($_GET['s'])) ? $_GET['s'] : '';
$excerpt = get_the_excerpt();
?>

<!-- New -->

<div class="search-archive container pt-[60px] sm:pt-24 pb-1">
    <div class="mx-auto max-w-[808px]">
        <div class="grid gap-5 sm:gap-7 mb-9 sm:mb-12">

            <h2 class="flex gap-2 sm:gap-3 items-center justify-center">
                <span class="text-[6px] sm:text-[10px] leading-[0] items-center opacity-50">
                    <?php echo useSvg('wave'); ?></span>
                Search Results
                <span class="text-[6px] sm:text-[10px] leading-[0] opacity-50"> <?php echo useSvg('wave'); ?> </span>
            </h2>

            <div class="search-result">
                <div class="w-full h-full relative">
                    <form role="search" id="search-form" action="<?php echo home_url(); ?>" method="get"
                        class="search-form w-full">
                        <div
                            class=" search__form--wrapper flex overflow-hidden border border-o-10 rounded-[42px] shadow-searchShadow">
                            <input type="search" class="w-full pl-9 pr-4 text-sm focus-visible:outline-0"
                                placeholder="Search..." aria-label="search" name="s" id="search-input"
                                value="<?php echo $GET_search; ?>">
                            <button
                                class="shrink-0 bg-orange   hover:bg-o-40 cursor-pointer search-button  py-3  md:py-4   px-6 overflow-hidden transition-all duration-[0.2s] ease-in-out">
                                <span class="text-sm text-white sm:min-w-[125px] block"> Search </span>
                                <button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <div class="search-contain">
            <div id="filter-area">
                <?php
                if (have_posts()) {
                    ?>
                    <div class="search-result mb-14 grid gap-4 sm:gap-6">
                        <?php
                        while (have_posts()) {
                            the_post();
                            $id = get_the_ID();
                            ?>
                            <div class="search-item border-b border-g-20 pb-4 sm:pb-6">
                                <div class="text-xs text-orange font-bold">
                                    <?php echo get_post_type_object(get_post_type())->label; ?>
                                </div>
                                <div class="text-xl font-bold text-default">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                </div>

                                <?php if ($excerpt) { ?>
                                    <div class="pt-3 text-sm text-g-70">
                                        <?php echo $excerpt; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="no-result grid gap-8 justify-items-center ">
                        <div class="max-w-[496px] text-center">
                            <h5 class="leading-[1.33] max-sm:mb-3">There are no results for this search.</h5>
                            <p class="text-n-50 max-sm:text-sm">

                                No results found matching your search keyword. Please consider trying different keywords.
                            </p>
                        </div>

                        <?php
                        $args = [
                            'text' => 'Back to Home',
                            'link' => '/home',
                            'class_name' => '',
                            'button_type' => 'primary',
                        ];
                        echo button_layout($args);
                        ?>

                    </div>
                    <?php
                }
                echo main_query_pagination();
                ?>
            </div>
        </div>
    </div>
</div>
<?php

/**
 * Default single template part
 * @package drschool
 */
$posttype = ($posttype = get_post_type()) ?: "page";
// echo get_archive_page_heading($posttype);
?>
<div id="<?php echo $posttype; ?>-single" class=" <?php echo get_post_field('post_name') . "-slug"; ?> ">
    <!-- <div class="max-w-[840px] mx-auto main-title">
        <h1 class="heading relative  mt-[51px] mb-4 px-4 font-extrabold">
            <?php echo get_the_title(); ?>
        </h1>
    </div> -->
    <div class="content-wrapper mb-[60px]">
        <?php gutenbergEditorContent(); ?>
    </div>
</div>
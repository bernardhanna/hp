<?php
// Variables
$heading_tag = get_sub_field('content_029_heading_tag') ?: 'h2';
$heading_text = get_sub_field('content_029_heading_text');
$paragraph_text = get_sub_field('content_029_paragraph_text');
$button_link = get_sub_field('content_029_button_link');
$show_svg = get_sub_field('content_029_show_svg');

$heading_text_color = get_sub_field('heading_text_color');
$paragraph_text_color = get_sub_field('paragraph_text_color');

$padding_classes = [];

if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size = get_sub_field('screen_size');
        $padding_top = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');

        $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
        $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
    }
}

$padding_classes = implode(' ', $padding_classes);
$section_id = 'content-029-' . wp_rand();
?>
<style>
<?php echo esc_attr($section_id); ?> .wp_editor p {
    font-size: 20px;
    line-height: 28px;
    }
</style>
<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative">
    <div class="flex flex-col items-center w-full max-w-full py-12 md:pt-5 md:pb-5 mx-auto max-xxl:px-5 <?php echo esc_attr($padding_classes); ?>">
        <div class="flex flex-col lg:flex-row items-center gap-0 sm:gap-5 lg:gap-10 lg:pb-20 mx-auto max-w-[1365px]">

            <?php if (!empty($heading_text)): ?>
                <<?php echo esc_attr($heading_tag); ?> class="my-auto text-5xl font-bold  leading-9 md:leading-[58px] w-full lg:w-1/2 xxl:w-[424px] max-md:max-w-full max-md:text-3xl  text-[#003800]">
                    <?php echo esc_html($heading_text); ?>
                </<?php echo esc_attr($heading_tag); ?>>
            <?php endif; ?>

            <div class="flex flex-col justify-center flex-1 my-auto basis-0 <?php echo esc_attr($paragraph_text_color); ?> max-md:max-w-full">
                <?php if (!empty($paragraph_text)): ?>
                    <div class="text-base sm:text-xl leading-7 max-md:max-w-full wp_editor lg:pl-[1rem] pt-[0.5rem]">
                        <?php echo $paragraph_text; ?>
                        <?php if (!empty($button_link)): ?>
                            <a 
                            href="<?php echo esc_url($button_link['url']); ?>" 
                            target="<?php echo esc_attr($button_link['target']); ?>"
                            <?php if ($button_link['target'] === '_blank'): ?>
                                rel="noopener noreferrer"
                                aria-label="<?php echo esc_attr($button_link['title']); ?> (opens in a new tab)"
                            <?php else: ?>
                                aria-label="<?php echo esc_attr($button_link['title']); ?>"
                            <?php endif; ?>
                                class="flex gap-2 justify-center items-center px-7 py-4 max-w-full text-sm font-semibold leading-none rounded border-2 border-solid transition-colors duration-200 sm:max-w-max border-secondary btn text-tertiary hover:bg-hover active:bg-hover"
                                type="button"
                                aria-label="Learn more about us"
                            >
                                <span>
                                <?php echo esc_html($button_link['title']); ?>
                                <?php if ($button_link['target'] === '_blank'): ?>
                                    <span class="sr-only">(opens in a new tab)</span>
                                <?php endif; ?>
                            </span>
                            <?php if ($show_svg): ?>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" aria-hidden="true" focusable="false">
                                    <path d="M5 12.2109H19M19 12.2109L12 5.21094M19 12.2109L12 19.2109" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            <?php endif; ?>
                            </a>
                       <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>

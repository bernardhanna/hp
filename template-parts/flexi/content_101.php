<?php
// Get ACF field values
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$heading_color = get_sub_field('heading_color');
$paragraph_text = get_sub_field('paragraph_text');
$text_color = get_sub_field('text_color');
$main_image = get_sub_field('main_image');
$background_color = get_sub_field('background_color');

// Padding settings
$padding_classes = [];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size = get_sub_field('screen_size');
        $padding_top = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');

        // Append padding classes with arbitrary values
        $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
        $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
    }
}

// Generate unique section ID
$section_id = 'content-101-' . uniqid();
?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="flex overflow-hidden relative"
    style="background-color: <?php echo esc_attr($background_color); ?>;"
    role="region"
    aria-labelledby="<?php echo esc_attr($section_id); ?>-heading"
>
    <div class="flex flex-col items-center w-full mx-auto max-w-container pt-5 pb-5 max-lg:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
        <div class="grid grid-cols-1 gap-10 items-center w-full max-w-full lg:grid-cols-2">

            <?php if ($main_image): ?>
                <div class="overflow-hidden w-full rounded-none bg-blend-normal md:rounded-tr-[32px] md:rounded-br-[32px]">
                    <img
                        src="<?php echo esc_url($main_image['url']); ?>"
                        alt="<?php echo esc_attr($main_image['alt'] ?: $main_image['title'] ?: 'Featured image'); ?>"
                        class="object-contain w-full max-w-full h-auto"
                        loading="lazy"
                        width="<?php echo esc_attr($main_image['width'] ?: '896'); ?>"
                        height="<?php echo esc_attr($main_image['height'] ?: '540'); ?>"
                    />
                </div>
            <?php endif; ?>

            <div class="w-full">
                <?php if ($heading_text): ?>
                    <<?php echo esc_html($heading_tag); ?>
                        id="<?php echo esc_attr($section_id); ?>-heading"
                        class="mb-4 text-4xl font-bold tracking-tighter leading-none"
                        style="color: <?php echo esc_attr($heading_color); ?>;"
                    >
                        <?php echo esc_html($heading_text); ?>
                    </<?php echo esc_html($heading_tag); ?>>
                <?php endif; ?>

                <?php if ($paragraph_text): ?>
                    <div
                        class="pl-1.5 text-xl leading-7 wp_editor"
                        style="color: <?php echo esc_attr($text_color); ?>;"
                        role="text"
                    >
                        <?php echo wp_kses_post($paragraph_text); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

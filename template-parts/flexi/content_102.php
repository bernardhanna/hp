<?php
// Get ACF field values
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$heading_color = get_sub_field('heading_color');
$paragraph_text = get_sub_field('paragraph_text');
$text_color = get_sub_field('text_color');
$button_link = get_sub_field('button_link');
$button_bg_color = get_sub_field('button_bg_color');
$button_text_color = get_sub_field('button_text_color');
$button_border_color = get_sub_field('button_border_color');
$button_hover_bg_color = get_sub_field('button_hover_bg_color');
$button_hover_text_color = get_sub_field('button_hover_text_color');
$button_hover_border_color = get_sub_field('button_hover_border_color');
$show_button_icon = get_sub_field('show_button_icon');
$background_color = get_sub_field('background_color');

// Handle padding settings
$padding_classes = ['pt-5', 'pb-5'];
if (have_rows('padding_settings')) {
    $padding_classes = [];
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

// Generate unique button class for hover effects
$button_class = 'btn-' . uniqid();

// Generate unique section ID
$section_id = 'content-102-' . uniqid();
?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="flex overflow-hidden relative"
    <?php if ($background_color): ?>
        style="background-color: <?php echo esc_attr($background_color); ?>;"
    <?php endif; ?>
>
    <div class="flex flex-col items-center w-full mx-auto max-w-[1216px] max-xl:px-5 pt-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
        <div class="flex overflow-hidden gap-10 items-start py-5 text-slate-700 max-md:px-5">
            <div class="flex-1 w-full shrink basis-0 max-md:max-w-full">
                <div class="flex flex-col w-full max-md:max-w-full">
                    <?php if ($heading_text): ?>
                        <div class="w-full max-w-full text-4xl font-bold tracking-tighter leading-none max-md:max-w-full">
                            <<?php echo esc_html($heading_tag); ?>
                                class="max-md:max-w-full"
                                <?php if ($heading_color): ?>
                                    style="color: <?php echo esc_attr($heading_color); ?>;"
                                <?php endif; ?>
                            >
                                <?php echo esc_html($heading_text); ?>
                            </<?php echo esc_html($heading_tag); ?>>
                        </div>
                    <?php endif; ?>

                    <?php if ($paragraph_text): ?>
                        <div
                            class="mt-4 text-lg leading-6 max-md:max-w-full wp_editor"
                            <?php if ($text_color): ?>
                                style="color: <?php echo esc_attr($text_color); ?>;"
                            <?php endif; ?>
                        >
                            <?php echo wp_kses_post($paragraph_text); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($button_link): ?>
                        <a
                            href="<?php echo esc_url($button_link['url']); ?>"
                            class="btn flex gap-2 justify-center items-center self-start px-7 py-4 mt-4 text-sm font-semibold leading-none rounded border-2 border-solid w-fit whitespace-nowrap max-md:px-5 <?php echo esc_attr($button_class); ?>"
                            style="
                                color: <?php echo esc_attr($button_text_color); ?>;
                                background-color: <?php echo esc_attr($button_bg_color); ?>;
                                border-color: <?php echo esc_attr($button_border_color); ?>;
                            "
                            aria-label="<?php echo esc_attr($button_link['title']); ?>"
                            target="<?php echo esc_attr($button_link['target'] ?: '_self'); ?>"
                        >
                            <span class="self-stretch my-auto">
                                <?php echo esc_html($button_link['title']); ?>
                            </span>
                            <?php if ($show_button_icon): ?>
                                <img
                                    src="https://api.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/0695eee85b43c97238efbfb62299a133ad49e71f?placeholderIfAbsent=true"
                                    alt=""
                                    class="object-contain self-stretch my-auto w-6 shrink-0 aspect-square"
                                    aria-hidden="true"
                                />
                            <?php endif; ?>
                        </a>

                        <style>
                            .<?php echo esc_attr($button_class); ?>:hover,
                            .<?php echo esc_attr($button_class); ?>:focus {
                                background-color: <?php echo esc_attr($button_hover_bg_color); ?> !important;
                                color: <?php echo esc_attr($button_hover_text_color); ?> !important;
                                border-color: <?php echo esc_attr($button_hover_border_color); ?> !important;
                                outline: 2px solid <?php echo esc_attr($button_hover_border_color); ?> !important;
                                outline-offset: 2px;
                            }
                        </style>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

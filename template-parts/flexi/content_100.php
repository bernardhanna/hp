<?php
// Get all ACF fields
$background_color = get_sub_field('background_color');
$main_image = get_sub_field('main_image');
$subheading_tag = get_sub_field('subheading_tag') ?: 'div';
$subheading_text = get_sub_field('subheading_text');
$subheading_color = get_sub_field('subheading_color');
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$heading_color = get_sub_field('heading_color');
$description_text = get_sub_field('description_text');
$description_color = get_sub_field('description_color');
$bullet_items = get_sub_field('bullet_items');
$bullet_color = get_sub_field('bullet_color');
$button_link = get_sub_field('button_link');
$button_bg_color = get_sub_field('button_bg_color');
$button_text_color = get_sub_field('button_text_color');
$button_hover_bg_color = get_sub_field('button_hover_bg_color');
$button_hover_text_color = get_sub_field('button_hover_text_color');
$button_border_color = get_sub_field('button_border_color');
$button_hover_border_color = get_sub_field('button_hover_border_color');
$button_icon_toggle = get_sub_field('button_icon_toggle');

// Generate padding classes
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

// Unique class for button hover/focus
$button_class = 'btn-' . uniqid();

// Generate unique section ID
$section_id = 'content-100-' . uniqid();
?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="flex overflow-hidden relative w-full"
    style="background-color: <?php echo esc_attr($background_color); ?>;"
    role="region"
    aria-labelledby="<?php echo esc_attr($section_id); ?>-heading">

    <div class="flex flex-col items-center w-full mx-auto max-w-[1472px] py-12 lg:py-24 px-5 <?php echo implode(' ', $padding_classes); ?>">

        <div class="grid grid-cols-1 gap-10 items-center w-full lg:grid-cols-2">

            <!-- Image Section -->
            <?php if ($main_image): ?>
                <div class="flex overflow-hidden justify-center items-center max-h-fit lg:max-h-[524px] bg-white rounded-[32px] w-full xl:max-w-[800px] max-md:px-5">
                    <img
                        src="<?php echo esc_url($main_image['url']); ?>"
                        alt="<?php echo esc_attr($main_image['alt'] ?: $main_image['title'] ?: 'Content image'); ?>"
                        class="object-contain w-full max-w-[543px]"
                        loading="lazy" />
                </div>
            <?php else: ?>
                <div class="flex overflow-hidden justify-center items-center max-h-[524px] bg-white rounded-[32px] w-full max-w-[800px] max-md:px-5">
                    <img
                        src="https://via.placeholder.com/543x122/f0f0f0/666666?text=Upload+Image"
                        alt="Placeholder image"
                        class="object-contain w-full max-w-[543px]"
                        loading="lazy" />
                </div>
            <?php endif; ?>

            <!-- Content Section -->
            <div class="flex flex-col flex-1 w-full">

                <!-- Subheading -->
                <?php if ($subheading_text): ?>
                    <<?php echo esc_html($subheading_tag); ?>
                        class="mb-2 text-lg font-semibold leading-none"
                        style="color: <?php echo esc_attr($subheading_color); ?>;">
                        <?php echo esc_html($subheading_text); ?>
                    </<?php echo esc_html($subheading_tag); ?>>
                <?php endif; ?>

                <!-- Main Heading -->
                <?php if ($heading_text): ?>
                    <<?php echo esc_html($heading_tag); ?>
                        id="<?php echo esc_attr($section_id); ?>-heading"
                        class="mb-6 text-3xl font-bold leading-tight"
                        style="color: <?php echo esc_attr($heading_color); ?>;">
                        <?php echo esc_html($heading_text); ?>
                    </<?php echo esc_html($heading_tag); ?>>
                <?php endif; ?>

                <!-- Description Text -->
                <?php if ($description_text): ?>
                    <div class="mb-6 text-lg leading-6 wp_editor" style="color: <?php echo esc_attr($description_color); ?>;">
                        <?php echo wp_kses_post($description_text); ?>
                    </div>
                <?php endif; ?>

                <!-- Bullet List -->
                <?php if ($bullet_items): ?>
                    <ul class="mb-6 w-full max-w-[536px]" role="list">
                        <?php foreach ($bullet_items as $item): ?>
                            <li class="flex gap-4 items-start pl-4 mb-2">
                                <div class="flex gap-2 items-center pt-2 w-2.5" aria-hidden="true">
                                    <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo esc_attr($bullet_color); ?>;"></div>
                                </div>
                                <span class="flex-1 text-base font-medium leading-6" style="color: <?php echo esc_attr($description_color); ?>;">
                                    <?php echo esc_html($item['bullet_text']); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <!-- CTA Button -->
                <?php if ($button_link): ?>
                    <div class="pt-4">
                        <a href="<?php echo esc_url($button_link['url']); ?>"
                           class="btn inline-flex gap-2 justify-center items-center px-7 py-4 text-sm font-semibold leading-none rounded border-2 border-solid w-fit whitespace-nowrap <?php echo esc_attr($button_class); ?>"
                           style="
                               background-color: <?php echo esc_attr($button_bg_color); ?>;
                               color: <?php echo esc_attr($button_text_color); ?>;
                               border-color: <?php echo esc_attr($button_border_color); ?>;
                               text-decoration: none;"
                           aria-label="<?php echo esc_attr($button_link['title']); ?>"
                           target="<?php echo esc_attr($button_link['target'] ?: '_self'); ?>">

                            <span class="no-underline"><?php echo esc_html($button_link['title']); ?></span>

                            <?php if ($button_icon_toggle): ?>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M5 12H19M19 12L12 5M19 12L12 19"
                                          stroke="currentColor"
                                          stroke-width="2"
                                          stroke-linecap="round"
                                          stroke-linejoin="round" />
                                </svg>
                            <?php endif; ?>
                        </a>

                        <style>
                            .<?php echo esc_attr($button_class); ?>:hover,
                            .<?php echo esc_attr($button_class); ?>:focus {
                                background-color: <?php echo esc_attr($button_hover_bg_color); ?> !important;
                                color: <?php echo esc_attr($button_hover_text_color); ?> !important;
                                border-color: <?php echo esc_attr($button_hover_border_color); ?> !important;
                                outline: 2px solid <?php echo esc_attr($button_hover_bg_color); ?> !important;
                                outline-offset: 2px;
                            }
                        </style>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>

</section>

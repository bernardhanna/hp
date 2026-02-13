<?php
$subheading = get_sub_field('subheading');
$heading = get_sub_field('heading');
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$description = get_sub_field('description');
$image = get_sub_field('image');
$image_url = esc_url($image['url'] ?? '');
$image_alt = esc_attr($image['alt'] ?? 'Team Image');
$image_title = esc_attr($image['title'] ?? '');
$image_radius = get_sub_field('image_border_radius');

$text_color = get_sub_field('text_color') ?: '#1D2939';
$background_color = get_sub_field('background_color') ?: '#ffffff';

$padding_classes = ['pt-5', 'pb-5'];
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
$reverse_layout = get_sub_field('reverse_layout');
$flex_direction = $reverse_layout ? 'lg:flex-row-reverse' : 'lg:flex-row';
?>

<section class="flex overflow-hidden relative">
    <div class="flex <?php echo esc_attr($flex_direction); ?> flex-col items-start lg:items-center w-full mx-auto max-w-[1408px] max-xxl:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
            <div class="my-auto lg:px-12 xl:px-16 min-w-60 max-md:max-w-full max-md:mb-8">
                <header class="w-full text-slate-600 max-md:max-w-full">
                    <?php if ($subheading): ?>
                        <span class="text-lg font-semibold leading-none max-md:max-w-full"><?php echo esc_html($subheading); ?></span>
                    <?php endif; ?>
                    <?php if ($heading): ?>
                        <<?php echo esc_attr($heading_tag); ?> class="text-3xl font-bold leading-tight max-md:max-w-full">
                            <?php echo esc_html($heading); ?>
                        </<?php echo esc_attr($heading_tag); ?>>
                    <?php endif; ?>
                </header>

                <?php if ($description): ?>
                    <div class="w-full max-w-[536px] mt-6 text-[16px] md:text-lg leading-6 text-slate-700 max-md:max-w-full wp_editor">
                        <?php echo $description; ?>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('list_items')): ?>
                    <ul class="mt-6 w-full max-md:max-w-full">
                        <?php while (have_rows('list_items')): the_row(); ?>
                            <li class="flex flex-wrap gap-4 items-start pl-4 w-full max-w-[536px] max-md:max-w-full">
                                <span class="flex gap-2 items-center pt-2 w-2.5">
                                    <span class="my-auto w-2.5">
                                        <span class="flex w-full h-2.5 rounded-full bg-primary fill-lime-primary"></span>
                                    </span>
                                </span>
                                <span class="flex-1 text-base font-medium basis-0 text-slate-700 max-md:max-w-full">
                                    <?php echo esc_html(get_sub_field('item')); ?>
                                </span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <?php if ($image_url): ?>
                <figure class="overflow-hidden my-auto bg-blend-normal min-w-60 h-auto xl:h-[540px] max-w-[800px] rounded-[32px] max-md:max-w-full max-lg:mt-5">
                    <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $image_title; ?>"
                         class="object-contain lg:object-cover mx-auto w-full max-lg:max-h-[400px] h-full" />
                </figure>
            <?php endif; ?>
    </div>
</section>

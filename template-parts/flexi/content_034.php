<?php
$id = uniqid('content-034-');

$image = get_sub_field('image');
$heading = get_sub_field('heading');
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$content = get_sub_field('content');
$button = get_sub_field('button_link');
$show_icon = get_sub_field('show_icon') === 'yes';

$text_color = get_sub_field('text_color');
$background_color = get_sub_field('background_color');
$button_color = get_sub_field('button_color');
$button_hover_color = get_sub_field('button_hover_color');
$image_radius = get_sub_field('image_radius');

$padding_classes = ['pt-5', 'pb-5'];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen = get_sub_field('screen_size');
        $pt = get_sub_field('padding_top');
        $pb = get_sub_field('padding_bottom');
        $padding_classes[] = "{$screen}:pt-[{$pt}rem]";
        $padding_classes[] = "{$screen}:pb-[{$pb}rem]";
    }
}
?>

<section id="<?php echo esc_attr($id); ?>" class="relative flex overflow-hidden" style="background-color: <?php echo esc_attr($background_color); ?>;">
  <div class="flex flex-col items-center w-full mx-auto max-w-container max-lg:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <div class="flex flex-wrap items-center gap-10 py-14 pr-48 bg-white max-md:pr-5 max-sm:pr-2.5">

      <!-- Image -->
      <?php if ($image): ?>
        <div class="w-[896px] max-md:max-w-full">
          <img
            src="<?php echo esc_url($image['url']); ?>"
            alt="<?php echo esc_attr($image['alt'] ?: 'Featured image'); ?>"
            title="<?php echo esc_attr($image['title'] ?: 'Image'); ?>"
            class="w-full <?php echo esc_attr($image_radius); ?> aspect-[1.66] object-contain max-md:max-w-full" />
        </div>
      <?php endif; ?>

      <!-- Content -->
      <div class="flex flex-col flex-1 text-slate-700 max-md:max-w-full max-sm:px-6">
        <<?php echo esc_attr($heading_tag); ?> class="text-4xl font-bold leading-10 tracking-tighter text-slate-600 max-md:max-w-full" style="color: <?php echo esc_attr($text_color); ?>;">
          <?php echo esc_html($heading); ?>
        </<?php echo esc_attr($heading_tag); ?>>

        <div class="mt-4 text-xl leading-7 max-md:max-w-full wp_editor">
          <?php echo wp_kses_post($content); ?>
        </div>

        <?php if (!empty($button['url']) && !empty($button['title'])): ?>
          <div class="pt-4 mt-4 text-sm font-semibold leading-none">
            <a href="<?php echo esc_url($button['url']); ?>"
               target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
               class="flex items-center justify-center gap-2 py-4 transition rounded px-7 min-h-14 w-fit whitespace-nowrap"
               style="background-color: <?php echo esc_attr($button_color); ?>; color: #fff;"
               onmouseover="this.style.backgroundColor='<?php echo esc_attr($button_hover_color); ?>';"
               onmouseout="this.style.backgroundColor='<?php echo esc_attr($button_color); ?>';">
              <span><?php echo esc_html($button['title']); ?></span>
              <?php if ($show_icon): ?>
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/f1af03474eaa64012ae2c002ea85a3b7f923b45c"
                  alt=""
                  aria-hidden="true"
                  class="object-contain w-6 aspect-square" />
              <?php endif; ?>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
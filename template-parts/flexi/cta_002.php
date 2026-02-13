<?php
$image           = get_sub_field('image');
$image_url       = esc_url($image['url'] ?? '');
$image_alt       = esc_attr($image['alt'] ?? '');
$image_title     = esc_attr($image['title'] ?? '');
$heading_tag     = get_sub_field('heading_tag') ?: 'h2';
$heading         = get_sub_field('heading');
$subheading      = get_sub_field('subheading');
$button          = get_sub_field('button');
$button_url      = esc_url($button['url'] ?? '#');
$button_title    = esc_html($button['title'] ?? '');
$button_target   = esc_attr($button['target'] ?? '_self');

$padding_classes = ['pt-5','pb-5'];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $sz = get_sub_field('screen_size');
        $pt = get_sub_field('padding_top');
        $pb = get_sub_field('padding_bottom');
        $padding_classes[] = "{$sz}:pt-[{$pt}rem]";
        $padding_classes[] = "{$sz}:pb-[{$pb}rem]";
    }
}
?>

<section class="flex overflow-hidden relative px-2 w-full lg:pb-16 sm:px-5">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1232px] rounded-[16px]  max-lg:mb-8  bg-primary <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <div class="flex flex-col sm:flex-row items-center w-full gap-10 p-5 md:py-6 md:px-5 lg:px-[3rem] overflow-hidden">
      <?php if ($image_url): ?>
        <div class="flex overflow-hidden flex-col items-center my-auto bg-white rounded-[1000px] w-full max-w-[200px]">
          <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $image_title; ?>" class="w-full h-full object-cover max-w-[200px] max-h-[200px]" />
        </div>
      <?php endif; ?>
      <div class="flex flex-col my-auto text-white min-w-60 max-md:max-w-full">
        <?php if ($heading): ?>
          <<?php echo esc_attr($heading_tag); ?> class="text-[24px] lg:text-4xl font-bold leading-none max-md:max-w-full">
            <?php echo esc_html($heading); ?>
          </<?php echo esc_attr($heading_tag); ?>>
        <?php endif; ?>
        <?php if ($subheading): ?>
          <p class="mt-4 text-[18px] lg:text-lg leading-none max-md:max-w-full"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>
        <?php if ($button_title): ?>
          <div class="pt-2 mt-4">
            <a href="<?php echo $button_url; ?>" target="<?php echo $button_target; ?>" class="flex gap-2 justify-center items-center px-7 py-4 text-[16px] lg:text-sm font-semibold whitespace-nowrap bg-white rounded text-slate-700 min-h-14 w-full md:w-fit hover:bg-hover hover:text-hover max-md:px-5" aria-label="<?php echo esc_attr($button_title); ?>">
              <span><?php echo $button_title; ?></span>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

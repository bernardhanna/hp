<?php
$id = uniqid('testimonial-002-');

$image = get_sub_field('image');
$quote = get_sub_field('quote');
$button = get_sub_field('button');

$text_color = get_sub_field('text_color');
$button_link = get_sub_field('button_link');
$show_svg = get_sub_field('show_svg');

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

<section id="<?php echo esc_attr($id); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col lg:flex-row justify-between items-center w-full mx-auto max-w-[1376px] max-xxl:px-5 max-md:py-12 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">

      <!-- Image -->
      <?php if (!empty($image['url'])): ?>
        <div class="flex relative justify-start items-center w-full max-w-1/2 xl:max-w-[832px]  rounded-2xl">
          <img src="<?php echo esc_url($image['url']); ?>"
               alt="<?php echo esc_attr($image['alt'] ?: 'Testimonial Image'); ?>"
               class="w-full h-auto rounded-2xl" />
        </div>
      <?php endif; ?>

      <!-- Content -->
      <div class="flex relative flex-col gap-6 max-sm:p-0 sm:p-5 xl:p-0 lg:max-w-1/2 xl:max-w-[438px] items-start w-full max-lg:my-8 max-w-full">
        <svg aria-hidden="true" width="108" height="79" viewBox="0 0 108 79" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-[108px] h-[79px] max-xl:hidden xl:absolute left-[-8rem] top-[-3rem] flex">
          <path d="M48.5415 0L32.1661 54.4093L25.7329 30.0123C33.4007 30.0123 39.574 32.1422 44.2527 36.402C49.0614 40.6618 51.4657 46.5997 51.4657 54.2157C51.4657 61.7026 48.9964 67.7051 44.0578 72.223C39.2491 76.741 33.1408 79 25.7329 79C18.3249 79 12.1516 76.741 7.213 72.223C2.40433 67.7051 0 61.7026 0 54.2157C0 52.1503 0.129964 50.085 0.389892 48.0196C0.779783 45.9543 1.49458 43.4371 2.5343 40.4681C3.70397 37.4992 5.3935 33.6266 7.60289 28.8505L21.2491 0H48.5415ZM105.076 0L88.7004 54.4093L82.2672 30.0123C89.935 30.0123 96.1083 32.1422 100.787 36.402C105.596 40.6618 108 46.5997 108 54.2157C108 61.7026 105.531 67.7051 100.592 72.223C95.7834 76.741 89.6751 79 82.2672 79C74.8592 79 68.6859 76.741 63.7473 72.223C58.9386 67.7051 56.5343 61.7026 56.5343 54.2157C56.5343 52.1503 56.6643 50.085 56.9242 48.0196C57.3141 45.9543 58.0289 43.4371 59.0686 40.4681C60.2383 37.4992 61.9278 33.6266 64.1372 28.8505L77.7834 0H105.076Z" fill="#003800"></path>
        </svg>

        <?php if ($quote): ?>
          <span class="text-[22px] md:text-[28px]  xl:text-[30px] font-bold leading-10  max-md:leading-7  max-sm:l text-primary">
            <?php echo esc_html($quote); ?>
          </span>
        <?php endif; ?>

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
                class="flex gap-2 justify-center items-center px-7 py-4 max-w-full text-sm font-semibold leading-none rounded border-2 border-solid transition-colors duration-200 max-md:w-full md:max-w-max border-secondary btn text-tertiary hover:bg-hover active:bg-hover"
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
    </div>
</section>
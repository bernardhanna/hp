<?php
$careers = get_sub_field('careers');
$text_color = get_sub_field('text_color') ?: '#1D2939';
$background_color = get_sub_field('background_color') ?: '#ffffff';

$padding_classes = ['pt-5', 'pb-5'];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $padding_classes[] = get_sub_field('screen_size') . ':pt-[' . get_sub_field('padding_top') . 'rem]';
        $padding_classes[] = get_sub_field('screen_size') . ':pb-[' . get_sub_field('padding_bottom') . 'rem]';
    }
}
?>

<section class="relative flex overflow-hidden">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1472px] px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
      <div class="grid w-full grid-cols-1 gap-8 md:grid-cols-3 max-md:gap-6">
        <?php foreach ($careers as $job): ?>
          <div class="flex flex-col items-start w-full gap-2 p-8 bg-white border-2 border-solid rounded-2xl border-amber-600 max-sm:p-6">
            <span class="text-lg font-bold leading-6 text-slate-600">
              <?php echo esc_html($job['title']); ?>
            </span>
            <div class="flex flex-col items-start w-full gap-2">
              <p class="w-full text-base leading-6 text-slate-700">
                <?php echo esc_html($job['type']); ?>
              </p>
              <p class="w-full text-base leading-6 text-slate-700">
                <?php echo esc_html($job['experience']); ?>
              </p>
              <p class="w-full text-base leading-6 text-slate-700">
                <?php echo esc_html($job['location']); ?>
              </p>
              <?php if (!empty($job['apply_link']['url'])): ?>
                <div class="flex flex-col items-start w-full gap-2 pt-4">
                  <a href="<?php echo esc_url($job['apply_link']['url']); ?>"
                     target="<?php echo esc_attr($job['apply_link']['target']); ?>"
                     class="inline-flex items-center h-12 gap-2 p-4 text-sm font-semibold leading-5 text-black transition-colors duration-200 rounded bg-secondary whitespace-nowrap hover:bg-primary hover:text-white"
                     role="button">
                    <?php echo esc_html($job['apply_link']['title'] ?: 'Apply'); ?>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
  </div>
</section>

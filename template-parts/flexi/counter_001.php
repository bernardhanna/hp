<?php
$section_id = 'section-' . uniqid();

$custom_classes = get_sub_field('custom_class') ?: '';

$section_title = get_sub_field('section_title');
$title_tag = get_sub_field('title_tag');
$section_description = get_sub_field('section_description');
$counters = get_sub_field('counters');

$bg_color = get_sub_field('background_color');
$text_color = get_sub_field('text_color');

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

$wrapper_style = '';
if ($bg_color || $text_color) {
  $style_parts = [];
  if ($bg_color) $style_parts[] = 'background-color:' . esc_attr($bg_color);
  if ($text_color) $style_parts[] = 'color:' . esc_attr($text_color);
  $wrapper_style = 'style="' . implode(';', $style_parts) . '"';
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="relative flex overflow-hidden <?php echo esc_attr($custom_classes); ?>">
  <div class="flex flex-col items-center w-full mx-auto max-w-full max-lg:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <div class="flex flex-col items-center justify-center w-full px-16 py-32 overflow-hidden max-md:py-24" <?php echo $wrapper_style; ?>>
      <div class="w-full max-md:max-w-full">
        <div class="flex flex-col gap-5 md:flex-row">
          <div class="md:w-[56%] w-full">
            <div class="flex flex-col grow max-md:mt-10 max-md:max-w-full">
              <<?php echo esc_attr($title_tag); ?> class="self-start text-5xl font-bold leading-none text-primary max-md:text-4xl">
                <?php echo esc_html($section_title); ?>
              </<?php echo esc_attr($title_tag); ?>>
              <div class="mt-6 text-base leading-6 text-primary max-md:max-w-full wp_editor">
                <?php echo $section_description; ?>
              </div>
            </div>
          </div>
          <div class="md:ml-5 md:w-[44%] w-full">
            <div class="mt-8 grow max-md:mt-10">
              <div class="flex flex-col gap-5 md:flex-row">
                <?php if ($counters): ?>
                  <?php foreach ($counters as $index => $counter):
                    $number = $counter['counter_number'];
                    $label = $counter['counter_label'];
                    $bg_color = $counter['counter_bg'];
                    $number_color = $counter['counter_number_color'];
                    $label_color = $counter['counter_label_color'];

                    $inline_style = $bg_color ? 'style="background-color: ' . esc_attr($bg_color) . ';"' : '';
                    $number_class = $number_color ? '' : 'text-primary';
                    $number_style = $number_color ? 'style="color:' . esc_attr($number_color) . ';"' : '';

                    $label_class = $label_color ? '' : 'text-primary';
                    $label_style = $label_color ? 'style="color:' . esc_attr($label_color) . ';"' : '';
                  ?>
                    <article class="md:w-6/12 w-full <?php echo $index % 2 !== 0 ? 'md:ml-5' : ''; ?> max-md:ml-0">
                      <div
                        x-data="{ count: 0, target: <?php echo esc_attr($number); ?> }"
                        x-init="let interval = setInterval(() => { 
                        if (count < target) count += 5;
                        else { count = target; clearInterval(interval); } 
                      }, 20);"
                        class="flex flex-col items-center w-full px-10 font-bold text-center rounded-lg grow py-7 max-md:px-5 max-md:mt-4"
                        <?php echo $inline_style; ?>>
                        <span class="text-5xl leading-none max-md:text-4xl <?php echo esc_attr($number_class); ?>" <?php echo $number_style; ?> x-text="count"></span>
                        <span class="mt-2 text-base <?php echo esc_attr($label_class); ?>" <?php echo $label_style; ?>><?php echo esc_html($label); ?></span>
                      </div>
                    </article>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
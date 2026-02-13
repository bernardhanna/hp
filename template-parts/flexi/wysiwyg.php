<?php
$text_content = get_sub_field('text_content');

$padding_classes = [];
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

<section class="flex overflow-hidden relative">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1216px] pt-8 <?php echo implode(' ', $padding_classes); ?> max-xxl:px-5">
   
      <div class="wp_editor">
        <?php if ($text_content): ?>
          <?= wp_kses_post($text_content); ?>
        <?php endif; ?>
      </div>

  </div>
</section>


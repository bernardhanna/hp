<?php
$clients         = get_sub_field('clients') ?: [];
$padding_classes = ['pt-5', 'pb-5'];

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

<section class="relative flex overflow-hidden">
  <div class="grid w-full grid-cols-1 lg:grid-cols-2 gap-8 pt-5 pb-5 mx-auto max-w-[1472px] max-xxl:px-5 max-md:grid-cols-1 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <?php foreach ($clients as $client): 
        $bg     = $client['background_image'];
        $sub    = $client['subtitle'];
        $name   = $client['client_name'];
        $link   = $client['client_link'];
        $icon   = $client['cta_icon'];
        $url    = $link['url']    ?? '#';
        $target = $link['target'] ?? '_self';
    ?>
      <article class="flex overflow-hidden relative flex-col justify-end rounded-2xl w-full h-auto px-6 min-h-[400px] lg:min-h-[600px] max-md:px-5">
        <?php if ($bg): ?>
          <img src="<?php echo esc_url($bg['url']); ?>"
               alt="<?php echo esc_attr($bg['alt'] ?? ''); ?>"
               class="absolute inset-0 object-cover size-full"
               aria-hidden="true" />
        <?php endif; ?>

        <div class="relative flex flex-row items-start justify-between w-full gap-10 py-8 pl-8 pr-6 mb-6 bg-white rounded-lg max-md:px-5">
          <div class="text-slate-700 w-[435px] max-md:max-w-full">
            <?php if ($sub): ?>
              <p class="text-base font-semibold"><?php echo esc_html($sub); ?></p>
            <?php endif; ?>
            <?php if ($name): ?>
              <span class="text-3xl font-bold leading-tight"><?php echo esc_html($name); ?></span>
            <?php endif; ?>
          </div>

          <a href="<?php echo esc_url($url); ?>"
             target="<?php echo esc_attr($target); ?>"
             aria-label="<?php echo esc_attr('View details for ' . $name); ?>"
             class="relative flex">
            <?php if ($icon): ?>
              <img src="<?php echo esc_url($icon['url']); ?>"
                   alt="<?php echo esc_attr($icon['alt'] ?? ''); ?>"
                   class="object-contain w-6 h-6 aspect-square"
                   aria-hidden="true" />
            <?php else: ?>
<svg width="72" height="73" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="8" y="8.21094" width="56" height="56" rx="4" fill="#DE7C34"></rect>
                        <rect x="4" y="4.21094" width="64" height="64" rx="8" stroke="white" stroke-opacity="0.1" stroke-width="8"></rect>
                        <path d="M29 36.2109H43M43 36.2109L36 29.2109M43 36.2109L36 43.2109" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
            <?php endif; ?>
          </a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

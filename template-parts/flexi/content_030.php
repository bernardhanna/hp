<?php
$id = uniqid('why-hp-');
$section_heading = get_sub_field('section_heading');
$section_intro = get_sub_field('section_intro');
$features = get_sub_field('features');

$bg_image = '';
$heading = '';
$description = '';

if ($features && is_array($features) && !empty($features[0])) {
    $first_feature = $features[0];

    $bg_image = isset($first_feature['bg_image']['url']) ? $first_feature['bg_image']['url'] : '';
    $heading = isset($first_feature['heading']) ? $first_feature['heading'] : '';
    $description = isset($first_feature['description']) ? $first_feature['description'] : '';
}

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
  <div class="flex flex-col items-center w-full mx-auto max-w-container  max-sm:px-0 max-xxl:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <div class="flex flex-col items-center justify-center w-full gap-10 max-w-[1376px]  xl:py-20 md:flex-row" id="<?php echo esc_attr($id); ?>-container">

      <!-- Left: Navigation -->
      <div class="flex flex-col w-full grow max-w-1/3 max-sm:px-5 text-slate-700 max-md:max-w-full">
        <<?php echo $section_heading ? 'h2' : 'div'; ?> class="text-3xl font-bold leading-tight text-left text-primary max-md:text-[22px]"><?php echo esc_html($section_heading); ?></<?php echo $section_heading ? 'h2' : 'div'; ?>>
        <p class="mt-6 max-md:text-[16px] text-lg leading-6 max-md:max-w-full"><?php echo esc_html($section_intro); ?></p>

        <?php if ($features && is_array($features)): ?>
          <div class="flex flex-col pt-6 mt-6 w-full text-xl font-medium leading-snug whitespace-nowrap" id="<?php echo esc_attr($id); ?>-nav">
          <?php foreach ($features as $i => $feature): ?>
            <?php
              $link = $feature['link'] ?? null;
              $icon_url = $feature['icon']['url'] ?? '';
            ?>
            <?php if ($link): ?>
              <a 
                href="<?php echo esc_url($link['url']); ?>"
                <?php if (!empty($link['target'])): ?>
                  target="<?php echo esc_attr($link['target']); ?>" rel="noopener"
                <?php endif; ?>
                class="flex justify-between items-center py-5 w-full border-t border-solid cursor-pointer feature-item border-t-gray-200 focus:outline-none focus:ring-2 focus:ring-primary hover:bg-neutral-200 max-md:text-[14px]"
                data-bg="<?php echo esc_url($feature['bg_image']['url'] ?? ''); ?>"
                data-heading="<?php echo esc_attr($feature['heading'] ?? ''); ?>"
                data-desc="<?php echo esc_attr($feature['description'] ?? ''); ?>"
                data-icon="<?php echo esc_url($feature['icon']['url'] ?? ''); ?>"
                role="tab"
                tabindex="0"
                aria-controls="<?php echo esc_attr($id); ?>-preview"
                >
                <span class="flex gap-2 items-center px-2 text-[14px] lg:text-xl font-medium leading-snug whitespace-nowrap">
                  <?php echo esc_html($link['title'] ?? ''); ?>
                  <?php if (!empty($icon_url)): ?>
                    <img src="<?php echo esc_url($icon_url); ?>" class="object-contain w-[17px]" alt="" />
                  <?php endif; ?>
                </span>
                <svg width="17" height="17" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M6.375 13.4609L10.625 9.21094L6.375 4.96094" stroke="#222534" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Right: Preview -->
      <div id="<?php echo esc_attr($id); ?>-preview" class="relative flex flex-col grow overflow-hidden lg:px-6 min-h-[500px] h-full xl:max-h-[600px] my-auto lg:rounded-2xl w-full max-w-2/3  max-md:max-w-full justify-end"
           style="background-image: url('<?php echo esc_url($bg_image); ?>'); background-size: cover; background-position: center;">

        <div class="flex relative flex-row gap-10 justify-between items-start py-4 w-full bg-white lg:rounded-lg lg:pl-8 lg:pr-6 lg:mb-4 lg:py-8 max-md:px-5 max-md:max-w-full">
          <div class="flex flex-col text-slate-700 max-w-[435px] max-lg:max-w-full">
            <span class="text-base font-semibold" id="<?php echo esc_attr($id); ?>-heading"><?php echo esc_html($heading); ?></span>
            <p class="text-[20px] lg:text-3xl font-bold leading-tight text-left" id="<?php echo esc_attr($id); ?>-desc"><?php echo esc_html($description); ?></p>
          </div>
            <svg width="72" height="73" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="4.21094" width="64" height="64" rx="8" fill="#DE7C34"/>
            <rect x="4" y="4.21094" width="64" height="64" rx="8" stroke="#F0C5A5" stroke-width="8"/>
            <path d="M29 36.2109H43M43 36.2109L36 29.2109M43 36.2109L36 43.2109" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const items = document.querySelectorAll('#<?php echo esc_attr($id); ?>-nav .feature-item');
  const preview = document.getElementById('<?php echo esc_attr($id); ?>-preview');
  const heading = document.getElementById('<?php echo esc_attr($id); ?>-heading');
  const desc = document.getElementById('<?php echo esc_attr($id); ?>-desc');
  const icon = document.getElementById('<?php echo esc_attr($id); ?>-icon');

  items.forEach(item => {
    item.addEventListener('mouseover', () => {
      const bg = item.getAttribute('data-bg');
      const h = item.getAttribute('data-heading');
      const d = item.getAttribute('data-desc');
      const ic = item.getAttribute('data-icon');

      preview.style.backgroundImage = `url('${bg}')`;
      heading.textContent = h;
      desc.textContent = d;
    });
  });
});
</script>
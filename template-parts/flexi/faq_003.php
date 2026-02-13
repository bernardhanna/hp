<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$faq_items = get_sub_field('faq_items');
$section_background = get_sub_field('section_background') ?: '#E2E8F0';
$text_color = get_sub_field('text_color') ?: '#003800';
$border_color = get_sub_field('border_color') ?: '#CCDEE2';
$hover_border_color = get_sub_field('hover_border_color') ?: '#F97316';
$accordion_background = get_sub_field('accordion_background') ?: '#FFF';
$active_border_color = get_sub_field('active_border_color') ?: '#003800';

// Generate padding classes
$padding_classes = ['py-5'];
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
?>

<section aria-labelledby="faq-heading" class="flex flex-col self-stretch px-32 pt-14 pb-20 font-bold bg-white text-<?php echo esc_attr($text_color); ?> max-xl:px-5">
  <div class="flex flex-col w-full max-md:max-w-full max-w-[1040px] mx-auto">
      <div class="flex flex-col w-[568px] max-md:max-w-full">
        <div class="flex items-center gap-6 text-3xl font-bold leading-tight text-center text-slate-700">
          <svg width="72" height="73" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="4" y="4.21094" width="64" height="64" rx="12" fill="#DA6D1D"/>
          <rect x="4" y="4.21094" width="64" height="64" rx="12" stroke="#F8E2D2" stroke-width="8"/>
          <path d="M25.2379 43.9697V52.211H18.7676V44.772" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M18.7676 39.9965V36.5742H25.2379V39.2913" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M34.943 41.1885V52.2109H28.4727V42.3841" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M28.4727 37.6288V27.4277H34.943V36.4956" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M44.6473 40.707V52.2112H38.1787V42.3948" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M38.1787 37.6293V32.5781H44.6473V36.4181" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M54.3522 34.4102V52.2114H47.8818V39.8339" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M47.8818 33.0927V20.2109H54.3522V29.0847" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M16.0728 41.1884C19.6995 43.1483 24.1269 42.8623 27.4712 40.452C29.6997 38.8474 32.5571 38.3917 35.1736 39.2252L36.4906 39.6445C39.4554 40.5889 42.6923 40.0742 45.2171 38.2548L55.9276 30.542" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <<?php echo esc_html($heading_tag); ?>>
            <?php echo esc_html($heading_text); ?>
          </<?php echo esc_html($heading_tag); ?>>
        </div>
</div>

    <div class="flex flex-col gap-5 mt-5 mb-5">
      <?php if ($faq_items): ?>
        <?php foreach ($faq_items as $index => $faq_post): ?>
          <?php
          $faq_title = get_the_title($faq_post);
          $faq_content = apply_filters('the_content', get_post_field('post_content', $faq_post));
          ?>
          <div x-data="{ open: false }" class="w-full">
            <button @click="open = !open"
              class="group bg-white flex border-[1px] flex-row justify-between items-center p-6 w-full text-base sm:text-lg leading-loose rounded-lg border-solid border-<?php echo esc_attr($border_color); ?> bg-<?php echo esc_attr($accordion_background); ?> hover:border-<?php echo esc_attr($hover_border_color); ?> focus:outline-none focus:border-<?php echo esc_attr($hover_border_color); ?>  transition-all duration-200"
              :style="open ? 'border-radius: 8px; border: 4px solid #003800; border-bottom: 0px; border-bottom-right-radius: 0px;  border-bottom-left-radius: 0px;;' : ''"
              aria-expanded="false">
              <span class="flex-1 pl-4 text-left text-[#003800]"><?php echo esc_html($faq_title); ?></span>
                            <span>
                <!-- Unopened Icon -->
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                  <path d="M16.0003 6.66663V25.3333M6.66699 16H25.3337" stroke="#003800" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <!-- Opened Icon -->
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                  <path d="M6.66699 16H25.3337" stroke="#003800" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </button>
            <div x-show="open"
              class="p-6 text-base leading-6 border-1 rounded-lg border-<?php echo esc_attr($active_border_color); ?> bg-white transition-all duration-300"
              :style="open ? 'border-radius: 8px; border: 4px solid var(--Primary-Orange-500, #003800); border-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;' : ''">

              <div class="wp_editor">
                <?php echo wp_kses_post($faq_content); ?>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-gray-500">No FAQs available.</p>
      <?php endif; ?>
    </div>
</section>
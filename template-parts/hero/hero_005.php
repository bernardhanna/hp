<?php
$section_id     = 'section-' . wp_generate_password(8, false);
$reverse        = get_sub_field('reverse_layout');
$layout_class   = $reverse ? 'lg:flex-row-reverse' : 'lg:flex-row';
$image_radius   = $reverse
  ? 'md:rounded-tr-[32px] md:rounded-br-[32px]'
  : 'md:rounded-tl-[32px] md:rounded-bl-[32px]';

// ACF
$heading_tag    = get_sub_field('heading_tag')    ?: 'h1';
$heading_text   = get_sub_field('heading_text');
$subheading     = get_sub_field('subheading');
$image          = get_sub_field('image');
$button_link = get_sub_field('button_link');
$show_svg = get_sub_field('show_svg');
$text_color     = get_sub_field('text_color');
$paragraph_color= get_sub_field('paragraph_color');
$background     = get_sub_field('background_color');

// Padding
$padding = ['md:pt-5','md:pb-5'];
if(have_rows('padding_settings')){
  while(have_rows('padding_settings')){
    the_row();
    $sz = get_sub_field('screen_size');
    $pt = get_sub_field('padding_top');
    $pb = get_sub_field('padding_bottom');
    $padding[] = "{$sz}:pt-[{$pt}rem]";
    $padding[] = "{$sz}:pb-[{$pb}rem]";
  }
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1728px] pt-4">

    <div class="flex <?php echo esc_attr($layout_class); ?> justify-center items-center w-full bg-white max-md:flex-col-reverse">

      <!-- TEXT COLUMN -->
      <div class="flex flex-col gap-4 items-start w-full lg:w-1/2 xl:p-16 max-xl:px-5 max-lg:pb-12">
        <div class="w-full max-w-[568px]">
        <nav aria-label="Breadcrumb">
           <ol class="flex gap-2 items-center mt-4 text-sm font-semibold text-gray-700">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_2825_31113)">
                    <path d="M3.36964 11.3868C2.956 11.3868 2.61865 11.7195 2.61865 12.1275V20.886C2.61865 21.294 2.95601 21.6268 3.36964 21.6268H18.9234C19.337 21.6268 19.6743 21.294 19.6743 20.886V12.1275C19.6743 11.7195 19.337 11.3868 18.9234 11.3868C18.5097 11.3868 18.1724 11.7195 18.1724 12.1275V20.1453L4.12063 20.1467V12.1275C4.12063 11.7209 3.78621 11.3868 3.36964 11.3868Z" fill="#667085"/>
                    <path d="M11.4882 0.979276C11.2066 0.734773 10.7827 0.734773 10.5011 0.979276L0.257236 9.81594C-0.0537185 10.0865 -0.0889248 10.5524 0.185362 10.8605C0.45965 11.1672 0.931957 11.2019 1.24437 10.9314L10.9926 2.51991L20.7408 10.9314C20.8831 11.0529 21.0605 11.1166 21.2365 11.1166C21.4463 11.1166 21.6531 11.0312 21.8042 10.8648C22.0785 10.5581 22.0447 10.0908 21.7323 9.82028L11.4882 0.979276Z" fill="#667085"/>
                    <path d="M14.1312 19.1051C14.5449 19.1051 14.8822 18.7723 14.8822 18.3643V13.9243C14.8822 13.5163 14.5449 13.1836 14.1312 13.1836H8.16163C7.74799 13.1836 7.41064 13.5163 7.41064 13.9243V18.3643C7.41064 18.7723 7.748 19.1051 8.16163 19.1051C8.57528 19.1051 8.91262 18.7723 8.91262 18.3643V14.665H13.3802V18.3643C13.3802 18.7723 13.7191 19.1051 14.1312 19.1051Z" fill="#667085"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_2825_31113">
                    <rect width="21.99" height="20.8309" fill="white" transform="translate(0 0.795898)"/>
                    </clipPath>
                    </defs>
                </svg>

                  <li><a href="<?php echo home_url(); ?>">Home</a></li>
                  <li><svg class="mx-2" width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12l5-5-5-5" stroke="currentColor" stroke-width="2"/></svg></li>
                  <?php if (is_singular()): ?>
                    <li aria-current="page"><?php echo get_the_title(); ?></li>
                  <?php elseif (is_archive()): ?>
                    <li aria-current="page"><?php echo post_type_archive_title('', false); ?></li>
                  <?php elseif (is_home()): ?>
                    <li aria-current="page">Blog</li>
                  <?php elseif (is_404()): ?>
                    <li aria-current="page">404 Not Found</li>
                  <?php endif; ?>
                </ol>
              </nav>

        <<?php echo esc_attr($heading_tag); ?>
          class="text-[30px] lg:text-6xl font-bold tracking-tight leading-tight max-sm:text-4xl max-sm:leading-snug text-primary mt-8 mb-4">
          <?php echo esc_html($heading_text); ?>
        </<?php echo esc_attr($heading_tag); ?>>

        <?php if($subheading): ?>
          <div class="text-xl leading-7 wp_editor max-sm:text-base max-sm:leading-6 text-[#344054]">
            <?php echo $subheading; ?>
          </div>
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
                    class="flex gap-2 justify-center items-center px-7 py-4 max-w-max text-sm font-semibold leading-none rounded border-2 border-solid transition-colors duration-200 border-secondary btn text-tertiary hover:bg-hover active:bg-hover"
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
      <!-- IMAGE COLUMN -->
      <?php if ( $image ): ?>
        <?php $hide_img = is_page(25); // true only on page ID 25 ?>
        <div class="<?php echo esc_attr( trim( ($image_radius ?: '') . ' overflow-hidden w-full lg:w-1/2 max-md:w-full' ) ); ?>">
          <img
            src="<?php echo esc_url($image['url']); ?>"
            alt="<?php echo esc_attr($image['alt'] ?: 'Hero image'); ?>"
            title="<?php echo esc_attr($image['title'] ?: 'Hero'); ?>"
            class="object-cover w-full max-h-auto lg:max-h-[34rem] max-md:h-auto<?php echo $hide_img ? ' invisible' : ''; ?>"
            <?php echo $hide_img ? 'aria-hidden="true"' : ''; ?>
          />
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>


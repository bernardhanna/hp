<section class="flex overflow-hidden relative bg-white">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1536px] px-5">
    <div class="flex gap-2 justify-end items-center w-full max-sm:pt-8 bg-white min-h-[135px] max-lg:flex-col max-lg:items-center max-sm:p-0">
      <div class="flex flex-1 gap-8 items-center max-lg:justify-center max-sm:flex-col max-sm:gap-4 max-sm:items-center">
        <?php $logos_img = get_field('logos', 'option'); ?>
        <?php if( $logos_img ) : ?>
          <img
            src="<?php echo esc_url( $logos_img['url'] ); ?>"
            alt="<?php echo esc_attr( $logos_img['alt'] ?: 'Footer Logo' ); ?>"
            title="<?php echo esc_attr( $logos_img['title'] ?: 'Footer Logo' ); ?>"
            class="w-auto"
          />
        <?php endif; ?>
      </div>
      <div>
        <div>
          <?php
            $img = get_field('accreditation_image', 'option');
            if( $img ) :
          ?>
            <img
              src="<?php echo esc_url( $img['url'] ); ?>"
              alt="<?php echo esc_attr( $img['alt'] ?: 'Accreditation' ); ?>"
              title="<?php echo esc_attr( $img['title'] ?: 'Accreditation' ); ?>"
              class="w-auto"
            />
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<footer
  class="flex overflow-hidden flex-wrap gap-10 items-start py-20 w-full bg-[#002A00] max-lg:flex max-lg:px-5 max-sm:flex max-sm:px-6 max-sm:pt-6"
  aria-labelledby="footer-heading"
>
  <h2 id="footer-heading" class="sr-only">Site Footer</h2>

  <div class="w-full flex max-w-[1536px] flex-col lg:flex-row justify-between items-start mx-auto">

    <?php
      // Shared span classes for ALL footer menu links (and fallback)
      // Now using font-light as requested.
      $footer_link_span_classes = 'text-[16px] leading-6 font-light text-[var(--Yellow-Text-500,#FFFFCC)] hover:underline';
      $link_before = '<span class="' . esc_attr($footer_link_span_classes) . '">';
      $link_after  = '</span>';

      // Scoped filter to add py-2 to ALL <li> items for these menus only.
      $__footer_li_filter = function( $classes, $item, $args, $depth ) {
        $locations = ['Footer One','footer_one','Footer Two','footer_two','Footer Three','footer_three'];
        if ( isset($args->theme_location) && in_array($args->theme_location, $locations, true) ) {
          $classes[] = 'py-2';
        }
        return $classes;
      };
      add_filter('nav_menu_css_class', $__footer_li_filter, 10, 4);
    ?>

    <!-- Column 1: Company Information -->
    <nav
      class="flex flex-col flex-1 justify-center items-start mb-5 text-base font-medium text-white sm:px-8 max-lg:self-stretch max-lg:border-b max-lg:border-1 max-lg:border-[#ffffcc] max-lg:pb-4"
      aria-labelledby="company-info-heading"
    >
      <span id="company-info-heading" class="text-base font-bold text-white">
        Hanley Pepper
      </span>
      <?php
      wp_nav_menu([
        'theme_location' => 'Footer One',
        'menu_class'     => 'flex flex-col gap-2 mt-2', // <ul> classes
        'container'      => false,
        'link_before'    => $link_before,
        'link_after'     => $link_after,
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

    <!-- Divider 1 -->
    <div class="flex shrink-0 self-stretch w-px bg-[#FFFFCC] max-lg:hidden max-sm:hidden" aria-hidden="true"></div>

    <!-- Column 2: Expertise -->
    <nav
      class="flex flex-col flex-1 justify-center items-start mb-5 text-base font-medium text-white sm:px-8 max-lg:self-stretch max-lg:border-b max-lg:border-1 max-lg:border-[#ffffcc] max-lg:pb-4"
      aria-labelledby="expertise-heading"
    >
      <span id="expertise-heading" class="text-base font-bold text-white">
        Expertise
      </span>

      <div class="flex flex-col gap-2 mt-2">
        <?php
        if ( has_nav_menu('footer_two') ) {
          wp_nav_menu([
            'theme_location' => 'Footer Two',
            'menu_class'     => 'flex flex-col gap-2', // <ul> classes
            'container'      => false,
            'link_before'    => $link_before,
            'link_after'     => $link_after,
            'fallback_cb'    => false,
          ]);
        } else {
          // Fallback: child pages of "expertise"
          $parent = get_page_by_path('expertise');
          if ( $parent ) {
            $children = get_pages([
              'child_of'    => $parent->ID,
              'sort_column' => 'menu_order, post_title',
            ]);
            foreach ( $children as $child ) {
              printf(
                // Add py-2 so fallback spacing matches menu <li>
                '<a href="%1$s" class="gap-1 py-2"><span class="%3$s">%2$s</span></a>',
                esc_url( get_permalink( $child ) ),
                esc_html( $child->post_title ),
                esc_attr( $footer_link_span_classes )
              );
            }
          }
        }
        ?>
      </div>
    </nav>

    <!-- Divider 2 -->
    <div class="flex shrink-0 self-stretch w-px bg-[#FFFFCC] max-lg:hidden max-sm:hidden" aria-hidden="true"></div>

    <!-- Column 3: Work with us -->
    <nav
      class="flex flex-col flex-1 justify-center items-start mb-5 text-base font-medium text-white sm:px-8 max-lg:self-stretch max-lg:border-b max-lg:border-1 max-lg:border-[#ffffcc] max-lg:pb-4"
      aria-labelledby="work-heading"
    >
      <span id="work-heading" class="text-base font-bold text-white">
        Work with us
      </span>
      <?php
      wp_nav_menu([
        'theme_location' => 'Footer Three',
        'menu_class'     => 'flex flex-col gap-2 mt-2', // <ul> classes
        'container'      => false,
        'link_before'    => $link_before,
        'link_after'     => $link_after,
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

    <?php
      // Remove the filter so it doesn't affect other menus on the page.
      remove_filter('nav_menu_css_class', $__footer_li_filter, 10);
    ?>

    <!-- Divider 3 -->
    <div class="flex shrink-0 self-stretch w-px bg-[#FFFFCC] max-lg:hidden max-sm:hidden" aria-hidden="true"></div>

    <!-- Column 4: Contact Us -->
    <?php
      $phone   = get_field('phone_number', 'option');
      $address = get_field('address',      'option');
      $socials = get_field('social_icons', 'option');
    ?>
    <div class="flex flex-col flex-1 justify-center mb-5 sm:px-8" aria-labelledby="contact-heading">
      <span id="contact-heading" class="text-base font-bold text-white">
        Contact us
      </span>

      <?php if( $phone ): ?>
        <div class="flex flex-col py-8 w-full rounded-lg">
          <div class="flex flex-col self-stretch p-4 xs:p-8 rounded-lg border-2 border-amber-600 border-solid max-w-[312px]">
            <a href="tel:<?php echo esc_attr( $phone ); ?>"
              class="flex flex-row items-center my-auto text-sm font-semibold leading-none text-white hover:underline focus:outline-none focus:ring-2 focus:ring-white">
              <svg class="mr-4" width="52" height="53" viewBox="0 0 52 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect y="0.709961" width="52" height="52" rx="26" fill="#DE7C34"/>
                <path d="M35.9999 31.6301V34.6301C36.0011 34.9086 35.944 35.1842 35.8324 35.4394C35.7209 35.6946 35.5572 35.9236 35.352 36.1119C35.1468 36.3002 34.9045 36.4435 34.6407 36.5328C34.3769 36.622 34.0973 36.6551 33.8199 36.6301C30.7428 36.2957 27.7869 35.2442 25.1899 33.5601C22.7738 32.0247 20.7253 29.9762 19.1899 27.5601C17.4999 24.9513 16.4482 21.9811 16.1199 18.8901C16.0949 18.6135 16.1278 18.3348 16.2164 18.0717C16.3051 17.8085 16.4475 17.5667 16.6347 17.3617C16.8219 17.1566 17.0497 16.9928 17.3037 16.8806C17.5577 16.7684 17.8323 16.7103 18.1099 16.7101H21.1099C21.5952 16.7053 22.0657 16.8771 22.4337 17.1936C22.8017 17.51 23.042 17.9495 23.1099 18.4301C23.2366 19.3901 23.4714 20.3328 23.8099 21.2401C23.9445 21.598 23.9736 21.987 23.8938 22.3609C23.8141 22.7349 23.6288 23.0782 23.3599 23.3501L22.0899 24.6201C23.5135 27.1236 25.5864 29.1965 28.0899 30.6201L29.3599 29.3501C29.6318 29.0812 29.9751 28.8959 30.3491 28.8162C30.723 28.7364 31.112 28.7655 31.4699 28.9001C32.3772 29.2386 33.3199 29.4734 34.2799 29.6001C34.7657 29.6686 35.2093 29.9133 35.5265 30.2876C35.8436 30.6618 36.0121 31.1396 35.9999 31.6301Z" stroke="#002A00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span class="flex"><?php echo esc_html( $phone ); ?></span>
            </a>
          </div>
        </div>
      <?php endif; ?>

      <?php if( $address ): ?>
        <address class="pt-4 pb-6 mt-2 w-full not-italic max-sm:pb-6">
          <div class="flex flex-row gap-4 items-start w-full text-sm leading-5 text-white">
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_3027_2775)">
                <path d="M21 10.71C21 17.71 12 23.71 12 23.71C12 23.71 3 17.71 3 10.71C3 8.32301 3.94821 6.03383 5.63604 4.346C7.32387 2.65817 9.61305 1.70996 12 1.70996C14.3869 1.70996 16.6761 2.65817 18.364 4.346C20.0518 6.03383 21 8.32301 21 10.71Z" stroke="#FFFFCC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 13.71C13.6569 13.71 15 12.3668 15 10.71C15 9.05311 13.6569 7.70996 12 7.70996C10.3431 7.70996 9 9.05311 9 10.71C9 12.3668 10.3431 13.71 12 13.71Z" stroke="#FFFFCC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </g>
              <defs>
                <clipPath id="clip0_3027_2775">
                  <rect width="24" height="24" fill="white" transform="translate(0 0.709961)"/>
                </clipPath>
              </defs>
            </svg>
            <p class="flex-1 my-auto basis-0">
              <?php echo nl2br( esc_html( $address ) ); ?>
            </p>
          </div>
        </address>
      <?php endif; ?>

      <?php if( $socials ): ?>
        <div class="flex gap-4 items-center mt-4">
          <?php foreach( $socials as $item ):
            $icon = $item['social_icon'];
            $url  = $item['social_link'];
            if( $icon && $url ): ?>
              <a href="<?php echo esc_url( $url ); ?>"
                target="_blank" rel="noopener"
                class="whitespace-nowrap w-fit hover:bg-hover hover:text-hover focus:outline-none focus:ring-2 focus:ring-white"
                aria-label="Social media link">
                <img
                  src="<?php echo esc_url( $icon['url'] ); ?>"
                  alt="<?php echo esc_attr( $icon['alt'] ?: 'Social Icon' ); ?>"
                  title="<?php echo esc_attr( $icon['title'] ?: '' ); ?>"
                  class="object-contain w-10 h-10"
                />
              </a>
          <?php endif; endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</footer>

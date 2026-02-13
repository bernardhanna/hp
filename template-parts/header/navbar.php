
<?php
$logo_id = get_theme_mod('custom_logo');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
$logo_alt = $logo_id ? get_post_meta($logo_id, '_wp_attachment_image_alt', true) : get_bloginfo('name');
// Get navbar settings
$nav_settings = get_field('navigation_settings_start', 'option');

$phone_number   = $nav_settings['phone_number'] ?? null;
$contact_button = $nav_settings['contact_button'] ?? null;

$dropdown_image_map = []; // [ menu_item_ID => img array ]

$nav_settings = get_field('navigation_settings_start', 'option');
if ( ! empty($nav_settings['dropdown_images']) ) {
    foreach ( $nav_settings['dropdown_images'] as $row ) {
        $mid = $row['menu_item'] ?? null;
        $img = $row['image']     ?? null;
        if ( $mid && ! empty($img['url']) ) {
            $dropdown_image_map[ (int) $mid ] = $img;
        }
    }
}

use Log1x\Navi\Navi;

$primary_navigation = Navi::make()->build('primary');
$secondary_navigation = Navi::make()->build('secondary');
?>

<section
  id="site-nav"
  x-data="{
    isOpen: false,
    activeDropdown: null,
    toggleDropdown(index) {
      this.activeDropdown = (this.activeDropdown === index ? null : index);
    },
    checkWindowSize() {
      if (window.innerWidth > 1084) {
        this.isOpen = false;
        this.activeDropdown = null;
      }
    }
  }"
  x-init="window.addEventListener('resize', () => checkWindowSize())"
  class="bg-white lg:py-12"
  x-effect="isOpen ? document.body.style.overflow = 'hidden' : document.body.style.overflow = ''"
  role="banner"
>
  <nav
    class="flex flex-row gap-5 sm:gap-10 justify-between max-lg:py-5 items-center self-stretch mx-auto max-w-[1728px] lg:px-5"
    role="navigation"
    aria-label="Main navigation"
  >
    <!-- Logo Section -->
    <div class="flex flex-col items-start w-full  my-auto  max-w-[250px]">
      <a
        href="<?php echo esc_url(home_url('/')); ?>"
        class="flex justify-start"
        aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> - Go to homepage"
      >
        <?php if ($logo_url) : ?>
          <img
            src="<?php echo esc_url($logo_url); ?>"
            alt="<?php echo esc_attr($logo_alt); ?>"
            class="object-contain w-auto h-auto bring_front"
          />
        <?php else : ?>
          <span class="text-xl font-bold text-slate-700"><?php echo get_bloginfo('name'); ?></span>
        <?php endif; ?>
      </a>
    </div>

    <!-- Desktop Navigation Menu -->
    <?php if ($primary_navigation->isNotEmpty()) : ?>
      <ul
        id="primary-menu"
        class="hidden flex-row gap-5 items-center self-stretch pt-0.5 my-auto text-base font-medium xl:gap-10 lg:flex min-w-60 text-slate-700 max-md:max-w-full"
        role="menubar"
      >
        <?php foreach ($primary_navigation->toArray() as $index => $item) : ?>
          <li
            class="relative group <?php echo esc_attr($item->classes); ?> <?php echo $item->active ? 'current-item' : ''; ?>"
            role="none"
          >
            <div class="flex flex-col justify-center self-stretch pt-1 my-auto whitespace-nowrap">
              <div class="flex gap-1 items-center">
                <a
                  href="<?php echo esc_url($item->url); ?>"
                  class="self-stretch my-auto text-slate-700 link-underline hover:text-slate-900 focus:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400 rounded <?php echo $item->active ? 'active-item font-semibold' : ''; ?>"
                  role="menuitem"
                  <?php if ($item->children) : ?>
                    aria-haspopup="true"
                    aria-expanded="false"
                    x-bind:aria-expanded="activeDropdown === <?php echo $index; ?>"
                  <?php endif; ?>
                >
                  <?php echo esc_html($item->label); ?>
                </a>
                <?php if ($item->children) : ?>
                  <button
                    type="button"
                    class="p-1 ml-1 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400"
                    @click="toggleDropdown(<?php echo $index; ?>)"
                    aria-label="Toggle <?php echo esc_attr($item->label); ?> submenu"
                  >
                   <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 6.48047L8.5 10.7305L12.75 6.48047" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                  </button>
                <?php endif; ?>
              </div>
            </div>
            <?php if ($item->children) : ?>
              <?php get_template_part('template-parts/header/navbar/dropdown', null, ['item' => $item, 'index' => $index, 'images' => $dropdown_image_map,]); ?>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <!-- Phone and Contact Button Section -->
    <div class="flex gap-4 items-center my-auto sm:gap-8">
      <?php if ($phone_number) : ?>
          <a
            href="tel:<?php echo esc_attr(preg_replace('/[^+\d]/', '', $phone_number)); ?>"
            class="flex z-50 gap-2 items-center my-auto text-sm font-semibold leading-none whitespace-nowrap rounded text-slate-700 hover:text-secondary focus:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400"
            aria-label="Call us at <?php echo esc_attr($phone_number); ?>"
          >
          <svg width="52" height="53" viewBox="0 0 52 53" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1" y="1.60547" width="50" height="50" rx="25" stroke="#D0D5DD" stroke-width="2"/>
            <path d="M35.9999 31.5256V34.5256C36.0011 34.8041 35.944 35.0797 35.8324 35.3349C35.7209 35.5901 35.5572 35.8192 35.352 36.0074C35.1468 36.1957 34.9045 36.339 34.6407 36.4283C34.3769 36.5175 34.0973 36.5506 33.8199 36.5256C30.7428 36.1912 27.7869 35.1397 25.1899 33.4556C22.7738 31.9202 20.7253 29.8717 19.1899 27.4556C17.4999 24.8468 16.4482 21.8766 16.1199 18.7856C16.0949 18.509 16.1278 18.2303 16.2164 17.9672C16.3051 17.7041 16.4475 17.4623 16.6347 17.2572C16.8219 17.0521 17.0497 16.8883 17.3037 16.7761C17.5577 16.6639 17.8323 16.6058 18.1099 16.6056H21.1099C21.5952 16.6008 22.0657 16.7726 22.4337 17.0891C22.8017 17.4056 23.042 17.845 23.1099 18.3256C23.2366 19.2856 23.4714 20.2283 23.8099 21.1356C23.9445 21.4935 23.9736 21.8825 23.8938 22.2564C23.8141 22.6304 23.6288 22.9737 23.3599 23.2456L22.0899 24.5156C23.5135 27.0191 25.5864 29.092 28.0899 30.5156L29.3599 29.2456C29.6318 28.9767 29.9751 28.7914 30.3491 28.7117C30.723 28.6319 31.112 28.661 31.4699 28.7956C32.3772 29.1341 33.3199 29.3689 34.2799 29.4956C34.7657 29.5641 35.2093 29.8088 35.5265 30.1831C35.8436 30.5573 36.0121 31.0351 35.9999 31.5256Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="hidden xl:flex"><?php echo esc_html($phone_number); ?></span>
          </a>
      <?php endif; ?>

      <?php if ($contact_button) : ?>
        <a
          href="<?php echo esc_url($contact_button['url']); ?>"
          target="<?php echo esc_attr($contact_button['target'] ?: '_self'); ?>"
          class="btn flex gap-2 justify-center items-center self-stretch px-6 py-4 my-auto text-sm font-semibold leading-none text-black bg-secondary hover:bg-orange-500 focus:bg-orange-500 rounded min-h-[52px] max-md:px-5 transition-colors duration-200 max-lg:hidden"
          role="button"
        >
          <span class="text-center text-black whitespace-nowrap">
            <?php echo esc_html($contact_button['title']); ?>
          </span>
        </a>
      <?php endif; ?>
     <!-- Mobile Menu Toggle -->
    <?php get_template_part('template-parts/header/navbar/mobile'); ?>
    </div>
  </nav>
</section>

<?php
// Import Navi if not already imported
use Log1x\Navi\Navi;

// Get navigation objects if not already set
if (!isset($primary_navigation)) {
  $primary_navigation = Navi::make()->build('primary');
}
if (!isset($secondary_navigation)) {
  $secondary_navigation = Navi::make()->build('secondary');
}

$enable_hamburger   = get_field('enable_hamburger', 'option');
$hamburger_style    = get_field('hamburger_style', 'option');
$mobile_menu_effect = get_field('mobile_menu_effect', 'option') ?: 'slide_up';
$mobile_menu_width  = get_field('mobile_menu_width', 'option') ?: 100;
$mobile_menu_bg     = get_field('mobile_menu_background', 'option') ?: '#FFFFFF';
$sticky_menu        = get_field('sticky_menu', 'option'); // Sticky menu toggle

// Contact card (dynamic from options)
$contact_enable = (bool) (get_field('mobile_contact_enable', 'option') ?? true);
$contact_phone  = get_field('mobile_contact_phone', 'option') ?: '+353 1 283 2967';
$contact_icon   = get_field('mobile_contact_icon', 'option'); // ACF image array
$contact_label  = get_field('mobile_contact_label', 'option') ?: 'Contact us';
$contact_link   = get_field('mobile_contact_link', 'option'); // ACF link array
$contact_box_bg = get_field('mobile_contact_box_bg', 'option') ?: '#F9FAFB'; // gray-50 fallback

// Map effects to transition classes
$effect_classes = [
  'slide_up'    => 'translate-y-full',
  'slide_left'  => '-translate-x-full',
  'slide_right' => 'translate-x-full',
  'fullscreen'  => 'translate-y-full',
];
$transition_class = $effect_classes[$mobile_menu_effect] ?? 'translate-y-full';

// Define additional styles for non-fullscreen menus
$menu_width_style = $mobile_menu_effect !== 'fullscreen'
  ? "width: {$mobile_menu_width}%; left: 0;"
  : "width: 100%;";

// Validate the hamburger style to prevent invalid classes
$valid_styles = [
  'hamburger--3dx', 'hamburger--3dx-r', 'hamburger--3dy', 'hamburger--3dy-r',
  'hamburger--3dxy', 'hamburger--3dxy-r', 'hamburger--arrow', 'hamburger--arrow-r',
  'hamburger--arrowalt', 'hamburger--arrowalt-r', 'hamburger--arrowturn', 'hamburger--arrowturn-r',
  'hamburger--boring', 'hamburger--collapse', 'hamburger--collapse-r', 'hamburger--elastic',
  'hamburger--elastic-r', 'hamburger--emphatic', 'hamburger--emphatic-r', 'hamburger--minus',
  'hamburger--slider', 'hamburger--slider-r', 'hamburger--spin', 'hamburger--spin-r',
  'hamburger--spring', 'hamburger--spring-r', 'hamburger--stand', 'hamburger--stand-r',
  'hamburger--squeeze', 'hamburger--vortex', 'hamburger--vortex-r',
];

if (!in_array($hamburger_style, $valid_styles, true)) {
  $hamburger_style = 'hamburger--spin'; // Fallback to default style
}
?>

<?php if ($enable_hamburger): ?>
  <button
    :class="{ 'is-active z-50 bg-transparent hover:bg-transparent flex items-center justify-center ': isOpen }"
    class="hamburger <?php echo esc_attr($hamburger_style); ?> lg:hidden"
    type="button"
    aria-label="Menu"
    :aria-expanded="isOpen ? 'true' : 'false'"
    @click="isOpen = !isOpen">
    <span class="hamburger-box">
      <span class="hamburger-inner"></span>
    </span>
  </button>
<?php endif; ?>

<?php if ($enable_hamburger && $primary_navigation->isNotEmpty()): ?>
  <div
    x-show="isOpen"
    :class="{ '<?php echo esc_attr($transition_class); ?>': !isOpen, 'translate-x-0 translate-y-0': isOpen }"
    class="absolute top-0 left-0 z-40 h-screen <?php echo esc_attr($transition_class); ?> bg-white transition-transform duration-500 ease-out"
    style="background-color: <?php echo esc_attr($mobile_menu_bg); ?>; <?php echo esc_attr($menu_width_style); ?>"
    x-transition:enter="transition ease-out duration-500"
    x-transition:leave="transition ease-in duration-300"
    @click.away="isOpen = false"
  >
    <nav class="flex overflow-y-auto flex-col justify-center items-center px-8 h-full">
      <ul class="flex relative flex-col justify-start py-10 mx-auto space-y-8 w-full text-left">
        <?php foreach ($primary_navigation->toArray() as $index => $item) : ?>
          <?php $submenu_id = 'mobile-submenu-' . $index; ?>
          <li class="relative pt-6 border-t border-[#CCDEE2] text-[14px] <?php echo esc_attr($item->classes); ?> <?php echo $item->active ? 'current-item' : ''; ?>">
            <div class="flex justify-between items-center">
              <!-- Top-Level Link -->
              <a
                href="<?php echo esc_url($item->url); ?>"
                class="text-[14px] font-normal leading-7 text-secondary-800">
                <?php echo esc_html($item->label); ?>
              </a>

              <!-- Toggle (Font Awesome chevrons) -->
              <?php if ($item->children) : ?>
                <button
                  type="button"
                  class="flex justify-center items-center ml-4 w-8 h-8"
                  @click.stop="toggleDropdown(<?php echo $index; ?>)"
                  :aria-expanded="activeDropdown === <?php echo $index; ?> ? 'true' : 'false'"
                  aria-label="Toggle sub-menu"
                  :aria-controls="'<?php echo $submenu_id; ?>'">
                  <i class="fa-solid" :class="activeDropdown === <?php echo $index; ?> ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                </button>
              <?php endif; ?>
            </div>

            <!-- Child Submenu -->
            <?php if ($item->children) : ?>
              <ul
                id="<?php echo esc_attr($submenu_id); ?>"
                x-show="activeDropdown === <?php echo $index; ?>"
                x-transition
                style="display: none;"
                class="flex flex-col items-start gap-2 p-6 px-8 mt-4 text-[14px] transition-all duration-300 rounded-lg text-gray-700 bg-[#E6EEF1]">
                <?php foreach ($item->children as $child) : ?>
                  <li class="text-left">
                    <a href="<?php echo esc_url($child->url); ?>" class="block py-2">
                      <?php echo esc_html($child->label); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Contact Card (dynamic) -->
      <?php if ($contact_enable): ?>
        <section class="flex overflow-hidden absolute bottom-0 w-full">
          <div class="flex flex-col items-center mx-auto w-full">
            <div class="flex flex-col justify-center p-6 pb-16 w-full rounded"
                 style="background-color: <?php echo esc_attr($contact_box_bg); ?>;">
              <div class="flex gap-4 items-center w-full">
                <?php
                  $phone_clean = preg_replace('/\s+/', '', $contact_phone);
                  $phone_href  = $phone_clean ? 'tel:' . $phone_clean : '';
                ?>
                <a
                  class="flex gap-2 justify-center items-center px-3.5 whitespace-nowrap btn hover:bg-hover hover:text-hover"
                  aria-label="<?php echo esc_attr('Call phone number ' . $contact_phone); ?>"
                  href="<?php echo esc_url($phone_href); ?>"
                >
                  <?php if (is_array($contact_icon) && !empty($contact_icon['url'])): ?>
                    <img
                      src="<?php echo esc_url($contact_icon['url']); ?>"
                      alt="<?php echo esc_attr($contact_icon['alt'] ?: 'Phone icon'); ?>"
                      title="<?php echo esc_attr($contact_icon['title'] ?: ''); ?>"
                      class="object-contain"
                    />
                  <?php else: ?>
                    <!-- Fallback to FA phone icon if no image set -->
                    <i class="fa-solid fa-phone"></i>
                  <?php endif; ?>
                </a>
                <p class="text-sm font-semibold leading-none text-slate-700">
                  <?php echo esc_html($contact_phone); ?>
                </p>
              </div>

              <?php
                $btn_url    = is_array($contact_link) && !empty($contact_link['url']) ? $contact_link['url'] : home_url('/contact');
                $btn_target = is_array($contact_link) && !empty($contact_link['target']) ? $contact_link['target'] : '_self';
                $btn_title  = is_array($contact_link) && !empty($contact_link['title'])  ? $contact_link['title']  : $contact_label;
              ?>
              <a
                class="btn flex gap-2 justify-center items-center px-6 py-4 mt-8 w-full text-sm font-semibold leading-none text-black bg-orange-400 rounded min-h-[52px] hover:bg-hover hover:text-black whitespace-nowrap"
                href="<?php echo esc_url($btn_url); ?>"
                target="<?php echo esc_attr($btn_target); ?>"
                aria-label="<?php echo esc_attr($btn_title); ?>"
              >
                <span class="text-black"><?php echo esc_html($contact_label); ?></span>
              </a>
            </div>
          </div>
        </section>
      <?php endif; ?>
    </nav>
  </div>
<?php endif; ?>

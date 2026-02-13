<div class="flex py-8 m-auto w-full bg-white max-sm:py-2">
  <div class="w-full px-5 m-auto max-w-[1536px] flex justify-between items-center max-lg:flex-col-reverse" role="contentinfo">

    <div class="w-full text-sm font-medium leading-5 md:w-auto text-neutral-600">
      <span>
        Copyright © 2024 Hanley Pepper | Designed and developed by
        <a href="https://www.matrixinternet.ie"
          target="_blank"
          rel="noopener noreferrer"
          class="underline hover:text-secondary focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#000]"
          aria-label="Visit Matrix Internet website (opens in a new tab)">
          Matrix Internet
        </a>
      </span>
    </div>

    <!-- standard nav visible on md+ -->
    <nav class="hidden flex-col gap-8 w-full text-sm font-medium leading-5 footer-nav md:flex lg:flex-row lg:items-center md:w-auto text-neutral-600"
      role="navigation"
      aria-label="Secondary footer navigation">

      <?php
      wp_nav_menu([
        'theme_location' => 'copyright',
        'menu_class'     => 'flex flex-col sm:flex-row gap-8 items-start sm:items-center',
        'container'      => false,
        'depth'          => 1,
        'fallback_cb'    => false,
        'link_before'    => '<span class="text-neutral-600 hover:text-primary">',
        'link_after'     => '</span>',
      ]);
      ?>
    </nav>

    <!-- select nav visible below md -->
    <select
      class="block p-2 w-full text-sm rounded border border-gray-300 max-lg:my-5 footer-nav-select md:hidden text-neutral-600"
      aria-label="Footer navigation"
    >
      <option value="">Quick Links...</option>
    </select>

  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const select = document.querySelector('.footer-nav-select');
  const navLinks = document.querySelectorAll('.footer-nav a');

  if (select && navLinks.length) {
    navLinks.forEach(link => {
      const option = document.createElement('option');
      option.value = link.href;
      option.textContent = link.textContent.trim();
      select.appendChild(option);
    });

    select.addEventListener('change', function() {
      if (this.value) {
        window.location.href = this.value;
      }
    });
  }
});
</script>

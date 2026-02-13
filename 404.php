<?php
get_header(); ?>

<?php
// Fetch the entire 404 settings group first
$not_found_settings = get_field('not_found_settings', 'option');

// Fallbacks, in case no data is set in ACF:
$title = $not_found_settings['hero_title'] ?? 'Sorry, We Can’t Find That Page.';
$text = $not_found_settings['hero_text'] ?? 'Here are some helpful links to get you back on track:';
$links = $not_found_settings['links'] ?? []; // The repeater array
$bg_color = $not_found_settings['background_color'] ?? '#f8f9fa';
$text_color = $not_found_settings['text_color'] ?? '#333';
$padding_top = $not_found_settings['padding_top'] ?? 'py-10';
$padding_bottom = $not_found_settings['padding_bottom'] ?? 'pb-10';
?>

<main class="flex overflow-hidden justify-center items-center w-full site-main mt-[5rem] lg:mt-[10rem]"
  style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

      <div
        class="flex flex-col items-center pt-5 pb-5 mx-auto w-full xl:flex-row max-lg:px-5 max-w-container"
      >
   
          <figure
            class="overflow-hidden my-auto w-full rounded-none bg-blend-normal xl:w-1/2"
          >
            <div
              class="flex relative flex-col w-full xl:max-h-[700px] max-md:max-w-full max-sm:min-h-[246px] rounded-tr-3xl rounded-br-3xl"
            >
              <img
                src="https://cdn.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/5e8dc16bd588cdcca27f68b3c078f7c6c4367427?placeholderIfAbsent=true"
                alt="404 error background image"
                class="object-cover relative inset-0 w-full rounded-tr-3xl rounded-br-3xl"
                aria-hidden="true"
              />
            </div>
          </figure>
          <article
            class="flex flex-col px-5 my-auto w-full xl:flex-1 xl:px-24 xl:w-1/2"
          >
            <h1
              class="text-6xl font-bold tracking-tighter text-primary leading-[72px] max-md:max-w-full max-md:text-4xl max-md:leading-[53px] max-lg:mt-8"
            >
             <?php echo esc_html($title); ?>
            </h1>
            <div
              class="mt-4 text-xl leading-snug text-slate-700 max-md:max-w-full"
            >
             <?php echo wp_kses_post($text); ?>
            </div>
            <div
              class="pt-8 mt-4 text-sm font-semibold leading-none text-black max-sm:pt-4"
            >
            <aflex overflow-hidden justify-center items-center w-full site-main mt-[10rem]
              href="/"
              class="flex gap-2 justify-center items-center px-7 py-4 text-black whitespace-nowrap rounded group bg-secondary border-[#da6d1d] border min-h-14 max-md:px-5 w-fit hover:bg-transparent hover:text-black focus-visible:text-black"
              role="button"
            >
              <span class="my-auto">Return Home</span>
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" aria-hidden="true" focusable="false">
                <!-- use currentColor so it stays/turns black with the text -->
                <path d="M5 12.2109H19M19 12.2109L12 5.21094M19 12.2109L12 19.2109"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </aflex>
            </div>
          </article>
      </div>
</main>


<?php
get_footer();
?>
<?php
$section_id = uniqid('clients-002-');

$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$heading_color = get_sub_field('heading_color');
$background_color = get_sub_field('background_color');
$clients = get_sub_field('clients');

// Padding classes
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

// Client card with overlay, zoom, and accessible color transition
function render_client_card($client) {
    if (!$client) return;
    ?>
    <a href="<?php echo esc_url($client['link']['url'] ?? '#'); ?>"
       class="group flex overflow-hidden relative flex-col rounded-lg min-h-[530px] max-mob:min-h-[300px] max-h-[530px] max-mob:max-h-[300px] transition-shadow duration-300 focus-within:ring-4 focus-within:ring-orange-400 btn"
       style="transition: box-shadow .3s cubic-bezier(.4,0,.2,1);"
       aria-label="View <?php echo esc_attr($client['client_name'] ?? 'client details'); ?>"
       target="<?php echo esc_attr($client['link']['target'] ?? '_self'); ?>">

        <div class="overflow-hidden absolute inset-0 w-full h-full rounded-lg">
            <img src="<?php echo esc_url($client['image']['url'] ?? ''); ?>"
                 alt="<?php echo esc_attr($client['image']['alt'] ?? $client['client_name'] ?? 'Client image'); ?>"
                 class="object-cover w-full h-full" />
            <div class="absolute inset-0 pointer-events-none"
                 style="background: linear-gradient(0deg, #000 0%, rgba(0,0,0,0.00) 104.03%);"></div>
        </div>

        <div class="flex justify-between items-end px-8 pt-20 pb-6 w-full min-h-[149px] max-md:px-5 h-full absolute bottom-0 z-10">
            <div class="flex flex-col flex-1 shrink basis-0 min-w-60">
                <span class="text-[12px] md:text-xs leading-none text-white "><?php echo esc_html($client['subtitle'] ?? 'SUBTITLE'); ?></span>
                <span class="mt-1 text-[18px] md:text-2xl font-bold leading-none text-white"><?php echo esc_html($client['client_name'] ?? 'Client name'); ?></span>
            </div>
            <button
                aria-label="View client details"
                type="button"
                class="transition-colors duration-300 rounded-full p-2 bg-transparent
                       group-hover:bg-[#DA6D1D] group-focus-within:bg-[#DA6D1D] focus-visible:bg-[#DA6D1D]
                       focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-400"
            >
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M7.66675 17.2109L17.6667 7.21094M17.6667 7.21094H7.66675M17.6667 7.21094V17.2109"
                          stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </a>
    <?php
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative"
         style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="flex flex-col items-center w-full mx-auto max-w-[1480px] max-lg:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
        <div class="flex overflow-hidden flex-col justify-center w-full font-bold text-white bg-white max-md:px-5">

            <?php if ($heading_text): ?>
                <<?php echo esc_html($heading_tag); ?>
                    class="text-3xl font-bold leading-tight"
                    style="color: <?php echo esc_attr($heading_color); ?>;">
                    <?php echo esc_html($heading_text); ?>
                </<?php echo esc_html($heading_tag); ?>>
            <?php endif; ?>

            <?php if ($clients): ?>
                <div class="grid grid-cols-1 gap-6 items-start mt-8 w-full client-slider md:grid-cols-2 lg:grid-cols-3 max-md:max-w-full">
                    <?php foreach ($clients as $client): ?>
                        <?php render_client_card($client); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    const sliderSelector = '#<?php echo esc_attr($section_id); ?> .client-slider';

    function destroySlickAndRestoreGrid($slider) {
        if ($slider.hasClass('slick-initialized')) {
            $slider.slick('unslick');
            $slider.find('.slick-slide').children().unwrap();
            $slider.find('.slick-track, .slick-list').remove();
            $slider.removeClass('slick-initialized slick-slider slick-track slick-list flex')
                   .addClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6');
        }
    }

    function initClientSlider() {
        const $slider = $(sliderSelector);

        if ($(window).width() < 1084) {
            if (!$slider.hasClass('slick-initialized')) {
                $slider.removeClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6').addClass('flex');

                $slider.slick({
                    centerMode: true,
                    centerPadding: '15%',
                    slidesToShow: 1,
                    dots: true,
                    arrows: true,
                    prevArrow: `<button type="button" class="slick-prev" aria-label="Previous client">
                        <svg width="40" height="40" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="8" width="56" height="56" rx="4" fill="#DE7C34"/>
                            <rect x="4" y="4" width="64" height="64" rx="8" stroke="white" stroke-opacity="0.1" stroke-width="8"/>
                            <path d="M43 36H29M29 36L36 29M29 36L36 43" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>`,
                    nextArrow: `<button type="button" class="slick-next" aria-label="Next client">
                        <svg width="40" height="40" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="8" width="56" height="56" rx="4" fill="#DE7C34"/>
                            <rect x="4" y="4" width="64" height="64" rx="8" stroke="white" stroke-opacity="0.1" stroke-width="8"/>
                            <path d="M29 36H43M43 36L36 29M43 36L36 43" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>`,
                    responsive: [
                        {
                            breakpoint: 575,
                            settings: {
                                centerMode: false,
                                centerPadding: '0',
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            }
        } else {
            destroySlickAndRestoreGrid($slider);
        }
    }

    initClientSlider();
    $(window).on('resize orientationchange', initClientSlider);
});
</script>


<?php
$item      = $args['item']   ?? null;
$imagesMap = $args['images'] ?? [];
// ------------- guard -------------
if (!$item) {
    return;
}

/**
 * Get the WP menu-item ID that was used in the repeater.
 * Navi exposes both ->id and ->ID depending on version,
 * so ask for whichever exists first.
 */
$item_id = $item->ID ?? $item->id ?? null;

/** @var array|null $img  Full image array or null */
$img = $imagesMap[ $item_id ] ?? null;

/** Use safe helpers so null never throws notices */
$img_url   = is_array($img) && !empty($img['url'])   ? $img['url']   : '';
$img_alt   = is_array($img) && !empty($img['alt'])   ? $img['alt']   : ( $item->label . ' image' );
$img_title = is_array($img) && !empty($img['title']) ? $img['title'] : $img_alt;
?>
<div class="fixed left-0 top-[80px] w-screen bg-transparent pt-10 hidden group-hover:flex overflow-hidden z-50">
  <div class="w-full bg-gray-50">
    <div class="flex flex-wrap gap-10 justify-between w-full max-w-[1440px] mx-auto text-base font-medium text-slate-700">

      <!-- Left — links -->
      <nav class="flex flex-col justify-start items-start px-5">
        <span class="pt-8 pb-2 text-3xl font-bold leading-tight text-slate-700">
          <?php echo esc_html($item->label); ?>
        </span>
        <ul class="flex flex-col gap-2 mt-2">
          <?php foreach ($item->children as $child) : ?>
            <li class="flex flex-col justify-center pt-1 whitespace-nowrap">
              <a href="<?php echo esc_url($child->url); ?>" class="gap-1 hover:text-[#003800]">
                <?php echo esc_html($child->label); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <!-- Right — dynamic image if set -->
      <?php if ($img_url) : ?>
        <img
          src="<?php echo esc_url($img_url); ?>"
          alt="<?php echo esc_attr($img_alt); ?>"
          title="<?php echo esc_attr($img_title); ?>"
          class="object-cover h-full max-h-fit w-full max-w-[768px] max-md:max-w-full"
        />
      <?php endif; ?>

    </div>
  </div>
</div>

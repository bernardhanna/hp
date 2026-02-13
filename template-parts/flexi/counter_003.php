<?php
$id = uniqid('counter-003-');
$image = get_sub_field('image');
$heading_text = get_sub_field('heading_text');
$heading_tag = get_sub_field('heading_tag');

$projects_value = get_sub_field('projects_value');
$projects_description = get_sub_field('projects_description');
$energy_value = get_sub_field('energy_value');
$energy_description = get_sub_field('energy_description');
$clients_value = get_sub_field('clients_value');
$clients_description = get_sub_field('clients_description');
$incidents_value = get_sub_field('incidents_value');
$incidents_description = get_sub_field('incidents_description');
?>

<style>
.sr-only {
  position: absolute;
  width: 1px; height: 1px; padding: 0; margin: -1px;
  overflow: hidden; clip: rect(0,0,0,0); border: 0;
}
</style>

<section x-data="statsCounter()" x-intersect:enter.once="startCount()" id="<?php echo esc_attr($id); ?>" class="flex overflow-hidden relative lg:bg-gray-50">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1200px] max-xxl:px-5 pt-[1.5rem] pb-[1.5rem] md:pt-[4.5rem] md:pb-[4.5rem]">
    <div class="flex flex-col gap-10 justify-between items-center w-full sm:flex-row">
      <!-- Image -->
      <div class="flex overflow-hidden flex-col bg-gray-200 rounded-full  w-auto lg:w-[480px] max-md:max-w-full">
        <?php if ($image): ?>
          <img
            loading="lazy"
            src="<?php echo esc_url($image['url']); ?>"
            alt="<?php echo esc_attr($image['alt'] ?: 'Stats image'); ?>"
            title="<?php echo esc_attr($image['title'] ?: 'Stats image'); ?>"
            class="object-contain w-full"
          />
        <?php endif; ?>
      </div>

      <!-- Stats -->
      <div class="flex flex-col w-full lg:w-[568px] max-md:max-w-full">
        <div class="flex gap-6 items-center text-[20px] md:text-3xl font-bold leading-tight text-center text-slate-700">
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

<div class="grid grid-cols-2 gap-10 mt-12 w-full max-md:mt-10 max-md:max-w-full">
  <div class="flex flex-col w-64 max-md:pr-8">
    <div
      class="text-5xl font-bold tracking-tighter leading-none text-primary max-md:text-[30px]"
      x-text="projects >= 0 ? '+' + projects.toFixed(1) + 'K' : projects.toFixed(1) + 'K'"
      aria-live="polite"
      aria-label="Projects completed"
      id="projects-counter"
    ></div>
    <div class="mt-2 max-md:text-[14px] text-base leading-6 text-slate-700 max-lg:max-w-[70%]"><?php echo esc_html($projects_description); ?></div>
  </div>
  <div class="flex flex-col w-64">
    <div
      class="text-5xl font-bold tracking-tighter leading-none text-primary max-md:text-4xl"
      x-text="energy.toFixed(0) + '%'"
      aria-live="polite"
      aria-label="Energy value"
      id="energy-counter"
    ></div>
    <div class="mt-2 max-md:text-[14px] text-base text-slate-700"><?php echo esc_html($energy_description); ?></div>
  </div>
  <div class="flex flex-col w-64">
    <div
      class="text-5xl font-bold tracking-tighter leading-none text-primary max-md:text-4xl"
      x-text="clients.toFixed(0) + '%'"
      aria-live="polite"
      aria-label="Clients value"
      id="clients-counter"
    ></div>
    <div class="mt-2 text-base text-slate-700"><?php echo esc_html($clients_description); ?></div>
  </div>
  <div class="flex flex-col w-64">
    <div
      class="text-5xl font-bold tracking-tighter leading-none text-primary max-md:text-4xl"
      x-text="incidents.toFixed(1) + '%'"
      aria-live="polite"
      aria-label="Incidents value"
      id="incidents-counter"
    ></div>
    <div class="mt-2 max-md:text-[14px] text-base text-slate-700"><?php echo esc_html($incidents_description); ?></div>
  </div>
</div>

      </div>
    </div>
  </div>
</section>

<script>
function statsCounter() {
  return {
    inView: false,
    projects: 0,
    energy: 0,
    clients: 0,
    incidents: 0,
    startCount() {
      if (!this.inView) {
        this.inView = true;
        this.animateValue('projects', 0, <?php echo floatval($projects_value); ?>, 1500);
        this.animateValue('energy', 0, <?php echo floatval($energy_value); ?>, 1500);
        this.animateValue('clients', 0, <?php echo floatval($clients_value); ?>, 1500);
        this.animateValue('incidents', 0, <?php echo floatval($incidents_value); ?>, 1500);
      }
    },
    animateValue(prop, start, end, duration) {
      let range = end - start;
      let stepTime = 20;
      let steps = Math.round(duration / stepTime);
      let increment = range / steps;
      let currentStep = 0;

      let timer = setInterval(() => {
        start += increment;
        currentStep++;
        this[prop] = start;
        if (currentStep === steps) {
          clearInterval(timer);
          this[prop] = end;
        }
      }, stepTime);
    }
  }
}
</script>

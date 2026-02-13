<?php
$client            = get_sub_field('client');
$project_lead      = get_sub_field('project_lead');
$services_provided = get_sub_field('services_provided');
?>
<section class="flex overflow-hidden relative max-xxl:mx-5">
  <div class="flex flex-col items-center w-full max-w-[1472px] mx-auto rounded-lg bg-primary">
    <article class="flex flex-col lg:flex-row gap-10 justify-between max-w-[1216px] mx-auto max-xxl:px-5 items-start py-4 lg:py-12 w-full h-full"
             role="region"
             aria-label="Project Information">
      <?php if ($client): ?>
      <div class="project-client">
        <span class="text-lg font-bold leading-none text-secondary">Client</span>
        <p class="mt-1 text-base text-yellow-100"><?= esc_html($client) ?></p>
      </div>
      <?php endif; ?>
      <div class="flex shrink-0 w-0 bg-yellow-100 border border-yellow-100 border-solid h-[108px] max-md:hidden max-lg:hidden" role="separator" aria-hidden="true"></div>
      <?php if ($project_lead): ?>
      <div class="project-lead">
        <span class="text-lg font-bold leading-none text-secondary">Project Type</span>
        <p class="mt-1 text-base text-yellow-100"><?= esc_html($project_lead) ?></p>
      </div>
      <?php endif; ?>
      <div class="flex shrink-0 w-0 bg-yellow-100 border border-yellow-100 border-solid h-[108px] max-md:hidden max-lg:hidden" role="separator" aria-hidden="true"></div>
      <?php if ($services_provided): ?>
      <div class="text-base text-yellow-100 service-list min-w-60 max-md:max-w-full">
        <span class="text-lg font-bold leading-none text-secondary">Services Provided</span>
        <ul class="mt-1 space-y-1" role="list">
          <?php foreach ($services_provided as $row): ?>
            <?php if (!empty($row['service'])): ?>
            <li><?= esc_html($row['service']) ?></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </article>
  </div>
</section>

<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$projectDetails = new FieldsBuilder('project_details', [
  'label' => 'Project Details',
]);

$projectDetails
  ->addTab('Content', ['placement' => 'top'])
    ->addText('client', [
      'label' => 'Client',
    ])
    ->addText('project_lead', [
      'label' => 'Project Lead',
    ])
    ->addRepeater('services_provided', [
      'label'        => 'Services Provided',
      'button_label' => 'Add Service',
    ])
      ->addText('service', [
        'label' => 'Service',
      ])
    ->endRepeater();

return $projectDetails;

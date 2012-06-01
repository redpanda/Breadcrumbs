<?php

require __DIR__.'/../../vendor/autoload.php';

use Breadcrumbs\TrailCollection;
use Breadcrumbs\BreadcrumbFactory;
use Breadcrumbs\Renderer\ListRenderer;

$factory = BreadcrumbFactory::create();
$collection = new TrailCollection();

$collection->add('test', $factory->createTrail()->add($factory->createCrumb('Test', '/test')));

return $collection;

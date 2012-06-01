<?php

require __DIR__.'/../../vendor/autoload.php';

use Breadcrumbs\TrailCollection;
use Breadcrumbs\BreadcrumbFactory;
use Breadcrumbs\Renderer\ListRenderer;

$factory = BreadcrumbFactory::create();
$collection = new TrailCollection();

$collection->add('homepage', $factory->createTrail()->add($factory->createCrumb('Homepage', '/')));
$collection->add('foo', $factory->createTrail()->add($factory->createCrumb('Foo', '/foo')));
$collection->add('bar', $factory->createTrail()->add($factory->createCrumb('Bar', '/bar')), 'homepage');

return $collection;

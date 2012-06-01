<?php

require __DIR__.'/../vendor/autoload.php';

use Breadcrumbs\BreadcrumbFactory;
use Breadcrumbs\Crumb;
use Breadcrumbs\TrailCollection;
use Breadcrumbs\Renderer\ListRenderer;

$factory = BreadcrumbFactory::create(); 
$collection = new TrailCollection();

$collection->add('homepage', $factory
    ->createTrail()
        ->add($factory->createCrumb('Homepage', '/', array('class' => 'foo', 'id' => 'home')))
);

$collection->add('foo', $factory
    ->createTrail()
        ->add($factory->createCrumb('Foo', '/foo'))
);

$renderer = new ListRenderer(' &gt; ');
echo $renderer->render($collection->get('homepage')).PHP_EOL;
echo $renderer->render($collection->get('foo')).PHP_EOL;

<?php

require __DIR__.'/../../vendor/autoload.php';

use Breadcrumbs\BreadcrumbFactory;
use Breadcrumbs\TrailCollection;
use Breadcrumbs\Provider;
use Breadcrumbs\Loader\PhpFileLoader;
use Breadcrumbs\Renderer\ListRenderer;
use Symfony\Component\Config\FileLocator;

$loader = new PhpFileLoader(new FileLocator(array(__DIR__.'/../Fixtures')));
$collection = $loader->load('b1.php');

$renderer = new ListRenderer(' > ');
echo $renderer->render($collection->get('homepage')).PHP_EOL;
echo $renderer->render($collection->get('foo')).PHP_EOL;
echo $renderer->render($collection->get('bar')).PHP_EOL;

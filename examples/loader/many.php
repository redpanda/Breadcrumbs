<?php

require __DIR__.'/../../vendor/autoload.php';

use Breadcrumbs\BreadcrumbFactory;
use Breadcrumbs\TrailCollection;
use Breadcrumbs\Provider;
use Breadcrumbs\Loader\PhpFileLoader;
use Breadcrumbs\Loader\YamlFileLoader;
use Breadcrumbs\Renderer\ListRenderer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;

$resolver = new LoaderResolver();

$resolver->addLoader(new YamlFileLoader(new FileLocator(array(__DIR__.'/../Fixtures'))));
$resolver->addLoader(new PhpFileLoader(new FileLocator(array(__DIR__.'/../Fixtures'))));

$loader = $resolver->resolve('many_type.yml');
$collection = $loader->load('many_type.yml');

$renderer = new ListRenderer(' > ');
echo $renderer->render($collection->get('homepage')).PHP_EOL;
echo $renderer->render($collection->get('test')).PHP_EOL;
echo $renderer->render($collection->get('bar')).PHP_EOL;



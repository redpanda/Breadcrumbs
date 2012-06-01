<?php

require __DIR__.'/../vendor/autoload.php';

use Breadcrumbs\Dumper\PhpTrailCollectionDumper;
use Breadcrumbs\Loader\YamlFileLoader;
use Breadcrumbs\Renderer\ListRenderer;
use Symfony\Component\Config\FileLocator;

$isDebug = true;
$file = __DIR__ .'/cache/breadcrumb/collection.php';

if (!$isDebug && file_exists($file)) {
    require_once $file;
    $collection = new MyBreadcrumbCollection();
} else {
    $loader = new YamlFileLoader(new FileLocator(array(__DIR__.'/Fixtures')));
    $collection = $loader->load('b1.yml');
    $dumper = new PhpTrailCollectionDumper($collection);
    file_put_contents($file, $dumper->dump(array('class' => 'MyBreadcrumbCollection')));
}

$renderer = new ListRenderer(' &gt; ');
echo $renderer->render($collection->get('homepage')).PHP_EOL;
echo $renderer->render($collection->get('foo')).PHP_EOL;
echo $renderer->render($collection->get('bar')).PHP_EOL;




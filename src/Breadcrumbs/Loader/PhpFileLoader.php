<?php

namespace Breadcrumbs\Loader;

use Breadcrumbs\Crumb;
use Breadcrumbs\Trail;
use Breadcrumbs\TrailCollection;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Yaml\Yaml;

class PhpFileLoader extends FileLoader
{
    public function load($file, $type = null)
    {
        // the loader variable is exposed to the included file below
        $loader = $this;

        $path = $this->locator->locate($file);
        $this->setCurrentDir(dirname($path));

        $collection = include $path;
        $collection->addResource(new FileResource($path));

        return $collection;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return Boolean True if this class supports the given resource, false otherwise
     *
     * @api
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION) && (!$type || 'php' === $type);
    }
}

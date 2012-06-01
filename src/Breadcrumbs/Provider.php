<?php

namespace Breadcrumbs;

use Breadcrumbs\TrailInterface;
use Symfony\Component\Config\Loader\LoaderInterface;

class Provider
{
    protected $loader;
    protected $collection;

    public function __construct(LoaderInterface $loader, $resource)
    {
        $this->loader   = $loader;
        $this->resource = $resource;
    }

    public function getTrailCollection()
    {
        if (null === $this->collection) {
            $this->collection = $this->loader->load($this->resource);
        }

        return $this->collection;
    }

    public function get($name)
    {
        return $this->getTrailCollection()->get($name);
    }
}

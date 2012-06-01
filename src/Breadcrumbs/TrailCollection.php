<?php

namespace Breadcrumbs;

use Breadcrumbs\Exception\TrailNotFoundException;
use Symfony\Component\Config\Resource\ResourceInterface;

class TrailCollection implements \IteratorAggregate
{
    protected $trails = array();
    protected $resources = array();

    public function add($name, TrailInterface $trail, $root = null)
    {
        $this->remove($name);

        if (null !== $root) {
            $root = $this->get($root);
            $crumbs = array_merge($root->getCrumbs(), $trail->getCrumbs());
            $trail->setCrumbs($crumbs);
        }

        $this->trails[$name] = $trail;
    }

    public function get($name)
    {
        if (!isset($this->trails[$name])) {
            throw new TrailNotFoundException(sprintf('Trail "%s" does not exist.', $name));
        }

        return $this->trails[$name];
    }

    public function all()
    {
        return $this->trails;
    }

    public function addCollection(TrailCollection $collection, $root = null)
    {
        foreach ($collection as $name => $trail) {
            $this->add($name, $trail, $root);
        }
    }

    public function addResource(ResourceInterface $resource)
    {
        $this->resources[] = $resource;
    }

    public function remove($name)
    {
        if (array_key_exists($name, $this->trails)) {
            unset($this->trails[$name]);
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->trails);
    }

}

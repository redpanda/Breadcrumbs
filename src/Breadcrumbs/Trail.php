<?php

namespace Breadcrumbs;

use Breadcrumbs\TrailInterface;

class Trail implements TrailInterface
{
    protected $crumbs = array();

    public function add(CrumbInterface $crumb)
    {
        $this->crumbs[] = $crumb;
        $crumb->setTrail($this);
        
        return $this;
    }

    public function get($offset)
    {
        if (!$this->has($offset)) {
            throw new \InvalidArgumentException(sprintf('The crumb "%s" doest not exists.', $offset));
        }

        return $this->crumbs[$offset];
    }

    public function has($offset)
    {
        return isset($this->crumbs[$offset]);
    }

    public function remove($offset)
    {
        if (!$this->has($offset)) {
            throw new \InvalidArgumentException(sprintf('The crumb "%s" doest not exists.', $offset));
        }

        unset($this->crumbs[$offset]);

        // hack to reset the array keys
        $this->crumbs = array_merge($this->crumbs);
    }

    public function setCrumbs(array $crumbs)
    {
        $this->crumbs = array();

        foreach ($crumbs as $crumb) {
            $this->add($crumb);
        }
    }

    public function getCrumbs()
    {
        return $this->crumbs;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {   
        return $this->add($value);
    }

    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    public function count()
    {
        return count($this->crumbs);
    }

    public function getIterator()
    {
        return new \ArrayObject($this->crumbs);
    }
}

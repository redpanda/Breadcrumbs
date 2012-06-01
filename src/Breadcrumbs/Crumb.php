<?php

namespace Breadcrumbs;

class Crumb implements CrumbInterface
{
    protected $title;
    protected $uri;
    protected $attributes;
    protected $trail;
    
    public function __construct($title, $uri = null, array $attributes = array())
    {
        $this->title = $title;
        $this->uri = $uri;
        $this->attributes = $attributes;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;   
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function hasUri()
    {
        return null !== $this->uri;
    }

    public function setAttributes(array $attributes = array())
    {
        $this->attributes = $attributes;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function isFirst()
    {
        if (null !== $this->trail) {
            return reset($this->trail->getCrumbs()) === $this;
        }

        return false;
    }

    public function isLast()
    {
        if (null !== $this->trail) {
            return end($this->trail->getCrumbs()) === $this;
        }

        return false;
    }
    
    public function setTrail(TrailInterface $trail)
    {
        $this->trail = $trail;
    }
    
    public function getTrail()
    {
        return $this->trail;
    }

    public function __toString()
    {
        return $this->title;
    }
}

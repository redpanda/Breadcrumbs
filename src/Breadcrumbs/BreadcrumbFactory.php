<?php

namespace Breadcrumbs;

class BreadcrumbFactory implements FactoryInterface
{
    static function create()
    {
        return new self();
    }

    public function createTrail()
    {
        return new Trail();
    }

    public function createCrumb($title, $uri, array $attributes = array())
    {
        return new Crumb($title, $uri, $attributes);
    }
}

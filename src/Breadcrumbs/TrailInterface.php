<?php

namespace Breadcrumbs;

interface TrailInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    function add(CrumbInterface $crumb);
    function getCrumbs();
}

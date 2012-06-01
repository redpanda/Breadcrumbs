<?php

namespace Breadcrumbs;

interface CrumbInterface
{
    function setTitle($title);
    function getTitle();
    function setUri($uri);
    function getUri();
    function setAttributes(array $attributes = array());
    function getAttributes();
    function addAttribute($name, $value);
    function isFirst();
    function isLast();
    function setTrail(TrailInterface $trail);
    function getTrail();
}

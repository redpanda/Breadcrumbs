<?php

namespace Breadcrumbs\Renderer;

use Breadcrumbs\TrailInterface;

interface RendererInterface
{
    function render(TrailInterface $trail);
}

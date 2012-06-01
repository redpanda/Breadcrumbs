<?php

namespace Breadcrumbs\Renderer;

use Breadcrumbs\CrumbInterface;
use Breadcrumbs\TrailInterface;

class ListRenderer implements RendererInterface
{
    protected $separator;

    public function __construct($separator)
    {
        $this->separator = $separator;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    public function render(TrailInterface $trail)
    {
        $res = '<ul>';

        foreach ($trail->getCrumbs() as $crumb) {
            $res .= '<li'.$this->renderAttributes($crumb->getAttributes()).'>';
            $res .= $this->renderCrumb($crumb);
            $res .= '</li>';
        }

        $res .= '</ul>';

        return $res;
    }

    protected function renderAttributes(array $attributes)
    {
        $res = '';

        foreach ($attributes as $key => $value) {
            $res .= sprintf(' %s="%s"', $key, $value);
        }

        return $res;
    }

    protected function renderCrumb(CrumbInterface $crumb)
    {
        if ($crumb->hasUri()) {
            return sprintf('<a href="%s">%s</a>', $crumb->getUri(), $crumb->getTitle());
        }

        return $crumb->getTitle();
    }
}

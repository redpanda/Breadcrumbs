<?php

namespace Breadcrumbs\Dumper;

use Breadcrumbs\TrailCollection;

class PhpTrailCollectionDumper
{
    protected $trails;

    public function __construct(TrailCollection $trails)
    {
        $this->trails = $trails;
    }

    public function getTrails()
    {
        return $this->trails;
    }

    public function dump(array $options = array())
    {
        $options = array_merge(array(
            'class'      => 'ProjectBreadcrumbProvider',
            'base_class' => 'Breadcrumb\\TrailCollection',
        ), $options);

        return <<<EOF
<?php

use Breadcrumbs\Crumb;
use Breadcrumbs\Trail;
use Breadcrumbs\Exception\TrailNotFoundException;

/**
 * {$options['class']}
 *
 * This class has been auto-generated
 * by the Breadcrumbs lib.
 */
class {$options['class']} extends {$options['base_class']}
{
    static private \$declaredTrails = {$this->generateDeclaredTrails()};

{$this->generateGetMethod()}
}

EOF;
    }

    /**
     * Generates PHP code representing an array of defined trails.
     *
     * @return string PHP code
     */
    private function generateDeclaredTrails()
    {
        $trails = "array(\n";
        foreach ($this->getTrails()->all() as $name => $trail) {

            $crumbs = array();
            foreach ($trail->getCrumbs() as $crumb) {
                $crumbs[] = array(
                    $crumb->getTitle(),
                    $crumb->getUri(),
                    $crumb->getAttributes(),
                );
            }

            $trails .= sprintf("        '%s' => %s,\n", $name, str_replace("\n", '', var_export($crumbs, true)));
        }
        $trails .= '    )';

        return $trails;
    }

    /**
     * Generates PHP code representing the `get` method.
     *
     * @return string PHP code
     */
    private function generateGetMethod()
    {
        return <<<EOF
    public function get(\$name, \$parameters = array(), \$absolute = false)
    {
        if (!isset(self::\$declaredTrails[\$name])) {
            throw new TrailNotFoundException(sprintf('Trail "%s" does not exist.', \$name));
        }

        \$trail = new Trail();
        foreach (self::\$declaredTrails[\$name] as \$crumb) {
            list(\$title, \$uri, \$attributes) = \$crumb;
            \$trail->add(new Crumb(\$title, \$uri, \$attributes));
        }

        return \$trail;
    }
EOF;
    }
}

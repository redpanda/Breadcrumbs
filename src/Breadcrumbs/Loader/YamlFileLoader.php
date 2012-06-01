<?php

namespace Breadcrumbs\Loader;

use Breadcrumbs\Crumb;
use Breadcrumbs\Trail;
use Breadcrumbs\TrailCollection;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Yaml\Yaml;

class YamlFileLoader extends FileLoader
{
    private static $availableKeys = array(
        'crumbs', 'resource', 'root', 'type'
    );

    public function load($file, $type = null)
    {
        $path = $this->locator->locate($file);

        $config = Yaml::parse($path);

        $collection = new TrailCollection();

        $collection->addResource(new FileResource($path));

        // empty file
        if (null === $config) {
            $config = array();
        }

        // not an array
        if (!is_array($config)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $file));
        }

        foreach ($config as $name => $config) {
            $config = $this->normalizeTrailConfig($config);

            if (isset($config['resource'])) {
                $root = isset($config['root']) ? $config['root'] : null;
                $type = isset($config['type']) ? $config['type'] : null;
                $this->setCurrentDir(dirname($path));
                $collection->addCollection($this->import($config['resource'], $type, false, $file), $root);
            } else {
                $this->parseTrail($collection, $name, $config, $path);
            }
        }

        return $collection;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return Boolean True if this class supports the given resource, false otherwise
     *
     * @api
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo($resource, PATHINFO_EXTENSION) && (!$type || 'yaml' === $type);
    }

    /**
     * Parses a trail and adds it to the TrailCollection.
     *
     * @param TrailCollection $collection A TrailCollection instance
     * @param string          $name       Trail name
     * @param array           $config     Trail definition
     * @param string          $file       A Yaml file path
     *
     * @throws \InvalidArgumentException When config pattern is not defined for the given route
     */
    protected function parseTrail(TrailCollection $collection, $name, $config, $file)
    {
        if (!isset($config['crumbs']) && !is_array($config['crumbs'])) {
            throw new \InvalidArgumentException(sprintf('You must define an array of crumbs for the "%s" route.', $name));
        }

        $trail = new Trail();
        
        foreach ($config['crumbs'] as $c) {
            if (!isset($c['title'])) {
                throw new \InvalidArgumentException(sprintf('You must define a "title" for the "%s" route.', $name));
            }

            $uri = isset($c['uri']) ? $c['uri'] : null;
            $attributes = isset($c['attributes']) ? $c['attributes'] : array();

            $trail->add(new Crumb($c['title'], $uri, $attributes));
        }

        $collection->add($name, $trail);
    }

    /**
     * Normalize breadcrumb configuration.
     *
     * @param array $config A resource config
     *
     * @return array
     *
     * @throws InvalidArgumentException if one of the provided config keys is not supported
     */
    private function normalizeTrailConfig(array $config)
    {
        foreach ($config as $key => $value) {
            if (!in_array($key, self::$availableKeys)) {
                throw new \InvalidArgumentException(sprintf(
                    'Yaml breadcrumb loader does not support given key: "%s". Expected one of the (%s).',
                    $key, implode(', ', self::$availableKeys)
                ));
            }
        }

        return $config;
    }
}

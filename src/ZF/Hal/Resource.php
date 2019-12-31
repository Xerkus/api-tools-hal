<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-hal for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-hal/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-hal/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Hal;

class Resource implements Link\LinkCollectionAwareInterface
{
    protected $id;

    /**
     * @var Link\LinkCollection
     */
    protected $links;

    protected $resource;

    /**
     * @param  object|array $resource
     * @param  mixed $id
     * @throws Exception\InvalidResourceException if resource is not an object or array
     */
    public function __construct($resource, $id)
    {
        if (!is_object($resource) && !is_array($resource)) {
            throw new Exception\InvalidResourceException();
        }

        $this->resource    = $resource;
        $this->id          = $id;
    }

    /**
     * Retrieve properties
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        $names = array(
            'resource'     => 'resource',
            'id'           => 'id',
        );
        $name = strtolower($name);
        if (!in_array($name, array_keys($names))) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Invalid property name "%s"',
                $name
            ));
        }
        $prop = $names[$name];
        return $this->{$prop};
    }

    /**
     * Set link collection
     *
     * @param  Link\LinkCollection $links
     * @return self
     */
    public function setLinks(Link\LinkCollection $links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     * Get link collection
     *
     * @return Link\LinkCollection
     */
    public function getLinks()
    {
        if (!$this->links instanceof Link\LinkCollection) {
            $this->setLinks(new Link\LinkCollection());
        }
        return $this->links;
    }
}

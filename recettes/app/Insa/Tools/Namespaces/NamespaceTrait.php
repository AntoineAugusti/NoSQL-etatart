<?php

namespace Insa\Tools\Namespaces;

use ReflectionClass;

trait NamespaceTrait
{
    /**
     * Get the base namespace of the current class.
     *
     * @return string
     */
    public function getBaseNamespace()
    {
        $reflection = new ReflectionClass(__CLASS__);

        return $reflection->getNamespaceName().'\\';
    }

    /**
     * Get the full path to the Composers folder.
     *
     * @return string
     */
    public function getNamespaceComposers()
    {
        return $this->getBaseNamespace().'Composers\\';
    }

    /**
     * Get the full path to the Controllers folder.
     *
     * @return string
     */
    public function getNamespaceControllers()
    {
        return $this->getBaseNamespace().'Controllers';
    }

    /**
     * Get the full path to the Repositories folder.
     *
     * @return string
     */
    public function getNamespaceRepositories()
    {
        return $this->getBaseNamespace().'Repositories\\';
    }
}

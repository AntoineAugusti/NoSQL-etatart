<?php namespace Insa\Tools\Namespaces;

use ReflectionClass;

trait NamespaceTrait {

	public function getBaseNamespace()
	{	
		$reflection = new ReflectionClass(__CLASS__);
		return $reflection->getNamespaceName().'\\';
	}

	public function getNamespaceComposers()
	{
		return $this->getBaseNamespace().'Composers\\';
	}

	public function getNamespaceControllers()
	{
		return $this->getBaseNamespace().'Controllers';
	}

	public function getNamespaceRepositories()
	{
		return $this->getBaseNamespace().'Repositories\\';
	}
}
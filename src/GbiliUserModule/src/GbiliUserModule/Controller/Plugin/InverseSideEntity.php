<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace GbiliUserModule\Controller\Plugin;

/**
 *
 */
class InverseSideEntity extends \Zend\Mvc\Controller\Plugin\AbstractPlugin
{

    protected $entity;
    protected $entityClass;
    protected $lastCallResult;
    protected $lastCallSignature;

    /**
     * Grabs a param from route match by default.
     *
     * @param string $param
     * @param mixed $default
     * @return mixed
     */
    public function __invoke($entity, $forceQuery=false)
    {
        if ($forceQuery) {
            $this->lastCallResult    = null;
            $this->lastCallSignature = null;
        }

        $this->entity = $entity;
        $this->entityClass = get_class($entity);
        return $this;
    }

    public function has($propertyName)
    {
        $result = $this->getResult($propertyName);
        return !empty($result);
    }

    public function get($propertyName)
    {
        return $this->getResult($propertyName);
    }

    protected function getResult($propertyType)
    {
        $callSignature = $this->entityClass . $propertyType;
        if ($this->lastCallSignature === $callSignature) {
            return $this->lastCallResult;
        }

        $em = $this->controller->em();
        $result = $em->getRepository($propertyType)->findBy(array($this->entity));

        $this->lastCallResult = $result;
        $this->lastCallSignature = $callSignature;

        return $result;
    }
}

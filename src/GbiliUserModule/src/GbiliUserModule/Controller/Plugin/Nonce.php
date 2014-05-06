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
class Nonce extends \Zend\Mvc\Controller\Plugin\AbstractPlugin
{
    protected $nonceParamName = 'nonce';

    protected $service;


    public function setService(\User\Service\Nonce $service)
    {
        $this->service = $service;
        return $this;
    }

    public function getLastValidator()
    {
        return $this->service->getLastValidator();
    }

    /**
     * Grabs a param from route match by default.
     *
     * @param string $param
     * @param mixed $default
     * @return mixed
     */
    public function __invoke()
    {
        return $this;
    }

    public function setRouteName($name)
    {
        $this->service->setRouteName($name);
        return $this;
    }

    public function setItemId($itemId)
    {
        $this->service->setItemId($itemId);
        return $this;
    }

    public function isValid()
    {
        $this->prepareSalt();
        $this->service->setProvidedHash($this->getProvidedNonce());
        return $this->service->isValid();
    }

    public function prepareSalt()
    {
        // When no routename is passed, considered validation process
        // And tries to get it from route match
        $controller = $this->getController();
        if (!$this->service->hasRouteName()) {
            $routeMatch = $controller->getServiceLocator()
                ->get('Application')
                ->getMvcEvent()
                ->getRouteMatch();

            if (null === $routeMatch) {
                throw new \Exception('no route match');
            }
            $this->service->setRouteName($routeMatch->getMatchedRouteName());
        }

        if (!$this->service->hasItemId()) {
            $itemId = $controller->params()->fromRoute('id', null);
            if (null === $itemId) {
                throw new \Exception('Missing route param "id", or not setting it before calling getHash');
            }
            $this->service->setItemId($itemId);
        }

        if (!$this->service->hasUser()) {
            $this->service->setUser($controller->identity());
        }
    }

    /**
     * The hash sent in the get request as nonce param
     */
    public function getProvidedNonce()
    {
        $controller = $this->getController();
        $valueIfNotProvidedNonce = null;
        $nonce = $controller->params()->fromRoute($this->nonceParamName, $valueIfNotProvidedNonce);
        if ($nonce === $valueIfNotProvidedNonce) {
            throw new \Exception('Missing nonce param, using param name:' . $this->nonceParamName);
        }
        return $nonce;
    }

    public function isNonceProvided()
    {
        $valueIfNotProvidedNonce=null;
        return $valueIfNotProvidedNonce !== $this->controller->params()->fromRoute($this->nonceParamName, $valueIfNotProvidedNonce);
    }

    public function getHash()
    {
        return $this->service->getHash();
    }

    public function setNonceParamName($name)
    {
        $this->nonceParamName = $name;
        return $this;
    }
}

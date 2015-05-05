<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace GbiliUserModule\View\Helper;

/**
 * nonce()->setRouteName('my_route_name');
 * foreach (item) {
 *    $nonceHash = nonce()->getHash($item->getId());
 *    $this->url('my_route_name', array('nonce' => $nonceHash), true);
 * }
 */
class Nonce extends \Zend\View\Helper\AbstractHelper
{
    protected $service;

    public function setService(\GbiliUserModule\Service\Nonce $service)
    {
        $this->service = $service;
        return $this;
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

    public function getRouteName()
    {
        return $this->service->getRouteName();
    }

    public function setItemId($itemId)
    {
        $this->service->setItemId($itemId);
        return $this;
    }

    public function getHash($itemId=null)
    {
        if (!$this->service->hasUser()) {
            $this->service->setUser($this->getView()->identity());
        }
        return $this->service->getHash($itemId);
    }
    
    //TODO THE NONCE PARAM NAME SHOULD BE THE SAME AS SET IN CONTROLLER PLUGIN...
}

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
class ScriptPaths extends \Zend\View\Helper\AbstractHelper
{
    public function __invoke($scriptName)
    {
        return $this->getScriptPath($scriptName);
    }

    public function getScriptPath($scriptName)
    {
        $scriptPath = __DIR__ . '/../../../../view/partial/' . $scriptName . '.phtml';
        if (!file_exists($scriptPath)) {
            throw new \Exception('The requested script does not exist');
        }
        return $scriptPath;
    }
}

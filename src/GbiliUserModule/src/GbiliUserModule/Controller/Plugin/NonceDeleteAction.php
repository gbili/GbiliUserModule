<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace GbiliUserModule\Controller\Plugin;

class NonceDeleteAction extends \Zend\Mvc\Controller\Plugin\AbstractPlugin
{
    /**
     * Nonce based delete action
     * @return mixed
     */
    public function __invoke($onFinishRedirectToRoute, $routeParams=array(), $findEntityCallback=null)
    {
        $controller = $this->controller;

        if (!$controller->nonce()->isValid()) {
            $controller->messenger()->addMessage(implode(', ', $controller->nonce()->getLastValidator()->getMessages()), 'danger');
            $routeParams['id'] = null;
            $routeParams['nonce'] = null;
            return $controller->redirect()->toRoute($onFinishRedirectToRoute, $routeParams, true);
        }

        if (null === $findEntityCallback) {
            $entity = $controller->repository()->find($controller->params()->fromRoute('id'));
        } else {
            $entity = call_user_func($findEntityCallback, $controller);
        }

        if (!$entity) {
            $routeParams['id'] = null;
            $routeParams['nonce'] = null;
            return $controller->redirect()->toRoute($onFinishRedirectToRoute, $routeParams, true);
        }

        $loggedInUser = $controller->identity();
        if (!$loggedInUser->isAdmin()) {
            if (($entity instanceof \User\IsOwnedByInterface) && !$entity->isOwnedBy($loggedInUser)) {
                // TODO does this ever happen since nonce is valid?? It would if entities were not trimmed by logged in user during query
                throw new \Exception('Access denied, thing does not belong to you');
            }
        }

        if (!method_exists($controller, 'deleteEntity')) {
            throw new \Exception('Missing controller method removeEntity() in order to use actionNonceDelete plugin');
        }

        $controller->deleteEntity($entity);

        $controller->messenger()->addMessage('Deletion succeed', 'success');

        $routeParams['id'] = null;
        $routeParams['nonce'] = null;

        return $controller->redirect()->toRoute($onFinishRedirectToRoute, $routeParams, true);
    }
}

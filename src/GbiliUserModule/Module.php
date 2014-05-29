<?php
namespace GbiliUserModule;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        $preConfig = include __DIR__ . '/config/module.pre_config.php';
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $em = $e->getApplication()->getEventManager();

        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, function($e) {
            $flashMessenger = new \Zend\Mvc\Controller\Plugin\FlashMessenger();
            if ($flashMessenger->hasSuccessMessages()) {
                $e->getViewModel()->setVariable('successMessages', $flashMessenger->getSuccessMessages());
            }
        });

        $this->injectDoctrineTargetListeners($e);
    }

    public function injectDoctrineTargetListeners($e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $config = $sm->get('Config');
        $doctrineEventListenersConfig = $config['doctrine_event_listeners'];

        $em = $sm->get('doctrine.entitymanager.orm_default');
        $dem = $em->getEventManager();

        $addedEventListenerHashesToPriority = array();

        foreach ($doctrineEventListenersConfig as $eventIdentifier => $eventListeners) {
            foreach ($eventListeners as $eventListenerSet) {
                $listenerClass = $eventListenerSet['listener_class'];
                $listenerMethod = $eventListenerSet['listener_method'];
                foreach ($eventListenerSet['listeners_params'] as $listenerIdentifierPart => $listenerParams) {
                    $listenerHash = md5($eventIdentifier . $listenerClass . $listenerMethod . $listenerIdentifierPart);
                    if (isset($addedEventListenerHashesToPriority[$listenerHash])) {
                        $lastPriority = $addedEventListenerHashesToPriority[$listenerHash];
                        $listenerPriority = (isset($eventListenerSet['priority']))
                            ? $eventListenerSet['priority']
                            : 0;
                        if ($lastPriority >= $listenerPriority) continue;
                    }

                    $listener = new $listenerClass;
                    call_user_func_array(array($listener, $listenerMethod), $listenerParams);
                    // Last added takes priority over the rest
                    $dem->addEventListener($eventIdentifier, $listener);

                    $addedEventListenerHashes[$listenerHash] = (isset($listenerPriority))
                        ? $listenerPriority
                        : 0;
                }
            }
        }
    }
}

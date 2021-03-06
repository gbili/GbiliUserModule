<?php
namespace GbiliUserModule;
return array(
    'invokables' => array(
        'actionNonceDelete' => __NAMESPACE__ . '\Controller\Plugin\NonceDeleteAction',
    ),
    'factories' => array(
        'nonce' => function ($controllerPluginManager) {
            $sm = $controllerPluginManager->getServiceLocator();
            $service = $sm->get('GbiliUserModule\Service\Nonce');
            $plugin = new Controller\Plugin\Nonce;
            $plugin->setService($service);
            return $plugin;
        },
    ),
);

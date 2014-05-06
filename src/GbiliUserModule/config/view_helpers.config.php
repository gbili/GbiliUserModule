<?php
namespace GbiliUserModule;
return array(
    'factories' => array(
        'nonce'        => function ($viewHelperPluginManager) {
            $sm = $viewHelperPluginManager->getServiceLocator();
            $service = $sm->get('GbiliUserModule\Service\Nonce');
            $helper = new View\Helper\Nonce;
            $helper->setService($service);
            return $helper;
        },
    ),
    'invokables' => array(
        'GbiliUserModuleScriptPaths' => __NAMESPACE__ . '\View\Helper\ScriptPaths',
    ),
);

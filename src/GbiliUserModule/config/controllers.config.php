<?php
namespace GbiliUserModule;
return array(
    'invokables' => array(
        'auth' => 'GbiliUserModule\Controller\AuthController',
        'gbiliuser_profile_controller' => 'GbiliUserModule\Controller\ProfileController',
        'admin' => 'GbiliUserModule\Controller\AdminController',
    ),
);

<?php
namesapace GbiliUserModule;
return array(
    'invokables' => array(
        'auth' => 'User\Controller\AuthController',
        'gbiliuser_profile_controller' => 'User\Controller\ProfileController',
        'admin' => 'User\Controller\AdminController',
    ),
);

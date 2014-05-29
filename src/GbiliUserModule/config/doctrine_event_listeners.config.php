<?php
return array(
    \Doctrine\ORM\Events::loadClassMetadata => array(
        array(
            // If some other module registered the same listener to the same event with the same params,
            // should it be overriden by this?
            'priority' => 0,
            // What is the listener class whose method these listeners_params should be passed to
            'listener_class' => '\Doctrine\ORM\Tools\ResolveTargetEntityListener',
            // What specific method will the params be passed to?
            'listener_method' => 'addResolveTargetEntity',
            // Every element is a set of params. Each will be passed to a new listener class instance
            'listeners_params' => array( 
                // the key is the identifier used to create a hash
                // array elements are params
                '\GbiliUserModule\Entity\UserInterface' => array( 
                    '\GbiliUserModule\Entity\UserInterface', 
                    '\GbiliUserModule\Entity\User', 
                    array(),
                ),
                '\GbiliUserModule\Entity\UserDataInterface' => array(
                    '\GbiliUserModule\Entity\UserDataInterface', 
                    '\GbiliUserModule\Entity\UserData', 
                    array(),
                ),
                '\GbiliUserModule\Entity\ProfileInterface' => array(
                    '\GbiliUserModule\Entity\ProfileInterface', 
                    '\GbiliUserModule\Entity\Profile', 
                    array(),
                ),
            ),
        ),
    ),
);

<?php
namesapace GbiliUserModule\Form;

class Login extends \Zend\Form\Form 
{
    public function __construct($name = null)
    {
        parent::__construct('user-login');
        
        //Add the user fieldset, and set it as the base fieldset
        $fieldset = new Fieldset\User($name);
        $fieldset->setUseAsBaseFieldset(false);
        $this->add($fieldset);

        // ... add CSRF and submit elements
        // Optionally set your validation group here

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'id'    => 'submitbutton',
                'class' => 'btn btn-default', 
            ),
        ));
    }
}

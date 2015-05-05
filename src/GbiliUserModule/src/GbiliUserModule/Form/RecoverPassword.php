<?php
namespace GbiliUserModule\Form;

class RecoverPassword extends \Zend\Form\Form 
{
    public function __construct($name = null)
    {
        parent::__construct('user-recoverpassword');
        
        //Add the user fieldset, and set it as the base fieldset
        $fieldset = new Fieldset\RecoverPassword($name);
        $fieldset->setUseAsBaseFieldset(true);
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

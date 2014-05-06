<?php
namesapace GbiliUserModule\Form;

class Uniquename extends \Zend\Form\Form 
{
    public function __construct($name = null)
    {
        parent::__construct('user-login');
        
        //Add the user fieldset, and set it as the base fieldset
        $fieldset = new Fieldset\UserUniquename($name);
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);

        // ... add CSRF and submit elements
        // Optionally set your validation group here

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'TestUniquename',
                'id'    => 'submitbutton',
                'class' => 'btn btn-default', 
            ),
        ));
    }
}

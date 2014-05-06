<?php
namesapace GbiliUserModule\Form;

class ProfileEditor extends \Zend\Form\Form 
{
    public function __construct($sm)
    {
        parent::__construct('user-profile-edit');
        
        //Add the user fieldset, and set it as the base fieldset
        $postFieldset = new Fieldset\Profile($sm);
        $postFieldset->setUseAsBaseFieldset(true);
        $this->add($postFieldset);

        // ... add CSRF and submit elements
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'btn btn-default', 
            ),
        ));
        // Optionally set your validation group here
    }
}

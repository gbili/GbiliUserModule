<?php
namesapace GbiliUserModule\Form;

class Register extends \Zend\Form\Form 
implements \Zend\InputFilter\InputFilterProviderInterface
{
    public function __construct($name = null)
    {
        parent::__construct('user-registration');

        //Add the user fieldset, and set it as the base fieldset
        $userFieldset = new Fieldset\User($name);
        $userFieldset->setUseAsBaseFieldset(false);
        $this->add($userFieldset);

        // ... add CSRF and submit elements
        // Optionally set your validation group here

        $this->add(array(
            'name' => 'password_check',
            'type'  => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Confirm Password'
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Register',
                'id' => 'submitbutton',
                'class' => 'btn btn-default', 
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'password_check' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => array('user' => 'password'),
                            'message' => 'Passwords don\'t match',
                        ),
                    ),
                ),
            ),
        );
    }
}

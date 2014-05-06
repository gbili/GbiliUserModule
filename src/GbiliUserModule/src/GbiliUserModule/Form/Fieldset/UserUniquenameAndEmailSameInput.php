<?php
namesapace GbiliUserModule\Form\Fieldset;

class UserUniquenameAndEmailSameInput extends \Zend\Form\Fieldset 
implements \Zend\InputFilter\InputFilterProviderInterface
{
    public function __construct($name, $options = array())
    {
        parent::__construct('user');

        $this->add(array(
            'name' => 'id',
            'type'  => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'uniquenameoremail',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Username or Email'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Johnny.de-Vito_21 or johnny.devito@email.com',
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type'  => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password'
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ),

            'uniquenameoremail' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Callback',
                        'options' => array(
                            'callback' => function ($value) {
                                $regexForUniquename = '/\\A(?:[A-Za-z0-9]+(?:[-_.]?[A-Za-z0-9]+)*){4,}\\z/';
                                $emailValidator = new \Zend\Validator\EmailAddress();
                                return (0 < preg_match($regexForUniquename, $value) || $emailValidator->isValid($value));
                            },
                            'message' => 'Wrong input, expecting username or email address',
                        ),
                    ),
                ),
            ),

            'password' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 8,
                            'max' => 64,
                            'message' => 'Password must be from 8 to 64 characters long',
                        ),
                    ),
                ),
            ),
        );
    }
}

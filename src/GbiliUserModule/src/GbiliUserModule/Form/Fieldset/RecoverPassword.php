<?php
namespace GbiliUserModule\Form\Fieldset;

class RecoverPassword extends \Zend\Form\Fieldset 
implements \Zend\InputFilter\InputFilterProviderInterface
{
    public function __construct($name, $options = array())
    {
        parent::__construct('user');
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
    }

    public function getInputFilterSpecification()
    {
        return array(
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
        );
    }
}

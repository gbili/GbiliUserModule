<?php
namespace GbiliUserModule\Form\Fieldset;

class UserEmail extends \Zend\Form\Fieldset 
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
            'name' => 'email',
            'type'  => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'Email'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'my.email@mail.com',
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

            'email' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
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

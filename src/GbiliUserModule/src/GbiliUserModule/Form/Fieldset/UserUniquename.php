<?php
namesapace GbiliUserModule\Form\Fieldset;

class UserUniquename extends \Zend\Form\Fieldset 
implements \Zend\InputFilter\InputFilterProviderInterface
{
    public function __construct($name, $options = array())
    {
        parent::__construct('user');

        $this->add(array(
            'name' => 'uniquename',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Username'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Jonny.de-Vito_21',
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'uniquename' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Regex',
                        'options' => array(
                            'pattern' => '/(?:\\A(?:[A-Za-z0-9]+(?:[-_.]?[A-Za-z0-9]+)*){4,}\\z)/',
                            'message' => 'The username can contain A-Z, a-z, 0-9 and these special chars: - _ . (dash, underscore, dot)',
                        ),
                    ),
                ),
            ),
        );
    }
}

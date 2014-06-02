<?php
namespace GbiliUserModule\Form\Fieldset;

class Profile extends \Zend\Form\Fieldset 
implements \Zend\InputFilter\InputFilterProviderInterface
{
    public function __construct($sm)
    {
        parent::__construct('profile');

        $objectManager = $sm->get('Doctrine\ORM\EntityManager');
        $authService   = $sm->get('Zend\Authentication\AuthenticationService');
        $user = $authService->getIdentity();

        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($objectManager, false))
             ->setObject(new \GbiliUserModule\Entity\Profile());
        
        $this->add(array(
            'name' => 'id',
            'type'  => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'firstname',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Name'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'John',
            )
        ));

        $this->add(array(
            'name' => 'surname',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Surname'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'McKenzy',
            )
        ));

        $this->add(array(
            'name' => 'media',
            'type' => 'GbiliDoctrineFormObjectModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Profile Picture',
                'property' => 'slug',
                'attributes' => array(
                    'data-img-src' => 'src',
                ),
                'form_group_class' => 'well',
                'is_method' => true,
                'target_class' => 'GbiliMediaEntityModule\Entity\Media',
                'object_manager' => $objectManager,
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('user' => $user),
                    ),
                ),
                'display_empty_item' => true,
                'empty_item_label' => '---',
            ),
            'attributes' => array(
                'class' => 'image-picker masonry',
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

            'firstname' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            ),

            'surname' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            ),

            'content' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 700,
                        ),
                    ),
                ),
            ),

            'media' => array(
                'required' => false,
            ),
        );
    }
}

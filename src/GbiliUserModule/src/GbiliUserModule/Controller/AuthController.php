<?php
namespace GbiliUserModule\Controller;

use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Zend\View\Model\ViewModel;

class AuthController extends \Zend\Mvc\Controller\AbstractActionController
{
    /**
     * Edit action
     *
     */
    public function loginAction()
    {
        if ($this->identity()) {
            $this->messenger()->addMessage('Woopsy, already logged in', 'warning');
            return $this->logged();
        }

        $form = new \User\Form\LoginUniquenameOrEmail();

        if (!$this->request->isPost()) {
            return new ViewModel(array(
                'form' => $form,
                'messages' => $this->messenger()->getMessages(),
            ));
        }
        $form->setData($this->request->getPost());

        if (!$form->isValid()) {
            return new ViewModel(array(
                'form' => $form,
                'messages' => $this->messenger()->getMessages(),
            ));
        }

        $formData = $form->getData();
        $userEmail = $this->getUserOrEmail($formData);

        if (!$userEmail || !$this->authenticate($userEmail, $formData['user']['password'])) {
            return new ViewModel(array(
                'form' => $form,
                'messages' => array('danger' => 'The credential/password combination does not exist, try something else or register'),
            ));
        }

        $this->messenger()->addMessage('Welcome back!', 'success');
        return $this->logged();
    }

    public function recoverpasswordAction()
    {
        //TODO create a form that allows the user to insert
        // its username or email
        $form = new \User\Form\RecoverPassword();
        if (!$this->request->isPost()) {
            return new \Zend\View\Model\ViewModel(array(
                'form' => $form,
            ));
        }

        $form->setData($this->request->getPost());

        if (!$form->isValid()) {
            return new \Zend\View\Model\ViewModel(array(
                'form' => $form,
            ));
        }

        $formValidData = $form->getData();
        $user = $this->getUserOrEmail($formValidData, $returnEmail=false);

        if (!$user) {
            return new \Zend\View\Model\ViewModel(array(
                'form' => $form,
                'messages' => array(array('danger' => 'No such user')),
            ));
        }

        // Add user to Lost passwords db records
        $remoteAddress   = new \Zend\Http\PhpEnvironement\RemoteAddress();
        $recoverPassword = new \User\Entity\RecoverPassword();
        $recoverPassword->setIpaddress($remoteAddress->getIpAddress());
        $recoverPassword->setUser($user);
        $recoverPassword->setDatecreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $em = $this->em();
        $em->persist($recoverPassword);
        $em->flush();

        // Then send an email to the user's email with a token
        // that will allow to change password
        //
        // Validate the token (nonce?)
        //
        // Create a form that allows to reset passord 
        //
        // Remove toke from db or set as reset.
        //
        // Login user
        //
        // Send email confirmation
    }

    public function getUserOrEmail($dirtyData, $returnEmail=true)
    {
        $uniquenameOrEmail = $dirtyData['user']['uniquenameoremail'];
        $uniquenamePattern = '/(?:\\A(?:[A-Za-z0-9]+(?:[-_.]?[A-Za-z0-9]+)*){4,}\\z)/';
        $uniquenameValidator = new \Zend\Validator\Regex($uniquenamePattern);
        if ($uniquenameValidator->isValid($uniquenameOrEmail)) {
            $users = $this->em()->getRepository('User\Entity\User')->findByUniquename($uniquenameOrEmail);
            if (empty($users)) {
                return false;
            }
            $user = current($users);
            return ($returnEmail)? $user->getEmail() : $user;
        }

        $emailValidator = new \Zend\Validator\EmailAddress();
        if ($emailValidator->isValid($uniquenameOrEmail)) {
            if ($returnEmail) {
                return $uniquenameOrEmail;
            }
            $users = $this->em()->getRepository('User\Entity\User')->findByEmail($uniquenameOrEmail);
            if (empty($users)) {
                return false;
            }
            $user = current($users);
            return $user;
        }
        throw new \Exception('Neither uniquename nor email are valid, this is weird');
    }

    public function logged()
    {
        $params = array('uniquename' => $this->identity()->getUniquename());
        return $this->redirect()->toRoute('profile_private', $params, true);
    }

    public function authenticate($email, $plainPassword)
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authAdapter = $authService->getAdapter();
        $authAdapter->setIdentityValue($email);
        $authAdapter->setCredentialValue($plainPassword);
        $authResult = $authService->authenticate();
        if (!$authResult->isValid()) {
            return false;
        }

        $identity = $authResult->getIdentity();
        $authService->getStorage()->write($identity);
        return true;
    }

    /**
     * Link media to a post 
     */
    public function registerAction()
    {
        if ($this->identity()) {
            return $this->logged();
        }
        $messages = array();

        $form = new \User\Form\Register();

        if (!$this->request->isPost()) {
            return new ViewModel(array(
                'form' => $form,
                'messages' => $messages,
            ));
        }

        $form->setData($this->request->getPost());

        //TODO add filters to the fieldset 
        if (!$form->isValid()) {
            return new ViewModel(array(
                'form' => $form,
                'messages' => $messages,
            ));
        }

        $formData = $form->getData();
        $validatedUserData = $formData['user'];
        $providedEmail = $validatedUserData['email'];
        $providedUniquename = $validatedUserData['uniquename'];
        $providedPassword = $validatedUserData['password'];

        if ($this->isEmailAlreadyInUse($providedEmail)) {
            $this->messenger()->addMessage('A user with this email address is already registered, try to login, or use a different email address', 'danger');
            return new ViewModel(array(
                'form' => $form,
                'messages' => $this->messenger()->getCurrentMessages(),
            ));
        }

        if ($this->isUniquenameAlreadyInUse($providedUniquename)) {
            $this->messenger()->addMessage('This username already exists, try to login, or use a different username', 'danger');
            return new ViewModel(array(
                'form' => $form,
                'messages' => $this->messenger()->getCurrentMessages(),
            ));
        }

        $this->persistUser($validatedUserData);

        if (!$this->authenticate($providedEmail, $providedPassword)) {
            throw new \Exception('Authentication failed');
        }

        $this->messenger()->addMessage('Congratulations! Do you want to tell people what breed of dog you have? You can do that here, in the description. Or you can start searching for dogtore cards.', 'success');
        return $this->logged();
    }

    public function persistUser($validatedUserData)
    {
        $user = new \User\Entity\User();
        $user->hydrate($validatedUserData);
        $user->setRole('user');
        $objectManager = $this->em();
        $objectManager->persist($user);
        $objectManager->flush();
    }

    public function isEmailAlreadyInUse($email)
    {
        $objectManager = $this->em();
        $users = $objectManager->getRepository('User\Entity\User')->findByEmail($email);
        return !empty($users);
    }

    public function isUniquenameAlreadyInUse($uniquename)
    {
        $objectManager = $this->em();
        $users = $objectManager->getRepository('User\Entity\User')->findByUniquename($uniquename);
        return !empty($users);
    }

    /**
     * Link media to a post 
     *
     */
    public function logoutAction()
    {
        if ($this->identity()) {
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $authStorage = $authService->getStorage();
            $authStorage->clear();
        }
        $this->toLogin();
    }

    public function toLogin()
    {
        $reuseMatchedParams = true;
        $this->redirect()->toRoute('auth_login', array(), $reuseMatchedParams);
    }
}

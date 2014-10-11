<?php
namespace GbiliUserModule\Controller;

class ProfileController extends \Zend\Mvc\Controller\AbstractActionController
{
    protected $paramsUniquename;
    protected $paramsUniquenameUser;

    /**
     * Access logged in user profile
     */
    public function privateAction()
    {
        $user = $this->identity();
        $profile = $this->em()->getRepository('GbiliUserModule\Entity\Profile')->findOneByUser($user);
        if (empty($profile)) {
            return $this->redirect()->toRoute('profile_edit', array('uniquename' => $user->getUniquename()), true);
        }
        return $this->displayUserProfile($profile);
    }

    public function publicAction()
    {
        $user = $this->getParamsUniquenameUser();
        $profile = $this->em()->getRepository('GbiliUserModule\Entity\Profile')->findOneByUser($user);
        if (empty($profile)) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        return $this->displayUserProfile($profile);
    }

    protected function displayUserProfile(\GbiliUserModule\Entity\ProfileInterface $profile)
    {
        $user          = $profile->getUser();
        $media         = $profile->getMedia();
        $mediaMetadata = $this->em()->getRepository('GbiliMediaEntityModule\Entity\MediaMetadata')->findOneByMedia($media);
        $messages      = $this->messenger()->getMessages();

        $viewVars = array(
            'profile', 
            'media', 
            'mediaMetadata', 
            'user', 
            'messages',
        );

        return new \Zend\View\Model\ViewModel(compact($viewVars));
    }

    public function getParamsUniquename()
    {
        if (null === $this->paramsUniquename) {
            $this->paramsUniquename = $this->params()->fromRoute('uniquename');
        }
        return $this->paramsUniquename;
    }

    public function issetParamsUniquename()
    {
        return false !== $this->getParamsUniquename();
    }

    public function isParamsUniquenameSameAsLoggedInUser()
    {
        $loggedInUser = $this->identity();
        if (false === $loggedInUser) {
            throw new \Exception('not logged in');
        }
        if (!$this->issetParamsUniquename()) {
            throw new \Exception('no params uniquename');
        }
        return $this->getParamsUniquename() === $loggedInUser->getUniquename();
    }

    public function isParamsUniquenameExistingUser()
    {
        if (null === $this->paramsUniquenameUser) {
            $users = $this->em()->getRepository('GbiliUserModule\Entity\User')->findByUniquename($this->getParamsUniquename());
            if (!empty($users)) {
                 $this->paramsUniquenameUser = current($users);
            }
        }
        return $this->paramsUniquenameUser instanceof \GbiliUserModule\Entity\User;
    }

    public function getParamsUniquenameUser()
    {
        $paramsUniquename = $this->getParamsUniquename();
        if (!$paramsUniquename) {
            throw new \Exception('uniquename route param not set');
        }

        if ($paramsUniquename === $this->identity()->getUniquename()) {
            return $this->paramsUniquenameUser = $this->identity();
        }
        if (!$this->isParamsUniquenameExistingUser()) {
            throw new \Exception('uniquename route param not exist');
        }
        return $this->paramsUniquenameUser;
    }

    /**
     * Show the profile available to friends
     *
     */
    public function friendAction()
    {

    }

    /**
     *
     */
    public function listAction()
    {
        $profiles = $this->em()->getRepository('GbiliUserModule\Entity\Profile')->findAll();

        return new \Zend\View\Model\ViewModel(array(
            'profiles' => $profiles,
        ));
    }

    public function redirectToLoggedInUserProfile()
    {
        return $this->redirect()->toRoute(null, array('uniquename' => $this->identity()->getUniquename()), true);
    }

    /**
     * Create profile 
     */
    public function editAction()
    {
        if (!$this->isParamsUniquenameSameAsLoggedInUser()) {
            return $this->redirectToLoggedInUserProfile();
        }

        $objectManager = $this->em();
        $user          = $this->identity();
        $profile       = $this->em()->getRepository('GbiliUserModule\Entity\Profile')->findOneByUser($user);
        if (empty($profile)) {
            $profile = new \GbiliUserModule\Entity\Profile();
        }

        $profileForm   = new \GbiliUserModule\Form\ProfileEditor($this->getServiceLocator());
        $profileForm->bind($profile);

        if (!$this->request->isPost()) {
            return new \Zend\View\Model\ViewModel(array(
                'entityId' => $profile->getId(),
                'form'     => $profileForm,
                'messages' => $this->messenger()->getMessages(),
            ));
        }

        $httpPostData = $this->request->getPost();
        $profileForm->setData($httpPostData);

        if (!$profileForm->isValid()) {
            return new \Zend\View\Model\ViewModel(array(
                'entityId' => $profile->getId(),
                'form' => $profileForm,
            ));
        }

        $profile->setDate(new \DateTime());
        $profile->setUser($user);
        
        if (!$profile->hasMedia()) {
            $mediaRepo = $this->repository('GbiliMediaEntityModule\Entity\Media');
            if (!$mediaRepo->hasConfig()) {
                $config = $this->sm()->get('Config');
                if (!isset($config['gbilimem']['default_medias_slug'])) {
                    throw new \Exception('Missing gbilimem config');
                }
                $mediaRepo->setConfig($config['gbilimem']['default_medias_slug']);
            }
            $genericMedia = $mediaRepo->getDefaultMedia(get_class($profile));
            $profile->setMedia($genericMedia);
        }

        $objectManager->persist($profile);
        $objectManager->flush();

        return $this->redirect()->toRoute('profile_publicly_available', array('uniquename' => (string) $user->getUniquename()), true);
    }
}

<?php
namespace GbiliUserModule\Controller;

class AdminController extends \Zend\Mvc\Controller\AbstractActionController
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $users = $this->getEntityManager()->getRepository('GbiliUserModule\Entity\User')->findAll();
        return new \Zend\View\Model\ViewModel(array(
            'users' => $users, 
        ));
    }

    /**
     * Create a blog post
     */
    public function editAction()
    {
        $objectManager = $this->getEntityManager();
        $user          = $this->identity();
        $profile       = $this->getProfileByUserId($this->params()->fromRoute('id'));

        $profileForm   = new \User\Form\ProfileEdit($objectManager);
        $profileForm->bind($profile);

        if (!$this->request->isPost()) {
            return new \Zend\View\Model\ViewModel(array(
                'entityId' => $profile->getId(),
                'form' => $profileForm,
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
            $media = $objectManager->getRepository('Blog\Entity\Media')->findBySlug('profile-thumbnail.jpg');
            $profile->setMedia(current($media));
        }

        $objectManager->persist($profile);
        $objectManager->flush();

        return $this->redirect()->toRoute('profile_private', array('id' => (string) $user->getId()));
    }

    public function getProfileByUserId($userId)
    {
        $users = $this->getEntityManager()->getRepository('GbiliUserModule\Entity\User')->findById((integer) $userId);
        if (empty($users)) {
            throw new \Exception("User with id: $userId, does not exist");
        }
        return current($users)->getProfile();
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        $user = $this->getEntityManager()->getRepository('GbiliUserModule\Entity\User')->find($this->params('id'));
        if ($post) {
            $em = $this->getEntityManager();
            $em->remove($user);
            $em->flush();

            $this->flashMessenger()->addSuccessMessage('User Deleted');
        }
        return $this->redirect()->toRoute('admin_index');
    }
}

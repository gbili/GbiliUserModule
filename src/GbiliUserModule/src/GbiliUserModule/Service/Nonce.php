<?php
namespace GbiliUserModule\Service;

class Nonce 
{
    /**
     * The route name identifies the action and is used in salt
     * @var string (the controller plugin uses get matched route name
     * to validate the nonce, so this has to be that matched route name)
     *
     * @var string
     */
    protected $routeName;

    /**
     * Actions can be performed on things. We need the unique thing
     * identifier in order to avoid propagation of the same action
     * over different items.
     *
     * @var string
     */
    protected $itemId;

    /**
     * @var \Zend\Validator\Csrf
     */
    protected $validator;

    /**
     * User that is allowed to perform action
     * @var \GbiliUserModule\PasswordIdInterface
     */
    protected $user;

    /**
     * @var string hash that is presented
     * as a credential. (the actual nonce)
     */
    protected $providedHash;

    /**
     *
     */
    public function isValid()
    {
        return $this->getValidator()->isValid($this->getProvidedHash());
    }

    public function setProvidedHash($hash)
    {
        $this->providedHash = $hash;
        return $this;
    }

    public function getProvidedHash()
    {
        if (null === $this->providedHash) {
            throw new \Exception('Need to setProvidedHash($hash), before calling isValid()');
        }
        return $this->providedHash;
    }

    public function getHash($itemId = null)
    {
        if (null !== $itemId) {
            $this->setItemId($itemId);
        }
        return $this->getValidator()->getHash();
    }

    public function getValidator()
    {
        $this->validator = new \Zend\Validator\Csrf;
        $this->validator->setSalt($this->getSalt());
        return $this->validator;
    }

    public function getLastValidator()
    {
        if (null === $this->validator) {
            throw new \Exception('No validator was set, call getValidator() to be able to call getLastValidator()');
        }
        return $this->validator;
    }

    public function getSalt()
    {
        return $this->getUserUniqueIdentifier() . $this->getActionUniqueIdentifier();
    }

    public function getActionUniqueIdentifier()
    {
        return $this->getRouteName() . $this->getItemId();
    }

    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
        return $this;
    }

    public function hasRouteName()
    {
        return null !== $this->routeName;
    }

    public function getRouteName()
    {
        if (null === $this->routeName) {
            throw new \Exception('Missing routeName');
        }
        return $this->routeName;
    }

    public function setItemId($itemId)
    {
        $this->itemId = (string) $itemId;
        return $this;
    }

    public function getItemId()
    {
        if (null === $this->itemId) {
            throw new \Exception('Missing itemId');
        }
        return $this->itemId;
    }

    public function hasItemId()
    {
        return null !== $this->itemId;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        if (null === $this->user) {
            throw new \Exception('Missing User property');
        }
        return $this->user;
    }

    public function hasUser()
    {
        return null !== $this->user;
    }

    public function getUserUniqueIdentifier()
    {
        return $this->getUser()->getId() . $this->getUserAlnumPassword();
    }

    public function getUserAlnumPassword()
    {
        $matches = array();
        preg_match_all('/(?<alnum>[a-z0-9]+)/', $this->getUser()->getPassword(), $matches);
        return implode('', $matches['alnum']);
    }
}

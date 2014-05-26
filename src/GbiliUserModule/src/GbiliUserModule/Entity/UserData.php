<?php
namespace GbiliUserModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_data")
 * @ORM\Entity
 */
class UserData implements UserDataInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var GbiliUserModule\Entity\User
     *
     * @ORM\OneToOne(targetEntity="User", mappedBy="data")
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Blog\Entity\Post", mappedBy="userdata")
     */
    private $posts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Blog\Entity\Category", mappedBy="userdata")
     */
    private $categories;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Blog\Entity\Media", mappedBy="userdata")
     */
    private $medias;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Dogtore\Entity\Dog", mappedBy="userdata")
     */
    private $dogs;

    /**
     * @ORM\OneToOne(targetEntity="\GbiliUserModule\Entity\ProfileInterface", inversedBy="userdata")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $profile;

    public function __construct()
    {
        $this->posts      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dogs       = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        if (null === $this->user) {
            throw new \Exception('User not set');
        }
        return $this->user;
    }

    public function hasUser()
    {
        return $this->user instanceof UserInterface;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    public function setProfile(ProfileInterface $profile)
    {
        $this->profile = $profile;
    }

    public function getProfile()
    {
        if (null === $this->profile) {
            $this->profile = new Profile(); 
        }
        return $this->profile;
    }

    public function hasProfile()
    {
        return $this->profile instanceof ProfileInterface;
    }

    public function __call($method, $params)
    {
        $allowed = array('Dog', 'Post', 'Category');
        $allowedPlural = array('Dogs',  'Posts', 'Categories');

        $parts = preg_split('/(?=[A-Z])/', $method);
        $uCFirstWhat = array_pop($parts);
        $what = strtolower($uCFirstWhat);

        $isSingle = in_array($uCFirstWhat, $allowed);
        $isPlural = in_array($uCFirstWhat, $allowedPlural);

        if (!$isSingle && !$isPlural) {
            throw new \Exception('Not implemented');
        }

        array_push($parts, (($isSingle)? 'Thing':'Things'));
        $genericMethod = implode('', $parts);

        return call_user_func(array($this, $genericMethod), (($isSingle)? $what . 's' : $what), current($params));
    }

    public function getThing($what)
    {
        return $this->$what;
    }

    public function getThings($what)
    {
        return $this->$what;
    }

    public function hasthings($what)
    {
        return !$this->$what->isEmpty();
    }

    public function addThing($what, $thing)
    {
        $thing->setUser($this);
        $this->$what->add($thing);
    }

    public function addThings($what, \Doctrine\Common\Collections\Collection $things)
    {
        foreach ($things as $thing) {
            $this->addThing($what, $thing);
        }
    }

    public function removeThing($what, $thing)
    {
        $this->$what->removeElement($thing);
        $thing->setUser(null);
    }

    public function removeThings($what, \Doctrine\Common\Collections\Collection $things)
    {
        foreach ($things as $thing) {
            $this->removeThing($what, $thing);
        }
    }

    public function removeAllThings($what)
    {
        $this->removeThings($what, $this->getThings($what));
        return $this;
    }
}

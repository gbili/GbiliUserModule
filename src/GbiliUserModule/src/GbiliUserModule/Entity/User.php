<?php
namesapace GbiliUserModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User 
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="RecoverPassword", mappedBy="user")
     */
    private $recoveredpasswords;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Blog\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Blog\Entity\Category", mappedBy="user")
     */
    private $categories;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Blog\Entity\Media", mappedBy="user")
     */
    private $medias;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Dogtore\Entity\Dog", mappedBy="user")
     */
    private $dogs;

    /**
     * @var string
     *
     * @ORM\Column(name="uniquename", type="string", length=64, nullable=false, unique=true)
     */
    private $uniquename;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false, unique=true)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="Profile", inversedBy="user")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $profile;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64, nullable=false, unique=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=64, nullable=false, unique=false)
     */
    private $role;

    public function __construct()
    {
        $this->posts      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dogs       = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function isAdmin()
    {
        return $this->getRole() === 'admin';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUniquename($uniquename)
    {
        $this->uniquename = $uniquename;
    }

    public function getUniquename()
    {
        return $this->uniquename;
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

    public function setPassword($clearPassword)
    {
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        $this->password = $bcrypt->create($clearPassword);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isThisPassword($unknownClearPassword)
    {
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        return $bcrypt->verify($unknownClearPassword, $this->getPassword());
    }

    public function hydrate($data)
    {
        foreach ($data as $method => $param) {
            if ('id' === $method) continue;
            $method = 'set' . ucfirst($method);
            $this->$method($param);
        }
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

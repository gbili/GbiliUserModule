<?php
namespace GbiliUserModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gbilium__media_datas")
 *
 * @ORM\Entity(repositoryClass="Blog\Entity\Repository\Media")
 */
class MediaData implements 
    \GbiliMediaEntityModule\Entity\MediaDataInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\GbiliMediaEntityModule\Entity\MediaInterface", inversedBy="datas")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $media;

    /**
     * The media is linked to this profile 
     * @ORM\OneToMany(targetEntity="\GbiliUserModule\Entity\ProfileInterface", mappedBy="mediadata", cascade={"persist"})
     */
    private $profiles;

    public function __construct()
    {
        $this->profiles  = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMedia(\GbiliMediaEntityModule\Entity\MediaInterface $media=null)
    {
        $this->media = $media;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function hasMedia()
    {
        return null !== $this->media;
    }

    public function __call($method, $params)
    {
        $allowed = array('Profile');
        $allowedPlural = array('Profiles');

        $parts = preg_split('/(?=[A-Z])/', $method);
        $uCFirstWhat = array_pop($parts);
        $what = strtolower($uCFirstWhat);

        $isSingle = in_array($uCFirstWhat, $allowed);
        $isPlural = in_array($uCFirstWhat, $allowedPlural);

        if (!$isSingle && !$isPlural) {
            throw new \Exception("$uCFirstWhat not implemented.");
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

    public function addThing($what, $thing)
    {
        $thing->setMediaData($this);
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
        $thing->setMediaData(null);
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

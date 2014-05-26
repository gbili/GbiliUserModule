<?php
namespace GbiliUserModule\Entity;

interface FileInterface
{
    public function getId();

    public function setName($name);
    public function getName();

    public function setBasename($basename);
    public function getBasename();

    public function setDirpath($dirpath);
    public function getDirpath();

    public function setUri($uri);
    public function getUri();

    public function setSize($size);
    public function getSize();

    public function setType($type);
    public function getType();

    public function getMedias();
    public function addMedia(Media $media);
    public function addMedias(\Doctrine\Common\Collections\Collection $medias);
    public function unlinkMedias(\Doctrine\Common\Collections\Collection $medias, $newFile=null);
    public function unlinkMedia(Media $media, $newFile=null);

    public function setDate(\DateTime $time);
    public function getDate();

    public function getSrc();

    public function delete();

    public function move($newBasename);
}

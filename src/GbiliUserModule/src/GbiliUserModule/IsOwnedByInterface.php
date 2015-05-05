<?php
namespace GbiliUserModule;

interface IsOwnedByInterface
{
    /**
     * @return boolean
     */
    public function isOwnedBy(Entity\UserInterface $user);
}

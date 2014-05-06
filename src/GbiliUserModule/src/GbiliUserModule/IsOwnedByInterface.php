<?php
namesapace GbiliUserModule;

interface IsOwnedByInterface
{
    /**
     * @return boolean
     */
    public function isOwnedBy(Entity\User $user);
}

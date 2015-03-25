<?php namespace VictoryCms\Core\Providers\Guard;

use Illuminate\Auth\Guard;

/**
 * Class HeroGuard.
 */
class HeroGuard extends Guard
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'hero_login_'.md5(get_class($this));
    }

    /**
     * @return string
     */
    public function getRecallerName()
    {
        return 'hero_remember_'.md5(get_class($this));
    }
}

<?php namespace VictoryCms\Core\Providers\Guard;
use Illuminate\Auth\Guard;

class HeroGuard extends Guard
{
    public function getName()
    {
        return 'hero_login_'.md5(get_class($this));
    }

    public function getRecallerName()
    {
        return 'hero_remember_'.md5(get_class($this));
    }
}
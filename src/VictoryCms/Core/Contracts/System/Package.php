<?php namespace VictoryCms\Core\Contracts\System;

/**
 * Interface Package.
 */
interface Package
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getProvider();

    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @return mixed
     */
    public function getComponents();
}

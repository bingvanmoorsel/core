<?php namespace VictoryCms\Core\Contracts;

/**
 * Interface Package
 * @package VictoryCms\Core\Contracts
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
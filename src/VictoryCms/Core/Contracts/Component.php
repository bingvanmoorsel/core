<?php namespace VictoryCms\Core\Contracts;

/**
 * Interface Component
 * @package VictoryCms\Core\Contracts
 */
interface Component
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @return mixed
     */
    public function getPackage();
}
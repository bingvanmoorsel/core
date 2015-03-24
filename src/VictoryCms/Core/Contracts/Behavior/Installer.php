<?php namespace VictoryCms\Core\Contracts;

/**
 * Interface Installer
 * @package VictoryCms\Core\Contracts
 */
interface Installer
{
    /**
     * @return mixed
     */
    public function install();

    /**
     * @return mixed
     */
    public function update();

    /**
     * @return mixed
     */
    public function destroy();
}
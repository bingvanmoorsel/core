<?php namespace VictoryCms\Core\Contracts;

/**
 * Interface Installer.
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

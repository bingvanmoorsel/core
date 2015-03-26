<?php namespace VictoryCms\Core\Contracts\System\Behavior;

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

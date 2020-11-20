<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 26.02.2018
 * Time: 14:02
 */

use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshAlfaclick;
use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshNotify;

if ($mode == 'alfaclick') {
    try {
        $controller = new ControllerHutkigroshAlfaclick();
        $controller->process();
    } catch (Throwable $e) {
        Logger::getLogger("alfaclick")->error("Exception: ", $e);
    }
    exit;
} elseif ($mode == 'notify') {
    try {
        $controller = new ControllerHutkigroshNotify();
        $controller->process();
    } catch (Throwable $e) {
        Logger::getLogger("callback")->error("Exception:", $e);
    }
    exit;
}
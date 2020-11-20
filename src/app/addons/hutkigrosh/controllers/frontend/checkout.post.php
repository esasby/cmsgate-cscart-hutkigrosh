<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 26.02.2018
 * Time: 14:25
 */


use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshCompletionPage;

if ($mode == 'complete') {
    if (!empty($_REQUEST['order_id'])) {
        $order_info = fn_get_order_info($_REQUEST['order_id']);
        if (strtolower($order_info["payment_method"]["processor"]) == "hutkigrosh") {
            try {
                $controller = new ControllerHutkigroshCompletionPage();
                $completionPanel = $controller->process($_REQUEST['order_id']);
                Tygh::$app['view']->assign('completionPanel', $completionPanel);
            } catch (Throwable $e) {
                Logger::getLogger("complete")->error("Exception:", $e);
            }
        }
    }

}
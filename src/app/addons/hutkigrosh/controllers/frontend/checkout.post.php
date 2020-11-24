<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 26.02.2018
 * Time: 14:25
 */


use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshCompletionPage;
use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshCompletionPageWebpay;

if ($mode == 'complete') {
    if (!empty($_REQUEST['order_id'])) {
        try {
            $order_info = fn_get_order_info($_REQUEST['order_id']);
            $processor = strtolower($order_info["payment_method"]["processor"]);
            if ($processor == "hutkigrosh"
                || ($processor == "hutkigrosh card" && array_key_exists("webpay_status", $_REQUEST)) ) { //или случай нажатия кнопки назад на форме webpay
                $controller = new ControllerHutkigroshCompletionPage();
                $completionPanel = $controller->process($_REQUEST['order_id']);
                Tygh::$app['view']->assign('completionPanel', $completionPanel);
            } elseif ($processor == "hutkigrosh card") {
                $controller = new ControllerHutkigroshCompletionPageWebpay();
                $completionPanel = $controller->process($_REQUEST['order_id']);
                Tygh::$app['view']->assign('completionPanelWebpay', $completionPanel);
            }
        } catch (Throwable $e) {
            Logger::getLogger("complete")->error("Exception:", $e);
        }
    }

}
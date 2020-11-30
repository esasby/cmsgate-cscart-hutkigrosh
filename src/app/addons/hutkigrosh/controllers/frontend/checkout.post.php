<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 26.02.2018
 * Time: 14:25
 */


use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshCompletionPage;
use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshCompletionPageWebpay;
use esas\cmsgate\hutkigrosh\utils\RequestParamsHutkigrosh;
use esas\cmsgate\RegistryHutkigroshCSCart;
use esas\cmsgate\utils\RequestParamsCSCart;

if ($mode == 'complete') {
    $orderId = $_REQUEST[RequestParamsCSCart::ORDER_ID];
    if (!empty($orderId)) {
        try {
            $order_info = fn_get_order_info($orderId);
            $processor = strtolower($order_info["payment_method"]["processor"]);
            if ($processor == RegistryHutkigroshCSCart::PAYMENT_PROCESSOR_NAME_HUTKIGROSH
                || ($processor == RegistryHutkigroshCSCart::PAYMENT_PROCESSOR_NAME_WEBPAY && array_key_exists(RequestParamsHutkigrosh::WEBPAY_STATUS, $_REQUEST)) ) { //или случай нажатия кнопки назад на форме webpay
                $controller = new ControllerHutkigroshCompletionPage();
                $completionPanel = $controller->process($orderId);
                Tygh::$app['view']->assign('completionPanel', $completionPanel);
            } elseif ($processor == "hutkigrosh card") {
                $controller = new ControllerHutkigroshCompletionPageWebpay();
                $completionPanel = $controller->process($orderId);
                Tygh::$app['view']->assign('completionPanelWebpay', $completionPanel);
            }
        } catch (Throwable $e) {
            Logger::getLogger("complete")->error("Exception:", $e);
        }
    }

}
<?php

use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshAddBill;
use esas\cmsgate\Registry;
use esas\cmsgate\wrappers\OrderWrapperCSCart;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}
if ($mode == 'place_order') {
    try {
        $orderWrapper = new OrderWrapperCSCart($order_info);
        $controller = new ControllerHutkigroshAddBill();
        $resp = $controller->process($orderWrapper);
        // в массив $pp_response помещаются данные для дальнейшей обработки ядром
        $pp_response['order_status'] = Registry::getRegistry()->getConfigWrapper()->getBillStatusPending();
        $pp_response['transaction_id'] = $resp->getBillId();
    } catch (Throwable $e) {
        $pp_response['order_status'] = Registry::getRegistry()->getConfigWrapper()->getBillStatusFailed();
        $pp_response["reason_text"] = $e->getMessage();
    }
}


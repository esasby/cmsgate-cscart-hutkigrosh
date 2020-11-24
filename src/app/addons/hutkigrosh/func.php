<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.03.2018
 * Time: 12:55
 */
require_once(dirname(__FILE__) . '/init.php');

use esas\cmsgate\cscart\CSCartInstallHelper;
use esas\cmsgate\cscart\CSCartPaymentMethod;
use esas\cmsgate\cscart\CSCartPaymentProcessor;
use esas\cmsgate\hutkigrosh\ConfigFieldsHutkigrosh;
use esas\cmsgate\Registry;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}
function fn_hutkigrosh_install()
{
    CSCartInstallHelper::uninstallDb();
    $mainProcessor = new CSCartPaymentProcessor(); //using defaults
    $mainProcessor->setTemplate('views/orders/components/payments/cc_outside.tpl');
    $mainPaymentMethod = new CSCartPaymentMethod();
    $mainPaymentMethod->setLogo('esasby_hutkigrosh.png');
    $mainPaymentMethod->setProcessor($mainProcessor);
    CSCartInstallHelper::addPaymentMethod($mainPaymentMethod);


    $webpayProcessor = new CSCartPaymentProcessor(); //using defaults
    $webpayProcessor->setProcessorName('Hutkigrosh Card');
    $webpayProcessor->setTemplate('views/orders/components/payments/cc_outside.tpl');
    $webpayProcessor->setAdminTemplate('');
    $webpayPaymentMethod = new CSCartPaymentMethod();
    $webpayPaymentMethod->setLogo('esasby_webpay.png');
    $webpayPaymentMethod->setProcessor($webpayProcessor);
    $webpayPaymentMethod->setName(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsHutkigrosh::paymentMethodNameWebpay()));
    $webpayPaymentMethod->setDescription(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsHutkigrosh::paymentMethodDetailsWebpay()));
    CSCartInstallHelper::addPaymentMethod($webpayPaymentMethod);
}

function fn_hutkigrosh_uninstall(){
    CSCartInstallHelper::uninstallDb();
}

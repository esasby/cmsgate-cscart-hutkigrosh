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
    $mainProcessor = new CSCartPaymentProcessor();
    $mainProcessor->initDefaults();;
    $mainProcessor->setTemplate('views/orders/components/payments/cc_outside.tpl');
    $mainPaymentMethod = new CSCartPaymentMethod();
    $mainPaymentMethod->initDefaults();;
    $mainPaymentMethod->setLogo('esasby_hutkigrosh.png');
    $mainPaymentMethod->setProcessor($mainProcessor);
    CSCartInstallHelper::addPaymentMethod($mainPaymentMethod);


    $webpayProcessor = new CSCartPaymentProcessor();
    $webpayProcessor->initDefaults();;
    $webpayProcessor->setProcessorName('Hutkigrosh Card');
    $webpayProcessor->setTemplate('views/orders/components/payments/cc_outside.tpl');
    $webpayProcessor->setAdminTemplate('hutkigrosh_webpay.tpl');
    $webpayPaymentMethod = new CSCartPaymentMethod();
    $webpayPaymentMethod->initDefaults();
    $webpayPaymentMethod->setLogo('esasby_webpay.png');
    $webpayPaymentMethod->setProcessor($webpayProcessor);
    $webpayPaymentMethod->setName(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsHutkigrosh::paymentMethodNameWebpay()));
    $webpayPaymentMethod->setDescription(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsHutkigrosh::paymentMethodDetailsWebpay()));
    CSCartInstallHelper::addPaymentMethod($webpayPaymentMethod);
}

function fn_hutkigrosh_uninstall(){
    CSCartInstallHelper::uninstallDb();
}

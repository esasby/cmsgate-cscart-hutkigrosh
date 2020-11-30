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
use esas\cmsgate\RegistryHutkigroshCSCart;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}
function fn_hutkigrosh_install()
{
    CSCartInstallHelper::uninstallDb();
    $mainProcessor = new CSCartPaymentProcessor();
    $mainProcessor->initDefaults();;
    $mainProcessor->setProcessorName(RegistryHutkigroshCSCart::PAYMENT_PROCESSOR_NAME_HUTKIGROSH);
    $mainProcessor->setTemplate('views/orders/components/payments/cc_outside.tpl');
    $mainPaymentMethod = new CSCartPaymentMethod();
    $mainPaymentMethod->initDefaults();;
    $mainPaymentMethod->setLogo('hutkigrosh.png');
    $mainPaymentMethod->setProcessor($mainProcessor);
    CSCartInstallHelper::addPaymentMethod($mainPaymentMethod);


    $webpayProcessor = new CSCartPaymentProcessor();
    $webpayProcessor->initDefaults();;
    $webpayProcessor->setProcessorName(RegistryHutkigroshCSCart::PAYMENT_PROCESSOR_NAME_WEBPAY);
    $webpayProcessor->setTemplate('views/orders/components/payments/cc_outside.tpl');
    $webpayProcessor->setAdminTemplate('hutkigrosh_webpay.tpl');
    $webpayPaymentMethod = new CSCartPaymentMethod();
    $webpayPaymentMethod->initDefaults();
    $webpayPaymentMethod->setLogo('hutkigrosh_webpay.png');
    $webpayPaymentMethod->setProcessor($webpayProcessor);
    $webpayPaymentMethod->setName(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsHutkigrosh::paymentMethodNameWebpay()));
    $webpayPaymentMethod->setDescription(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsHutkigrosh::paymentMethodDetailsWebpay()));
    CSCartInstallHelper::addPaymentMethod($webpayPaymentMethod);
}

function fn_hutkigrosh_uninstall(){
    CSCartInstallHelper::uninstallDb();
}

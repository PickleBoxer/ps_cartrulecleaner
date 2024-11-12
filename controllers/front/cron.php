<?php
/**
 * 2007-2024 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2024 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_cartrulecleanerCronModuleFrontController extends ModuleFrontController
{
    /** @var bool If set to true, will be redirected to authentication page */
    public $auth = false;

    /** @var bool */
    public $ajax;

    public function display()
    {
        $this->ajax = 1;

        if (!Tools::isPHPCLI()) {
            $this->ajaxRender('Forbidden call.');

            return;
        }

        // Additional token checks
        global $argv;
        $token = isset($argv[1]) ? $argv[1] : null;
        if ($token !== Ps_cartrulecleaner::getToken()) {
            $this->ajaxRender('Invalid token.');

            return;
        }
        // ...

        $this->ajaxRender("hello\nToken: " . $token . "\n");

        // Get all expired cart rules and cart rules with quantity exactly 0
        $expiredCartRules = Db::getInstance()->executeS('
            SELECT id_cart_rule
            FROM ' . _DB_PREFIX_ . 'cart_rule
            WHERE date_to < NOW() OR quantity = 0
        ');

        // Count the number of expired cart rules
        $expiredCartRulesCount = count($expiredCartRules);

        // Display the count
        $this->ajaxRender('Number of expired cart rules: ' . $expiredCartRulesCount . "\n");

        // Delete expired cart rules using CartRule class
        foreach ($expiredCartRules as $cartRule) {
            $cartRuleObj = new CartRule($cartRule['id_cart_rule']);
            $cartRuleObj->delete();
        }

        $this->ajaxRender("Expired cart rules have been deleted.\n");
    }
}

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

class Ps_cartrulecleaner extends Module
{
    protected bool $config_form = false;

    public function __construct()
    {
        $this->name = 'ps_cartrulecleaner';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Pickleboxer';
        $this->need_instance = 0;

        /*
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Cart Rule Cleaner');
        $this->description = $this->l('Cleans expired cart rules.');

        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install(): bool
    {
        if (!parent::install()) {
            return false;
        }

        // Generate and save token
        $token = Tools::passwdGen(32);
        Configuration::updateValue('PS_CARTRULECLEANER_TOKEN', $token);

        return true;
    }

    public function uninstall()
    {
        // Remove token from configuration
        Configuration::deleteByName('PS_CARTRULECLEANER_TOKEN');

        return parent::uninstall();
    }

    public static function getToken(): string
    {
        $token = Configuration::get('PS_CARTRULECLEANER_TOKEN');

        return $token !== false ? $token : '';
    }

    /**
     * Load the configuration form
     */
    public function getContent(): string
    {
        if ($this->context->smarty === null) {
            return '';
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        // Get the token and generate the cron command
        $token = self::getToken();
        $cronCommand = 'php ' . _PS_MODULE_DIR_ . 'ps_cartrulecleaner/cron.php ' . $token;
        $this->context->smarty->assign('cron_command', $cronCommand);

        $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');

        return $output;
    }
}

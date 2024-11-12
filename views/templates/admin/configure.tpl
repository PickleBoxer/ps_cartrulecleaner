{*
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
*}

<div class="panel">
	<div class="row moduleconfig-header">
		<div class="col-xs-5 text-right">
			<img src="{$module_dir|escape:'html':'UTF-8'}views/img/logo.jpg" />
		</div>
		<div class="col-xs-7 text-left">
			<h2>{l s='Cart Rule Cleaner' mod='ps_cartrulecleaner'}</h2>
			<h4>{l s='Cleans expired cart rules from your store.' mod='ps_cartrulecleaner'}</h4>
		</div>
	</div>

	<hr />

	<div class="moduleconfig-content">
		<div class="row">
			<div class="col-xs-12">
				<p>
					<h4>{l s='Module Description' mod='ps_cartrulecleaner'}</h4>
					<p>{l s='This module helps you clean expired cart rules from your PrestaShop store automatically. To use this module, you need to set up a cron job with the command provided below.' mod='ps_cartrulecleaner'}</p>
				</p>

				<br />

				<p class="text-center">
					<strong>
						{l s='Cron Command' mod='ps_cartrulecleaner'}
					</strong>
				<pre>{$cron_command|escape:'html':'UTF-8'}</pre>
				</p>
			</div>
		</div>
	</div>
</div>
<?php /* Smarty version 2.6.18, created on 2011-07-30 18:48:12
         compiled from /var/www/adServe/www/admin/plugins/oxMarket/templates/market-cpm-callout.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', '/var/www/adServe/www/admin/plugins/oxMarket/templates/market-cpm-callout.html', 31, false),)), $this); ?>
<span class="link" help="help-market-cpm"><span class="icon icon-info">&nbsp;</span></span>
<div class="hide" id="help-market-cpm" style="height: auto; width: 270px;">
    <p>
        <?php echo OA_Admin_Template::_function_t(array('str' => "The minimum CPM you provide here will be the floor price %s uses for all your existing remnant campaigns.",'values' => $this->_tpl_vars['elem']['vars']['aBranding']['name']), $this);?>

        <?php echo OA_Admin_Template::_function_t(array('str' => "If the highest bid from %s exceeds your floor price, %s will serve the ad and pay you the higher revenue.",'values' => ($this->_tpl_vars['elem']['vars']['aBranding']['name'])."|".($this->_tpl_vars['elem']['vars']['aBranding']['name'])), $this);?>

        <?php echo OA_Admin_Template::_function_t(array('str' => "Otherwise, your campaign's existing ad will be delivered."), $this);?>

    </p>
    <p>
        <?php echo OA_Admin_Template::_function_t(array('str' => "We recommend that you specify a CPM that represents the effective CPM that you expect to get from your remnant campaigns."), $this);?>

    </p>
</div>
    

<?php /* Smarty version 2.6.18, created on 2011-07-30 18:48:12
         compiled from /var/www/adServe/www/admin/plugins/oxMarket/templates/market-callout.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', '/var/www/adServe/www/admin/plugins/oxMarket/templates/market-callout.html', 30, false),)), $this); ?>
<span class="link" help="help-market-info"><span class="icon icon-info">&nbsp;</span></span>
<div class="hide" id="help-market-info" style="height: auto; width: 270px;">
    <p><b><?php echo OA_Admin_Template::_function_t(array('str' => "Earn more money with %s",'values' => $this->_tpl_vars['elem']['vars']['aBranding']['name']), $this);?>
</b></p>
    <p>
      <?php echo OA_Admin_Template::_function_t(array('str' => "<a target='_blank' href='%s'>%s</a>",'values' => ($this->_tpl_vars['elem']['vars']['aBranding']['links']['info'])."|".($this->_tpl_vars['elem']['vars']['aBranding']['name'])), $this);?>
 
      <?php echo OA_Admin_Template::_function_t(array('str' => "enables advertisers to bid competitively to show their ads on your site."), $this);?>

      <?php echo OA_Admin_Template::_function_t(array('str' => "If the highest bidder exceeds your specified CPM, %s will serve the ad and pay you the higher revenue. Otherwise, your campaign's existing ad will be delivered.",'values' => $this->_tpl_vars['elem']['vars']['aBranding']['name']), $this);?>

    </p>
    <p>
        <?php echo OA_Admin_Template::_function_t(array('str' => "We recommend that you specify a CPM that represents the effective CPM that you expect to get from your campaign."), $this);?>

    </p>
    <p><i><?php echo OA_Admin_Template::_function_t(array('str' => "Note that zones using the Image Tag type will not support %s.",'values' => $this->_tpl_vars['elem']['vars']['aBranding']['name']), $this);?>
</i></p>
</div>


    

    

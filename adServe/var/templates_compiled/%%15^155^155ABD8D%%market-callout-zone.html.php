<?php /* Smarty version 2.6.18, created on 2011-07-30 18:51:41
         compiled from /var/www/adServe/www/admin/plugins/oxMarket/templates/market-callout-zone.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', '/var/www/adServe/www/admin/plugins/oxMarket/templates/market-callout-zone.html', 31, false),)), $this); ?>
<span class="link" help="help-market-info"><span class="icon icon-info">&nbsp;</span></span>
<div class="hide" id="help-market-info" style="height: auto; width: 270px;">
    <p>
    <?php echo OA_Admin_Template::_function_t(array('str' => "%s is a free service that places ads on your site.",'values' => $this->_tpl_vars['elem']['vars']['aBranding']['name']), $this);?>

    <?php echo OA_Admin_Template::_function_t(array('str' => "For standard <a href='%s' target='_blank'>IAB sized</a> Banner, Button or Rectangle zones, you can earn more by letting %s serve ads when there are no ads available to the zone.",'values' => ($this->_tpl_vars['elem']['vars']['adSizesPreviewUrl'])."|".($this->_tpl_vars['elem']['vars']['aBranding']['name'])), $this);?>

    <?php echo OA_Admin_Template::_function_t(array('str' => "To learn more, visit the <a href='%s' target='_blank'>%s FAQ</a>.",'values' => ($this->_tpl_vars['elem']['vars']['aBranding']['links']['faq'])."|".($this->_tpl_vars['elem']['vars']['aBranding']['name'])), $this);?>
    
</div>


    

    

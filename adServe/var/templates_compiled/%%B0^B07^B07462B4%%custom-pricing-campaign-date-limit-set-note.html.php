<?php /* Smarty version 2.6.18, created on 2011-07-30 18:48:12
         compiled from /var/www/adServe/lib/templates/admin/form/custom-pricing-campaign-date-limit-set-note.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', '/var/www/adServe/lib/templates/admin/form/custom-pricing-campaign-date-limit-set-note.html', 29, false),)), $this); ?>

<span class="link" help="help-limits-disabled-<?php echo $this->_tpl_vars['elem']['vars']['type']; ?>
"><span class="icon icon-info"><?php echo OA_Admin_Template::_function_t(array('str' => 'WhyDisabled'), $this);?>
</span></span>
<div class="hide" id="help-limits-disabled-<?php echo $this->_tpl_vars['elem']['vars']['type']; ?>
" style="height: auto; width: 290px;">
    <?php echo OA_Admin_Template::_function_t(array('str' => 'CannotSetBothDateAndLimit'), $this);?>

</div>
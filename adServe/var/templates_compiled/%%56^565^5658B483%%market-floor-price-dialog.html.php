<?php /* Smarty version 2.6.18, created on 2011-07-30 18:48:12
         compiled from /var/www/adServe/www/admin/plugins/oxMarket/templates/market-floor-price-dialog.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', '/var/www/adServe/www/admin/plugins/oxMarket/templates/market-floor-price-dialog.html', 31, false),array('function', 'tabindex', '/var/www/adServe/www/admin/plugins/oxMarket/templates/market-floor-price-dialog.html', 41, false),array('modifier', 'escape', '/var/www/adServe/www/admin/plugins/oxMarket/templates/market-floor-price-dialog.html', 55, false),)), $this); ?>
<div id="market-floor-price-dialog" class="jqmWindow" style="top: auto">
  <div class="jqm-window-title">&nbsp;&nbsp;&nbsp;<?php echo OA_Admin_Template::_function_t(array('str' => 'Your floor price may be too low'), $this);?>
</div>

  <div class="jqm-window-body">
    <div style="line-height: 1.8">
        <?php echo OA_Admin_Template::_function_t(array('str' => "To maximize revenue, we recommend against setting your campaign floor price lower than your campaign's CPM/eCPM."), $this);?>
<br /> 
        <?php echo OA_Admin_Template::_function_t(array('str' => "Would you like to keep the floor price you entered?"), $this);?>

    </div>

    <div class="jqm-controls">
      <input id="market-keep-entered" type="button" value='<?php echo OA_Admin_Template::_function_t(array('str' => "Yes, keep the floor price I entered"), $this);?>
'
             class="main-submit" style="*width: auto; *overflow: visible; *padding: 2px 4px" <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
 />&nbsp;
      <input id="market-change-to-cpm" type="button" value='<?php echo OA_Admin_Template::_function_t(array('str' => "No, change to campaign&#039;s CPM/eCPM"), $this);?>
' <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
 
             style="*width: auto; *overflow: visible; *padding: 2px 4px" /><br />
      <div style="text-align: right; margin-top: 20px">
        <label><input id="dont-show-again" class="checkbox" type="checkbox" /> <?php echo OA_Admin_Template::_function_t(array('str' => 'Do not show this message again during my session'), $this);?>
</label>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
<?php echo '
//<!--
$(document).ready(function () {
  $("#market-floor-price-dialog").confirmFloorPriceDialog(\''; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['cookiePath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['vars']['cookiePath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo '\');
});
//-->
'; ?>

</script>
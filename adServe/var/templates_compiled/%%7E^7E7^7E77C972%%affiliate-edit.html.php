<?php /* Smarty version 2.6.18, created on 2011-07-30 18:51:18
         compiled from affiliate-edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'affiliate-edit.html', 29, false),)), $this); ?>
<?php if ($this->_tpl_vars['error'] != ''): ?>
    <div class='errormessage' id='errors'>
        <img class='errormessage' src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/errormessage.gif' align='absmiddle' />
        <span class='tab-r'>The following errors were found:</span><br />
        <?php echo $this->_tpl_vars['error']; ?>

    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['notice'] != ''): ?>
    <div class='errormessage' id='errors'>
        <span class='tab-r-warning'>Warning:</span><br />
        <?php echo $this->_tpl_vars['notice']; ?>

    </div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/form.html", 'smarty_include_vars' => array('form' => $this->_tpl_vars['form'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script language="javascript">
<!--<?php echo '
    $(document).ready(function() {
        formStateStore($("#affiliateform").get(0));
        $("#affiliateform").submit(function() {
            if (max_formValidate(this)) {
              if(formStateChanged(this)) {
                $("#captcha-dialog-" + this.id).jqmShow();
              }
              else {
                return true;
              }
            }
            return false;
          });
        });
    '; ?>

    <?php echo '    
		$websiteURL = $("#website");
		$websiteName = $("#name");
		$websiteName.focus(function () {
			if ($.trim($websiteName.val()) == "") {
			   val = $websiteURL.val();
			   val = val.replace(/^http[s]?:\\/\\//, "");
			   $websiteName.val(val);
			}
		});
     '; ?>

    //-->
</script>

<?php /* Smarty version 2.6.18, created on 2011-08-21 20:35:37
         compiled from market-campaign-edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'market-campaign-edit.html', 35, false),array('modifier', 'cat', 'market-campaign-edit.html', 54, false),array('modifier', 'escape', 'market-campaign-edit.html', 69, false),)), $this); ?>
<div class="market-campaign-edit">
  <?php if ($this->_tpl_vars['right']): ?>
    <?php echo $this->_tpl_vars['right']; ?>

  <?php else: ?>
    <div class="info-box">
      <h3><?php echo OA_Admin_Template::_function_t(array('str' => 'How it works'), $this);?>
</h3>
      <p>
      <?php echo OA_Admin_Template::_function_t(array('str' => "Your campaign will get its ads from %s, which holds real-time auctions for each impression.",'values' => $this->_tpl_vars['aBranding']['name']), $this);?>

      </p>
      <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-auction-vertical.gif" />
      <br />
      <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-adnetworks-vertical.gif" />
      <br />
    </div>
  <?php endif; ?>
      
  <div class="market-campaign-edit-top">
    <?php if ($this->_tpl_vars['top']): ?>
      <?php echo $this->_tpl_vars['top']; ?>

    <?php else: ?>
    <?php if ($this->_tpl_vars['isNew']): ?><h3><?php echo OA_Admin_Template::_function_t(array('str' => "Add a campaign to get ads directly from %s",'values' => $this->_tpl_vars['aBranding']['name']), $this);?>
</h3><?php endif; ?>
    <?php endif; ?>
  </div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=$this->_tpl_vars['oaTemplateDir'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'form/general-errors.html') : smarty_modifier_cat($_tmp, 'form/general-errors.html')), 'smarty_include_vars' => array('errors' => $this->_tpl_vars['campaignErrors'],'title' => 'ErrorEditingCampaign','text' => 'UnableToChangeCampaign')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=$this->_tpl_vars['oaTemplateDir'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'form/form.html') : smarty_modifier_cat($_tmp, 'form/form.html')), 'smarty_include_vars' => array('form' => $this->_tpl_vars['form'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <div class="market-campaign-edit-bottom">
    <?php if ($this->_tpl_vars['bottom']): ?>
      <?php echo $this->_tpl_vars['bottom']; ?>

    <?php endif; ?>
  </div>
</div>

<script language='javascript' type='text/javascript' src='<?php echo $this->_tpl_vars['assetPath']; ?>
/js/datecheck.js'></script>
<script language='javascript' type='text/javascript' src='<?php echo $this->_tpl_vars['adminWebPath']; ?>
numberFormat.js.php?lang=<?php echo $this->_tpl_vars['language']; ?>
'></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['adminPluginWebPath']; ?>
/oxMarket/js/ox.market.js?v=<?php echo ((is_array($_tmp=$this->_tpl_vars['pluginVersion'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" ></script>
<script type="text/javascript">
<!--
<?php echo '
//<!--
  $(document).ready(function() {
      $("#marketcampaignform").campaignContractMarket({
'; ?>
      
        impressions_delivered : <?php echo $this->_tpl_vars['impressionsDelivered']; ?>
,
        calendarBeginOfWeek : <?php echo $this->_tpl_vars['calendarBeginOfWeek']; ?>
,
<?php echo '
        strings : {
'; ?>
        
            strCampaignWarningNoTargetMessage : '<?php echo $this->_tpl_vars['strCampaignWarningNoTargetMessage']; ?>
'
<?php echo '            
        }        
      });
  });
//-->
'; ?>

//-->
</script>

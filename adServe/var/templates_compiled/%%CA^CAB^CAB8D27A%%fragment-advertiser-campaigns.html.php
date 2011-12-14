<?php /* Smarty version 2.6.18, created on 2011-08-21 20:35:33
         compiled from fragment-advertiser-campaigns.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'fragment-advertiser-campaigns.html', 36, false),)), $this); ?>

<?php if ($this->_tpl_vars['before']): ?>
<div class="market-advertiser-campaigns market-advertiser-campaigns-top">
  <?php if ($this->_tpl_vars['content']): ?>
      <?php echo $this->_tpl_vars['content']; ?>

  <?php else: ?>
  <h3><?php echo OA_Admin_Template::_function_t(array('str' => "Campaigns added here will get ads directly from %s",'values' => $this->_tpl_vars['aBranding']['name']), $this);?>
 <span class="link" help="help-market-campaigns"><span class="icon icon-info">&nbsp;</span></span></h3>

  <div class="hide" id="help-market-campaigns" style="height: auto; width: 355px;">
    <div class="campaigns-info-container">
      <h4><?php echo OA_Admin_Template::_function_t(array('str' => "Adding campaigns for the %s Advertiser",'values' => $this->_tpl_vars['aBranding']['name']), $this);?>
</h4>                                                                                               
      <p>                                                                                                                                               
          <?php echo OA_Admin_Template::_function_t(array('str' => "When you add a campaign under the %s Advertiser, your campaign will get ads from %s, which holds real-time auctions for each impression. The campaign will have similar properties to a contract campaign but the ads will automatically be delivered by %s.",'values' => ($this->_tpl_vars['aBranding']['name'])."|".($this->_tpl_vars['aBranding']['name'])."|".($this->_tpl_vars['aBranding']['name'])), $this);?>

      </p>
      <div class="imageContainer">
        <div class="left">
            <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-auction.gif" alt='<?php echo $this->_tpl_vars['aBranding']['name']; ?>
 Auction' title='<?php echo $this->_tpl_vars['aBranding']['name']; ?>
 Auction'/>
        </div>
        <div class="right">
          <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-adnetworks-horizontal.gif" alt='<?php echo $this->_tpl_vars['aBranding']['name']; ?>
 Advertisers' title='<?php echo $this->_tpl_vars['aBranding']['name']; ?>
 Advertisers'/>
        </div>              
      </div>
      <p><?php echo OA_Admin_Template::_function_t(array('str' => "For more information, visit our FAQ on <a href='%s' target='_blank'>how to make money with %s</a>.",'values' => ($this->_tpl_vars['aBranding']['links']['faq_make_money'])."|".($this->_tpl_vars['aBranding']['name'])), $this);?>
</p>
    </div>
  </div>  
  <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['after']): ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['adminPluginWebPath']; ?>
/oxMarket/js/ox.market.js" ></script>
<script type="text/javascript">
<?php echo '
 <!--
  $(document).ready(function() {
    $(\'.market-advertiser-campaigns\').advertiserCampaigns({
       showInfo: true
    });            
  });
 //-->
'; ?>

</script><?php endif; ?>


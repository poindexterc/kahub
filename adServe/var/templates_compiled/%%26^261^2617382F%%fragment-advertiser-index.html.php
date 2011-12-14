<?php /* Smarty version 2.6.18, created on 2011-07-30 18:47:35
         compiled from fragment-advertiser-index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'fragment-advertiser-index.html', 34, false),)), $this); ?>
  <?php if ($this->_tpl_vars['content']): ?>
      <?php echo $this->_tpl_vars['content']; ?>

  <?php else: ?>
  
    <a href="#" id="three-ways-link" class="inlineIcon icon icon-info"><b><?php echo OA_Admin_Template::_function_t(array('str' => 'more info'), $this);?>
</b></a>
    
    <div id="market-advertiser-index" class="hide">
      <div id="market-callout" class="popup-help">
        <div class="close"> <span class="link"><?php echo OA_Admin_Template::_function_t(array('str' => 'Close'), $this);?>
 [x]</span></div>      
          <h3><?php echo OA_Admin_Template::_function_t(array('str' => "New! %s gives you more ways to make money",'values' => $this->_tpl_vars['aBranding']['name']), $this);?>
</h3>
          <p>
          <?php echo OA_Admin_Template::_function_t(array('str' => "%s provides ads for your sites through a real-time auction of various ad buyers",'values' => $this->_tpl_vars['aBranding']['name']), $this);?>

          </p>
          <p class="market-advertisers">
            <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-adnetworks-horizontal-wide.gif" alt='<?php echo $this->_tpl_vars['aBranding']['name']; ?>
 Advertisers' title='<?php echo $this->_tpl_vars['aBranding']['name']; ?>
 Advertisers'/>
          </p>
        <div class="three-ways-container">
          <p><?php echo OA_Admin_Template::_function_t(array('str' => "There are three ways to participate in %s",'values' => $this->_tpl_vars['aBranding']['name']), $this);?>
</p>
          <ul>
            <li><a href="<?php echo $this->_tpl_vars['adminWebPath']; ?>
campaign-edit.php?clientid=<?php echo $this->_tpl_vars['marketClientId']; ?>
">
              <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-3-ways-campaign-optin.gif" alt='Create an <?php echo $this->_tpl_vars['aBranding']['name']; ?>
 campaign'/></a>
            </li>
            <li><a href="<?php echo $this->_tpl_vars['adminPluginWebPath']; ?>
/oxMarket/market-campaigns-settings.php">
              <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-3-ways-campaign-quickstart.gif" alt='Opt in an existing campaign'/></a>
            </li>
            <li><a href="affiliate-zones.php">
              <img src="<?php echo $this->_tpl_vars['aBranding']['assetPath']; ?>
/market-3-ways-zone-optin.gif" alt='Allow your zones to default to <?php echo $this->_tpl_vars['aBranding']['name']; ?>
'/></a>
            </li>
        </div>
        <p><?php echo OA_Admin_Template::_function_t(array('str' => "For more information, visit our FAQ on <a href='%s' target='_blank'>how to make money with %s",'values' => ($this->_tpl_vars['aBranding']['links']['faq_make_money'])."|".($this->_tpl_vars['aBranding']['name'])), $this);?>
</a>.</p>
      </div>
    </div>
  <?php endif; ?>

<script type="text/javascript" src="<?php echo $this->_tpl_vars['adminPluginWebPath']; ?>
/oxMarket/js/ox.market.js" ></script>
<script type="text/javascript">
<?php echo '
 <!--
  $(document).ready(function() {
    $(\'#market-advertiser-index\').advertiserIndex({
'; ?>

       showInfo: <?php if ($this->_tpl_vars['showMarketInfo']): ?>true<?php else: ?>false<?php endif; ?>
<?php echo '
    });            
  });
 //-->
'; ?>

</script>


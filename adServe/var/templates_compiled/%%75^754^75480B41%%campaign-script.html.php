<?php /* Smarty version 2.6.18, created on 2011-07-30 18:48:12
         compiled from /var/www/adServe/www/admin/plugins/oxMarket/templates/campaign-script.html */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['pluginWebPath']; ?>
/js/ox.market.js" ></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['adminPluginWebPath']; ?>
/oxMarket/js/jquery.cookie.js" ></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['adminPluginWebPath']; ?>
/oxMarket/js/jquery.simplemodal.min.js" ></script>
<script type="text/javascript">
<?php echo '
 <!--
  $(document).ready(function() {
    $(\'#campaignform\').campaignMarket({
'; ?>

            defaultFloorPrice: "<?php echo $this->_tpl_vars['_e']['vars']['defaultFloorPrice']; ?>
"
            
<?php echo '            
    });
  });
 //-->
'; ?>

</script>
 
 
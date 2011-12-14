<?php /* Smarty version 2.6.18, created on 2011-07-30 18:51:41
         compiled from /var/www/adServe/www/admin/plugins/oxMarket/templates/zone-script.html */ ?>

<script type="text/javascript" src="<?php echo $this->_tpl_vars['pluginWebPath']; ?>
/js/ox.market.js" ></script>
<script type="text/javascript">
<?php echo '
 <!--
  $(document).ready(function() {
    $(\'#zoneform\').zoneMarket({
'; ?>

        'sizes' : <?php echo $this->_tpl_vars['_e']['vars']['sizes']; ?>

<?php echo '
    });
  });
 //-->
'; ?>

 </script>
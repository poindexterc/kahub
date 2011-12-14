<?php /* Smarty version 2.6.18, created on 2011-07-30 18:56:16
         compiled from zone-advanced.html */ ?>

<br/><br/>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/form.html", 'smarty_include_vars' => array('form' => $this->_tpl_vars['form'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
<!--
<?php echo '
 $(document).ready(function() {
   $(\'#chaintype-s\').click(function() {
      $(\'#chain-zone-select\').hide();
   });
   $(\'#chaintype-z\').click(function() {
      $(\'#chain-zone-select\').show();
   });
   $(\'#append-delivery-popup\').click(function() {
      $(\'#append-interstitial\').hide();
      $(\'#append-popup\').show();
   });
   $(\'#append-delivery-interstitial\').click(function() {
      $(\'#append-popup\').hide();
      $(\'#append-interstitial\').show();
   });
   
    //initial state
   if ($(\'#chaintype-z\').attr(\'checked\') == true) {
     $(\'#chain-zone-select\').show();
   }
   if ($(\'#append-delivery-popup\').attr(\'checked\') == true) {
      $(\'#append-interstitial\').hide();
      $(\'#append-popup\').show();
   }
   if ($(\'#append-delivery-interstitial\').attr(\'checked\') == true) {
      $(\'#append-popup\').hide();
      $(\'#append-interstitial\').show();
   }
 });
'; ?>
 
//-->
</script>
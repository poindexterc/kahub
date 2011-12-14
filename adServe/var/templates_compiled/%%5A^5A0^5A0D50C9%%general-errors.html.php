<?php /* Smarty version 2.6.18, created on 2011-08-21 20:35:37
         compiled from /var/www/adServe/lib/templates/admin/form/general-errors.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', '/var/www/adServe/lib/templates/admin/form/general-errors.html', 29, false),)), $this); ?>

<?php if ($this->_tpl_vars['errors']): ?>
    <div class='errormessage'><img class='errormessage' src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/errormessage.gif' align='absmiddle'>
        <span class='tab-r'><?php echo OA_Admin_Template::_function_t(array('str' => $this->_tpl_vars['title']), $this);?>
</span><br>
        <?php echo OA_Admin_Template::_function_t(array('str' => $this->_tpl_vars['text']), $this);?>

        <ul>
        <?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aError']):
?>
            <li><?php echo $this->_tpl_vars['aError']->message; ?>
</li>
        <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
<?php endif; ?>
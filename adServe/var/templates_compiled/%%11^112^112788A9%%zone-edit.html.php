<?php /* Smarty version 2.6.18, created on 2011-07-30 18:51:41
         compiled from zone-edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'zone-edit.html', 28, false),array('function', 'phpAds_ShowBreak', 'zone-edit.html', 29, false),)), $this); ?>
<?php if ($this->_tpl_vars['showAddZone']): ?>
    <img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/icon-zone-new.gif' border='0' align='absmiddle'>&nbsp;<a href='zone-edit.php?affiliateid=<?php echo $this->_tpl_vars['affiliateid']; ?>
' accesskey='<?php echo $this->_tpl_vars['keyAddNew']; ?>
'><?php echo OA_Admin_Template::_function_t(array('str' => 'AddNewZone_Key'), $this);?>
</a>&nbsp;&nbsp;
    <?php echo OA_Admin_Template::_function_phpAds_ShowBreak(array(), $this);?>

<?php endif; ?>
<br /><br />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/general-errors.html", 'smarty_include_vars' => array('errors' => $this->_tpl_vars['zoneErrors'],'title' => 'ErrorEditingZone','text' => 'UnableToChangeZone')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['zoneid']): ?>
        <div class='errormessage' id='warning_change_zone_type' style='display:none'> <img class='errormessage' src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/errormessage.gif' align='absmiddle' />
        <span class='tab-r'> <?php echo OA_Admin_Template::_function_t(array('str' => 'Warning'), $this);?>
:</span><br />
        <?php echo OA_Admin_Template::_function_t(array('str' => 'WarnChangeZoneType'), $this);?>

    </div>

    <div class='errormessage' id='warning_change_zone_size' style='display:none'> <img class='errormessage' src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/warning.gif' align='absmiddle' />
        <span class='tab-s'> <?php echo OA_Admin_Template::_function_t(array('str' => 'Notice'), $this);?>
:</span><br />
        <?php echo OA_Admin_Template::_function_t(array('str' => 'WarnChangeZoneSize'), $this);?>

    </div>

    <?php if ($this->_tpl_vars['errors']): ?>
        <div class='errormessage'><img class='errormessage' src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/errormessage.gif' align='absmiddle'>
            <span class='tab-r'><?php echo OA_Admin_Template::_function_t(array('str' => 'ErrorEditingZone'), $this);?>
</span><br><br>";
            <?php echo OA_Admin_Template::_function_t(array('str' => 'UnableToChangeZone'), $this);?>

            <?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aError']):
?>
	            $aError->message<br>
	        <?php endforeach; endif; unset($_from); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/form.html", 'smarty_include_vars' => array('form' => $this->_tpl_vars['form'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<script language='JavaScript'>
<!--
<?php if ($this->_tpl_vars['zoneHeight'] != null && $this->_tpl_vars['zoneHeight'] != ''): ?>
    document.zoneHeight ='<?php echo $this->_tpl_vars['zoneHeight']; ?>
';
<?php endif; ?>
<?php if ($this->_tpl_vars['zoneWidth'] != null && $this->_tpl_vars['zoneWidth'] != ''): ?>
    document.zoneWidth ='<?php echo $this->_tpl_vars['zoneWidth']; ?>
';
<?php endif; ?>

<?php echo '
    function phpAds_formSelectSize(o)
    {
        // Get size from select
        size   = o.options[o.selectedIndex].value;

        if (size != \'-\')
        {
            // Get width and height
            sarray = size.split(\'x\');
            height = sarray.pop();
            width  = sarray.pop();

            // Set width and height
            document.zoneform.width.value = width;
            document.zoneform.height.value = height;

            // Set radio
            document.zoneform.sizetype[0].checked = true;
            document.zoneform.sizetype[1].checked = false;
        }
        else
        {
            document.zoneform.sizetype[0].checked = false;
            document.zoneform.sizetype[1].checked = true;
        }
    }

    function phpAds_formEditSize()
    {
        document.zoneform.sizetype[0].checked = false;
        document.zoneform.sizetype[1].checked = true;
        document.zoneform.size.selectedIndex = document.zoneform.size.options.length - 1;
    }

    function phpAds_formDisableSize()
    {
        document.zoneform.sizetype[0].disabled = true;
        document.zoneform.sizetype[1].disabled = true;
        document.zoneform.width.disabled = true;
        document.zoneform.height.disabled = true;
        document.zoneform.size.disabled = true;
    }

    function phpAds_formEnableSize()
    {
        document.zoneform.sizetype[0].disabled = false;
        document.zoneform.sizetype[1].disabled = false;
        document.zoneform.width.disabled = false;
        document.zoneform.height.disabled = false;
        document.zoneform.size.disabled = false;
    }

    function oa_sizeChangeUpdateMessage(id)
    {
        if (document.zoneWidth != document.zoneform.width.value ||
            document.zoneHeight !=  document.zoneform.height.value) {
                oa_show(id);

        } else if (document.zoneWidth == document.zoneform.width.value &&
                   document.zoneHeight ==  document.zoneform.height.value) {
            oa_hide(id);
        }
    }

    function oa_show(id)
    {
        var obj = findObj(id);
        if (obj) { obj.style.display = \'block\'; }
    }
    function oa_hide(id)
    {
        var obj = findObj(id);
        if (obj) { obj.style.display = \'none\'; }
    }
'; ?>

//-->
</script>
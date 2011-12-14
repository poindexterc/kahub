<?php /* Smarty version 2.6.18, created on 2011-07-30 19:02:00
         compiled from dashboard/feed.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'dashboard/feed.html', 41, false),array('function', 't', 'dashboard/feed.html', 45, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>OpenX RSS Feed</title>
  <link rel='stylesheet' type='text/css' href='<?php echo $this->_tpl_vars['assetPath']; ?>
/css/dashboard-widget.css'>
  <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['assetPath']; ?>
/css/dashboard-widget-ie.css" />
  <![endif]-->
</head>

<body>
    <div class="widgetListWrapper widgetContainer">
        <ul class="widgetList feedList">
        <?php $_from = $this->_tpl_vars['feed']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
            <li><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['f']['link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" target="_blank" title="<?php echo $this->_tpl_vars['f']['origTitle']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['f']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></li>
        <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
    <div><a class="site-link" href="<?php echo $this->_tpl_vars['siteUrl']; ?>
" target="_blank"><?php echo OA_Admin_Template::_function_t(array('str' => $this->_tpl_vars['siteTitle']), $this);?>
</a></div>
</body>
</html>
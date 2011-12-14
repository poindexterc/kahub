<div>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr>
	<td style="padding-left: 40px;">
	 <br />
    <?php if ($t->showDaySpanSelector)  {?><div>
    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showDaySpanSelector'))) echo htmlspecialchars($t->showDaySpanSelector());?>
    </div><?php }?>

    <?php if ($t->displayInaccurateStatsWarning)  {?><div class="stats-tz-warning">
        <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showInaccurateStatsWarning'))) echo htmlspecialchars($t->showInaccurateStatsWarning());?>
    </div><?php }?>

    <?php if ($t->noStatsAvailable)  {?>
    <div class='errormessage' style='margin-top: 2em'><img class='errormessage' src='<?php echo htmlspecialchars($t->assetPath);?>/images/info.gif' width='16' height='16' border='0' align='absmiddle'><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showNoStatsString'))) echo htmlspecialchars($t->showNoStatsString());?></div>
    <?php } else {?>
    <table width="100%" class="table">
        <thead>
            <tr>
                <th scope="col" class="aleft"><a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderHref'))) echo htmlspecialchars($t->listOrderHref("name"));?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strName"));?><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) if ($t->listOrderImage("name")) { ?><img src="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) echo htmlspecialchars($t->listOrderImage("name"));?>" border="0" /><?php }?></a></th>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><th scope="col" class="aright"><a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderHrefRev'))) echo htmlspecialchars($t->listOrderHrefRev($ck));?>"><?php echo htmlspecialchars($cv);?><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) if ($t->listOrderImage($ck)) { ?><img src="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) echo htmlspecialchars($t->listOrderImage($ck));?>" border="0" /><?php }?></a></th><?php }?>
                <?php }?>
            </tr>
        </thead>
        <tbody>
            <?php if ($t->showTotals)  {?><tr>
                <td class="last"><b><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strTotal"));?></b></td>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><td class="aright last"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($t->aTotal,$ck));?></td><?php }?>
                <?php }?>
            </tr><?php }?>
            <?php if ($this->options['strict'] || (is_array($t->aEntitiesData)  || is_object($t->aEntitiesData))) foreach($t->aEntitiesData as $e) {?><tr class="<?php echo htmlspecialchars($e['htmlclass']);?>">
                <td class="<?php echo htmlspecialchars($e['nameclass']);?>" nowrap="nowrap">
                    <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/spacer.gif" width="<?php echo htmlspecialchars($e['padding']);?>" height="16" align="absmiddle" />
                    <?php if ($e['num_children'])  {?>
                    <?php if ($e['expanded'])  {?><a href="<?php echo htmlspecialchars($t->pageURI);?>collapse=<?php echo urlencode($e['prefix']);?><?php echo urlencode($e['id']);?>"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/triangle-d.gif" width="16" height="16" align="absmiddle" border="0" /></a><?php }?>
                    <?php if (!$e['expanded'])  {?><a href="<?php echo htmlspecialchars($t->pageURI);?>expand=<?php echo urlencode($e['prefix']);?><?php echo urlencode($e['id']);?>"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/<?php echo htmlspecialchars($t->phpAds_TextDirection);?>/triangle-l.gif" width="16" align="absmiddle" height="16" border="0" /></a><?php }?>
                    <?php } else {?>
                    <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/spacer.gif" width="16" height="16" align="absmiddle" />
                    <?php }?>
                    <img src="<?php echo htmlspecialchars($e['icon']);?>" align="absmiddle" />&nbsp;
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'entityLink'))) if ($t->entityLink($e['prefix'],$e['type'])) { ?><a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'entityLink'))) echo htmlspecialchars($t->entityLink($e['prefix']));?>&<?php echo htmlspecialchars($e['linkparams']);?>"><?php } else {?><span><?php }?>
                    <?php if ($e['name'])  {?><?php echo htmlspecialchars($e['name']);?><?php } else {?><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strUntitled"));?><?php }?>
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'entityLink'))) if ($t->entityLink($e['prefix'],$e['type'])) { ?></a><?php } else {?></span><?php }?>
                    <?php echo $e['html-append'];?>
                </td>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><td class="aright <?php echo htmlspecialchars($e['htmlclass']);?>">
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumnLink'))) if ($t->showColumnLink($e,$ck)) { ?>
                    <a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumnLink'))) echo htmlspecialchars($t->showColumnLink($e,$ck));?><?php echo htmlspecialchars($e['linkparams']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($e,$ck));?></a>
                    <?php } else {?>
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($e,$ck));?>
                    <?php }?>
                </td><?php }?>
                <?php }?>
            </tr><?php }?>
        </tbody>
    </table>
    <?php if ($t->showHideInactive)  {?><div style="float: left">
        &nbsp;&nbsp;
        <?php if ($t->hideInactive)  {?>
            <img src='<?php echo htmlspecialchars($t->assetPath);?>/images/icon-activate.gif' align='absmiddle' border='0' />&nbsp;<a href='<?php echo htmlspecialchars($t->pageURI);?>hideinactive=0'><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strShowAll"));?></a> | <?php echo htmlspecialchars($t->hiddenEntitiesText);?>
        <?php } else {?>
            <img src='<?php echo htmlspecialchars($t->assetPath);?>/images/icon-hideinactivate.gif' align='absmiddle' border='0' />&nbsp;<a href='<?php echo htmlspecialchars($t->pageURI);?>hideinactive=1'><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strHideInactive"));?></a>
        <?php }?>
        <?php if ($this->options['strict'] || (is_array($t->showHideLevels)  || is_object($t->showHideLevels))) foreach($t->showHideLevels as $level => $hide) {?>
          | <img src='<?php echo htmlspecialchars($t->assetPath);?>/<?php echo htmlspecialchars($hide['icon']);?>' align='absmiddle' border='0' />&nbsp;<a href="<?php echo htmlspecialchars($t->pageURI);?>startlevel=<?php echo htmlspecialchars($level);?>"><?php echo htmlspecialchars($hide['text']);?></a>
        <?php }?>
    </div><?php }?>
    <?php if (!$t->showHideInactive)  {?><div style="float: left">
        <?php if ($this->options['strict'] || (is_array($t->showHideLevels)  || is_object($t->showHideLevels))) foreach($t->showHideLevels as $level => $hide) {?>
        | <img src='<?php echo htmlspecialchars($t->assetPath);?>/<?php echo htmlspecialchars($hide['icon']);?>' align='absmiddle' border='0' />&nbsp;<a href="<?php echo htmlspecialchars($t->pageURI);?>startlevel=<?php echo htmlspecialchars($level);?>"><?php echo htmlspecialchars($hide['text']);?></a>
        <?php }?>
    </div><?php }?>
    <div style="float: right">
        <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/triangle-d.gif" align="absmiddle" border="0" />&nbsp;<a href="<?php echo htmlspecialchars($t->pageURI);?>expand=all" accesskey="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("keyExpandAll"));?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo $t->tr("strExpandAll");?></a>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/<?php echo htmlspecialchars($t->phpAds_TextDirection);?>/triangle-l.gif" align="absmiddle" border="0" />&nbsp;<a href="<?php echo htmlspecialchars($t->pageURI);?>expand=none" accesskey="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("keyCollapseAll"));?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo $t->tr("strCollapseAll");?></a>
        &nbsp;&nbsp;
    </div>
    
	<div class="hide" id="help-market-zone-migrated-from-pre-283" style="height: auto; width: 290px;">
	   <b>Note:</b> Stats for <?php echo htmlspecialchars($t->aBranding['name']);?> ads prior to OpenX 2.8.3 are aggregated for each website in the "<?php echo htmlspecialchars($t->aBranding['name']);?> ads before OpenX 2.8.3" zone. Stats for <?php echo htmlspecialchars($t->aBranding['name']);?> ads in OpenX 2.8.3 and later are reported for each website in the actual zone in which the ad was served.
	</div>
	<div class="hide" id="help-market-optin-zone" style="height: auto; width: 290px;">
		<b><?php echo htmlspecialchars($t->strMarketZoneOptin);?> </b><br />
		Includes all ads served by <?php echo htmlspecialchars($t->aBranding['name']);?> to zones that would have otherwise served blanks.
		<br /><br />		
		<img style='border:0;display: block;margin-left: auto;margin-right: auto;' src='<?php echo htmlspecialchars($t->aBranding['assetPath']);?>/3-ways-zone-optin.gif'>
	</div>
	<div class="hide" id="help-market-optin-campaign" style="height: auto; width: 290px;">
		<b><?php echo htmlspecialchars($t->strMarketCampaignOptin);?> </b><br /> 
		Includes all ads served by <?php echo htmlspecialchars($t->aBranding['name']);?> when <?php echo htmlspecialchars($t->aBranding['name']);?> beat your specified floor price for a campaign. <br /> <br />
		<a target='_blank' title='Go to <?php echo htmlspecialchars($t->aBranding['name']);?> Quickstart page' href='plugins/oxMarket/market-campaigns-settings.php'><img style='border:0;display: block;margin-left: auto;margin-right: auto;' src='<?php echo htmlspecialchars($t->aBranding['assetPath']);?>/3-ways-campaign-optin.gif'></a>
	</div>
	
    <?php }?>
</div>
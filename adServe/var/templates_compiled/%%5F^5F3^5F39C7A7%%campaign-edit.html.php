<?php /* Smarty version 2.6.18, created on 2011-07-30 18:48:12
         compiled from campaign-edit.html */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/general-errors.html", 'smarty_include_vars' => array('errors' => $this->_tpl_vars['campaignErrors'],'title' => 'ErrorEditingCampaign','text' => 'UnableToChangeCampaign')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['statusForm']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/form.html", 'smarty_include_vars' => array('form' => $this->_tpl_vars['statusForm'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form/form.html", 'smarty_include_vars' => array('form' => $this->_tpl_vars['campaignForm'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<script language='javascript' type='text/javascript' src='<?php echo $this->_tpl_vars['assetPath']; ?>
/js/datecheck.js'></script>
<script language='javascript' type='text/javascript' src='numberFormat.js.php?lang=<?php echo $this->_tpl_vars['language']; ?>
'></script>

<script type="text/javascript">
<!--
    var CAMPAIGN_TYPE_CONTRACT_NORMAL = <?php echo $this->_tpl_vars['CAMPAIGN_TYPE_CONTRACT_NORMAL']; ?>
;
    var CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE = <?php echo $this->_tpl_vars['CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE']; ?>
;
    var CAMPAIGN_TYPE_REMNANT = <?php echo $this->_tpl_vars['CAMPAIGN_TYPE_REMNANT']; ?>
;
    var CAMPAIGN_TYPE_ECPM = <?php echo $this->_tpl_vars['CAMPAIGN_TYPE_ECPM']; ?>
;
    var CAMPAIGN_TYPE_CONTRACT_ECPM = <?php echo $this->_tpl_vars['CAMPAIGN_TYPE_CONTRACT_ECPM']; ?>
;
    var PRIORITY_ECPM_FROM = <?php echo $this->_tpl_vars['PRIORITY_ECPM_FROM']; ?>
;
    var PRIORITY_ECPM_TO = <?php echo $this->_tpl_vars['PRIORITY_ECPM_TO']; ?>
;
    var MODEL_CPM = <?php echo $this->_tpl_vars['MODEL_CPM']; ?>
;
    var MODEL_CPC = <?php echo $this->_tpl_vars['MODEL_CPC']; ?>
;
    var MODEL_CPA = <?php echo $this->_tpl_vars['MODEL_CPA']; ?>
;

    <?php if ($this->_tpl_vars['MODEL_MT'] != ''): ?>
        var MODEL_MT = <?php echo $this->_tpl_vars['MODEL_MT']; ?>
;
    <?php endif; ?>

    var calendarBeginOfWeek = <?php echo $this->_tpl_vars['calendarBeginOfWeek']; ?>
;

    var impressions_delivered = <?php echo $this->_tpl_vars['impressionsDelivered']; ?>
;
    var clicks_delivered = <?php echo $this->_tpl_vars['clicksDelivered']; ?>
;
    var conversions_delivered = <?php echo $this->_tpl_vars['conversionsDelivered']; ?>
;

    var strCampaignWarningNoTargetMessage = '<?php echo $this->_tpl_vars['strCampaignWarningNoTargetMessage']; ?>
';
    var strCampaignWarningRemnantNoWeight ='<?php echo $this->_tpl_vars['strCampaignWarningRemnantNoWeight']; ?>
';
    var strCampaignWarningEcpmNoRevenue ='<?php echo $this->_tpl_vars['strCampaignWarningEcpmNoRevenue']; ?>
';
    var strCampaignWarningExclusiveNoWeight ='<?php echo $this->_tpl_vars['strCampaignWarningExclusiveNoWeight']; ?>
';

    $(document).ready(function() {
        initCampaignForm('<?php echo $this->_tpl_vars['campaignFormId']; ?>
');
    });

<?php if ($this->_tpl_vars['adDirectEnabled']): ?>
<?php echo '

    var centralImpressionsRemaining = 3000; // REAL DATA GOES HERE
    var centralClicksRemaining = 600; //REAL DATA GOES HERE

    $(document).ready(function() {
        initCampaignStatus();
    });

    function insufficientNumberCheck(remainingLocalCount, remainingCentralCount, remainingCentralId)
    {
        var $remainingCentral = $("#" + remainingCentralId);
        if ($remainingCentral.lenght == 0) {
          return;
        }
        markInsufficient(remainingLocalCount < remainingCentralCount, remainingCentralId);
    }

    function markInsufficient(insufficient, remainingCentralId)
    {
        var $remainingCentral = $("#" + remainingCentralId);
        var $remainingCentralHelpLink = $("#" + remainingCentralId + "HelpLink");

        if (insufficient) {
            $remainingCentral.addClass("sts-insufficient");
            $remainingCentralHelpLink.show().css("display", "inline");
        }
        else {
            $remainingCentral.removeClass("sts-insufficient");
            $remainingCentralHelpLink.hide();
        }
    }
'; ?>

<?php endif; ?>

<?php echo '
function updateEcpm(userTriggered)
{
    var impressionsSoFar = this[\'impressions_delivered\'];
    var clicksSoFar = this[\'clicks_delivered\'];
    var conversionsSoFar = this[\'conversions_delivered\'];
    var revenueType = $("#pricing_revenue_type").val();
    var revenue = $("#revenue").val() ? $("#revenue").val() : 0.0;
    var clientId = $(":input[name=clientid]").val();
    var campaignId = $(":input[name=campaignid]").val();
    var startDate = $("#start").val();
    var endDate = $("#end").val();

    // AJAX call.
    $.ajax({
        url: \'campaign-edit.php?ajax=true&clientid=\' + clientId +
            \'&campaignid=\' + campaignId + \'&revenue_type=\' + revenueType +
            \'&revenue=\' + revenue + \'&impressions=\' + impressionsSoFar +
            \'&clicks=\' + clicksSoFar + \'&conversions=\' + conversionsSoFar +
            \'&start=\' + startDate + \'&end=\' + endDate,
        success: function(response) {
            $("#ecpm_val").html(response);
            $("#ecpm_val").trigger(\'ecpmUpdate\', { userTriggered: userTriggered});
        },
        error: function(xhr) {
            //alert(\'Error! Status = \' + xhr.status);
        }
    });
}

function updateCampaignPricingSectionNotes(field, unlimitedField)
{
    var name = field.name;
    var isUnlimited = unlimitedField != undefined && unlimitedField.checked;

    // Update remaining impressions/click/conversions note
    var $remainingNoteSpan = $(\'#\' +  name + \'_remaining_span\');
    var deliveredName = field.name + \'_delivered\';
    var delivered = this[deliveredName];
    var booked = field.value;
    if (booked == \'-\') {
        booked = 0;
    }
    if (!isUnlimited && max_formattedNumberStringToFloat(booked) >= 0) {
        var remaining = max_formattedNumberStringToFloat(booked) - delivered;
        $(\'#\' +  name + \'_remaining_count\').html(max_formatNumberIgnoreDecimals(remaining));
'; ?>

<?php if ($this->_tpl_vars['adDirectEnabled']): ?>
        insufficientNumberCheck(remaining, centralImpressionsRemaining, 'openadsRemainingImpressions');
        insufficientNumberCheck(remaining, centralClicksRemaining, 'openadsRemainingClicks');
<?php endif; ?>
<?php echo '
        $remainingNoteSpan.show();
    }
    else {
        $remainingNoteSpan.hide();
    }
}


function campaignFormUnlimitedUpdate(unlimitedField, limitField, focus, remainingCentralId)
{
	if (unlimitedField.checked == true) {
	    limitField.value = \'-\';
	    limitField.disabled = true;

'; ?>

   <?php if ($this->_tpl_vars['adDirectEnabled']): ?>
       <?php echo '
       //remove any "insufficient" error indicators
           if (remainingCentralId != undefined && remainingCentralId != "") {
             markInsufficient(false, remainingCentralId);
           }
       '; ?>

   <?php endif; ?>
<?php echo '
    }
    else {
        if (limitField.value == \'-\') {
            limitField.value = "";
        }
        limitField.disabled = false;
        if (focus == true) {
            limitField.focus();
        }
    }
}

'; ?>

//-->
</script>
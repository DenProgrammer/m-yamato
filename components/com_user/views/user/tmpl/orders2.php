<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

?>
<script>
	var num = 1;
	function showReport()
		{
			var date1 = jQuery("#Date1").attr("value");
			var date2 = jQuery("#Date2").attr("value");
			var url = 'index.php?option=com_sincronise&type=showOrderFinans2&ajax=1';
			
			jQuery.get(url,{date1:date1,date2:date2},function(data){
				jQuery("#reportresult").html(data);
				
				jQuery('#reportresult table:last-child colgroup').html('<col width="325"><col width="234"><col width="84"><col width="82"><col width="112"><col width="70">');
				//jQuery('td.R14C0').remove();
				//jQuery('td.R14C1').attr('colspan',2);
			});
		}
		
	jQuery("document").ready(function(){
		jQuery("#Date1").datepicker({dateFormat: 'dd.mm.yy'});
		jQuery("#Date2").datepicker({dateFormat: 'dd.mm.yy'});
		
		showReport();
	});
</script>
<div class="kabinet">
	<h1>Отчеты</h1>
	<p>
		<a href="index.php?option=com_user&view=user&layout=orders&Itemid=7">Стандартный отчет</a> - 
		Детализированный отчет - 
		<a href="index.php?option=com_user&view=user&layout=orders3&Itemid=7">Детализированный отчет новый</a>
	</p>
	Начиная с: <input type="text" readonly value="<?php $time = strtotime("-1 year", time()); echo date("d.m.Y",$time) ?>" id="Date1"/>
	по: <input type="text" readonly value="<?php echo date("d.m.Y") ?>" id="Date2"/>
	<input type="button" value="Сформировать" onclick="showReport()"/>
	<div id="reportresult"></div>
	
</div>
<?php
/**
 * @version		$Id: edit.php 20549 2011-02-04 15:01:51Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

	// No direct access.
	defined('_JEXEC') or die;

	header('Content-type: text/html; charset=utf-8');
	
	function getData($url,$post_data)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLINFO_HEADER_OUT, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
			curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');

			$data = curl_exec($ch);
			$response = curl_getinfo ($ch);
			
			curl_close($ch);
			
			return $data;
		}
		
	$url = 'http://was.autoserver.co.jp/indexe.asp';
	
	$p = str_replace('&amp;','&',base64_decode($_GET['p']));
	//echo $p.'<br>';
	if (strpos($p, 'asnete/cp')){
		$auk = 'cp';
	}
	if (strpos($p, 'asnete/ct')){
		$auk = 'ct';
	}
	$cor = '';
	$exh = '';
	$mak = '';
	$car = '';
	$typ = '';
	if ($p) 
		{
			$url = $p;
			
			$t1 = explode('?',$p);
			$t2 = explode('&',$t1[1]);
			foreach($t2 as $item)
				{
					$t3 = explode('=',$item);
					$mas[$t3[0]] = $t3[1];
				}
			
			$cor = $mas['cor'];
			$exh = $mas['exh'];
			$mak = $mas['mak'];
			$car = $mas['car'];
			$typ = $mas['typ'];
		}
	$step = 0;
	if ($mak) $step = 1;
	if ($car) $step = 2;
	if ($exh) $step = 4;
	if ($typ) $step = 5;
	$post_data = '';
	$data = getData($url,$post_data);
	
	if (((strpos($data,'user_ID')) and (strpos($data,'passwd'))) or (strpos($data,'history.back')) or (empty($p)))
		{
			$post_data = 'user_ID='.$this->userid.'&passwd='.$this->passwd;
			$url = 'http://was.autoserver.co.jp/asnete/top/cookie.asp';
			$data = getData($url,$post_data);
			
			$url = 'http://was.autoserver.co.jp/asnete/'.$auk.'/main/maker.asp';
			$data = getData($url,'');
		}
	
	$result = '';
	if ($step > 3) $result = $url;
	
	$search = array("'",'<style','</style>','<script','</script>','http://was.autoserver.co.jp/','href=\'','href="','//','oncontextmenu="return false"');
	$replace = array('"','<styleus','</styleus>','<scriptus','</scriptus>','','href=\'/','href="/','/','');
	$data = str_ireplace($search, $replace, $data);

	$pos = strrpos($url,'/');
	$domen = substr($url,0,$pos);
	//echo $url.'<br>';
	
	$pattern = '/(href=")(.+)(")/U';
	preg_match_all($pattern, $data, $arr);
	$search = $arr[2];
	$c = count($search);
	if ($p) $d = $domen; else $d = 'http://was.autoserver.co.jp/asnete/'.$auk.'/main';
	for($i=0;$i<$c;$i++)
		{
			$searcharr[$i] = 'href="'.$search[$i].'"';
			$replarr[$i] = 'href="index.php?option=com_auk&p='.base64_encode($d.$search[$i]).'"';
		}
	$data = str_replace($searcharr, $replarr, $data);
?>
<table cellspacing="0" cellpadding="5" border="0" style="margin: 0 auto; table-layout: fixed;" >
	<tr height="110" align="left"> 
		<td width="250">
			<a href="index.php?option=com_auk&p=<?php echo base64_encode('http://was.autoserver.co.jp/asnete/ct/main/maker.asp') ?>">
				<img width="160" height="100" border="0" name="Image12" src="http://was.autoserver.co.jp//asnete/images/icon_oneprice.gif" />
			</a>
		</td>
		<td width="250">
			<a href="index.php?option=com_auk&p=<?php echo base64_encode('http://was.autoserver.co.jp/asnete/cp/main/maker.asp') ?>">
				<img width="160" height="100" border="0" name="Image14" src="http://was.autoserver.co.jp//asnete/images/icon_asmember.gif" />
			</a>
		</td>
		<td width="250" class="sendbtn" ></td>
	</tr>
</table>	
<div class="curl"><?php echo $data; ?></div>
<style>
<?php if ($step == 0) { ?>
div.curl table tr td{
	font-size:0px;
}
<?php } else { ?>
div.curl table tr td{
	text-align:left;
	padding-left:10px;
}
<?php } ?>
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>


	var Base64 = {
		_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
		
		encode : function (input) {
			var output = "";
			var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
			var i = 0
			input = Base64._utf8_encode(input);
			while (i < input.length) {
				chr1 = input.charCodeAt(i++);
				chr2 = input.charCodeAt(i++);
				chr3 = input.charCodeAt(i++);
				enc1 = chr1 >> 2;
				enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
				enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
				enc4 = chr3 & 63;
				if( isNaN(chr2) ) {
					enc3 = enc4 = 64;
				}else if( isNaN(chr3) ){
					enc4 = 64;
				}
				output = output +
				this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
				this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
			}
			return output;
		},
 
		decode : function (input) {
			var output = "";
			var chr1, chr2, chr3;
			var enc1, enc2, enc3, enc4;
			var i = 0;
			input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
			while (i < input.length) {
				enc1 = this._keyStr.indexOf(input.charAt(i++));
				enc2 = this._keyStr.indexOf(input.charAt(i++));
				enc3 = this._keyStr.indexOf(input.charAt(i++));
				enc4 = this._keyStr.indexOf(input.charAt(i++));
				chr1 = (enc1 << 2) | (enc2 >> 4);
				chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
				chr3 = ((enc3 & 3) << 6) | enc4;
				output = output + String.fromCharCode(chr1);
				if( enc3 != 64 ){
					output = output + String.fromCharCode(chr2);
				}
				if( enc4 != 64 ) {
					output = output + String.fromCharCode(chr3);
				}
			}
			output = Base64._utf8_decode(output);
			return output;
		},
		
		_utf8_encode : function (string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";
			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);
				if( c < 128 ){
					utftext += String.fromCharCode(c);
				}else if( (c > 127) && (c < 2048) ){
					utftext += String.fromCharCode((c >> 6) | 192);
					utftext += String.fromCharCode((c & 63) | 128);
				}else {
					utftext += String.fromCharCode((c >> 12) | 224);
					utftext += String.fromCharCode(((c >> 6) & 63) | 128);
					utftext += String.fromCharCode((c & 63) | 128);
				}
			}
			return utftext;
		},
 
		_utf8_decode : function (utftext) {
			var string = "";
			var i = 0;
			var c = c1 = c2 = 0;
			while( i < utftext.length ){
				c = utftext.charCodeAt(i);
				if (c < 128) {
					string += String.fromCharCode(c);
					i++;
				}else if( (c > 191) && (c < 224) ) {
					c2 = utftext.charCodeAt(i+1);
					string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
					i += 2;
				}else {
					c2 = utftext.charCodeAt(i+1);
					c3 = utftext.charCodeAt(i+2);
					string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
					i += 3;
				}
			}
		return string;
		}
	}
	
	jQuery.noConflict();
	jQuery('document').ready(function($){

		$('div.curl scriptus').remove();
		$('div.curl styleus').remove();
		
		$('div.curl img').each(function(){
			var src = $(this).attr('src');
			
			var url = domen+'/'+src;
			if (url.indexOf('../cardetail'))
				{
					url = url.replace('cardetail','');
					if (loststep == 1) 
						{
							url = url.replace(/asnete.[a-z]+.main/,'');
						}
					if (p == 1) url = url.replace('asnete/top/','');
				}
			$(this).attr('src',url);
		});
		
		$('div.curl a').click(function(){return true;
			if (p == 1) document.location = 'index.php?option=com_auk&p='+Base64.encode('http://was.autoserver.co.jp/asnete/<?php echo $auk; ?>/main'+$(this).attr('href'))+'&step='+parseInt(step+1);
			if (p > 1) document.location = 'index.php?option=com_auk&p='+Base64.encode(domen+$(this).attr('href'))+'&step='+parseInt(step+1);
			return false;
		})
		
		if (result) 
			{
				$('td.sendbtn').prepend('<div><input id="zakaz" type="button" value="Отправить заявку администратору" /></div>');
				$('#zakaz').click(function(){
					$.post('index.php?option=com_auk&view=mail&tmpl=ajax',{link:result_url},function(data){
						alert(data);
					});
				});
				
			}
			
		
		switch(step)
			{
				case 0:
					{
						$('div.curl table:first tr:first').remove();
						$('div.curl table:first tr:first td:first').remove();
						$('div.curl > table > tbody > tr > td > table:first-child').remove();
						$('div.curl > table > tbody > tr > td > table:last-child').remove();
						$('div.curl > table > tbody > tr > td > table:last-child').remove();
						
						$('div.curl img').each(function(){
							var src = $(this).attr('src');
							
							src = src.replace('/main//..','');
							$(this).attr('src',src);
						});
						
						break;
					}
				case 1:
					{
						$('div.curl table:first tr:first').remove();
						$('div.curl table:first tr:first td:first').remove();
						break;
					}
				case 2:
					{
						$('div.curl a img.posabs').remove();
						
						$('div.curl > table > tbody > tr:first-child').remove();
						$('div.curl > table > tbody > tr > td:first-child').remove();
						$('div.curl table tbody tr:last-child td table:first-child tr td:nth-child(3)').html('');
						$('div.curl td').find('font:contains("Grade:")').parent().html('');
						$('div.curl td').find('font:contains("Note:")').parent().html('');
						$('div.curl img').removeAttr('alt');
						break;
					}
				case 3:
					{
						$('div.curl a img.posabs').remove();
						
						$('div.curl > table > tbody > tr:first-child').remove();
						$('div.curl > table > tbody > tr > td:first-child').remove();
						$('div.curl table tbody tr:last-child td table:first-child tr td:nth-child(3)').html('');
						$('div.curl td').find('font:contains("Grade:")').parent().html('');
						$('div.curl td').find('font:contains("Note:")').parent().html('');
						$('div.curl img').removeAttr('alt');
						break;
					}
				case 4:
					{
						$('div.curl a img.posabs').remove();
						$('div.curl td').find('font:contains("Grade:")').parent().html('');
						$('div.curl td').find('font:contains("Note:")').parent().html('');
						$('div.curl img').removeAttr('alt');
						
						$('div.curl > table > tbody > tr:last-child').remove();
						$('div.curl > table > tbody > tr:first-child > td:first-child').remove();
						$('div.curl > table > tbody > tr:first-child > td:first-child').removeAttr('rowspan');
						$('div.relative > a').remove();
						break;
					}
				case 5:
					{
						$('div.curl > table > tbody > tr:last-child').remove();
						$('div.curl > table > tbody > tr > td:first-child').remove();
						$('div.curl img.posabs').remove();
						break;
					}
			}
	});
	
	
	var domen = '<?php echo $domen; ?>';
	var p = '<?php if ($p) echo 2; else echo 1; ?>';
	var step = <?php echo $step; ?>;
	var loststep = '<?php if ((strpos($p,'cardetail.asp')) or (strpos($p,'cardetail_il.asp'))) echo 1; else echo 0; ?>';
	var result = '<?php echo $result; ?>';
	var result_url = '<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>';
</script>
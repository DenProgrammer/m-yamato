<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);

$db = JFactory::getDBO();
$sql = 'SELECT *, (
			SELECT `product_price` 
			FROM `#__vm_product_price` 
			WHERE `product_id`='.((int) $product_id).' 
			LIMIT 1
			) AS `price` , (
			SELECT `category_name` 
			FROM `#__vm_category` 
			WHERE `category_id`=(
				SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = '.((int) $product_id).' LIMIT 1)
			) AS `category_name`
		FROM `#__vm_product` 
		WHERE `product_id`='.((int) $product_id).' 
		LIMIT 1';
$db->setQuery($sql);
$prod = $db->LoadObject();

$sql = 'SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = '.((int) $product_id).' LIMIT 1';
$db->setQuery($sql);
$category_id = $db->LoadResult();

 ?>
<script>
	jQuery('document').ready(function($){
		$('.additionalimages a img').removeAttr('height').attr('width',115);
		
		$('#sendLink').click(function(){
			$.post('index.php?option=com_auk&view=mail&layout=form&tmpl=ajax', {id:<?php echo $product_id; ?>, sendlink:'form'}, function(data){
				$('body').prepend(data);
				
				$('#btn_send').click(function(){
					var send_name = $('#send_name').val();
					var send_email_from = $('#send_email_from').val();
					var send_email_to = $('#send_email_to').val();
					var send_comment = $('#send_comment').val();
					
					if (!send_name)
						{
							alert('Введите ваше имя!');
							return;
						}
					if (!send_email_from)
						{
							alert('Введите ваш электронный адрес!');
							return;
						}
					if (!send_email_to)
						{
							alert('Введите электронный адрес получателя!');
							return;
						}
					
					$.post('index.php?option=com_auk&view=mail&layout=form&tmpl=ajax',{
									send_name:send_name, send_email_from:send_email_from, id:<?php echo $product_id; ?>,
									send_email_to:send_email_to, send_comment:send_comment, sendlink:'save'},function(data){
						$('table.send_table tr').html('<td>'+data+'</td>');
					});
				});
						
				$('#send_msg_win .send_close').click(function(){
					$('#send_msg_body').remove();
				});
			});
		});
	});
</script>
<div style="padding:5px;">
	<br />
	<div class="brdcrambs" >
		<a href="index.php">Каталог</a> / <a href="index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo $category_id; ?>&Itemid=3"><?php echo $prod->category_name; ?></a>
	</div>

	<div class="imagecont">
		<img src="<?php echo 'http://yamato.kg/components/com_virtuemart/shop_image/product/'.$product_thumb_image; ?>" alt="<?php echo $product_name; ?>" />
		<div style="margin-top:10px;text-align:left;" class="additionalimages"><?php echo $this->vmlistAdditionalImages( $product_id, $images) ?></div>
	</div>
	<div class="ask_seller"><a class="button" href="index.php?page=shop.ask&flypage=flypage.tpl&product_id=<?php echo $product_id ?>&option=com_virtuemart">Задать вопрос по этому товару</a></div>

	<h1 class="product_name">
		<span class="marka">
			<?php echo JString::strtolower($prod->product_name); ?>
		</span>
	</h1>	
	<?php echo $prod->Razmer.' '.$prod->product_weight_uom ?>
	<br />
	<div class="detprice">
		<?php 
			if ($prod->price>0) echo 'Цена: '.$product_price; 
		?>
	</div>
	<br>
	<?php if (($prod->product_s_desc) or ($prod->product_desc)) echo 'Описание:<br>'.$prod->product_s_desc.$prod->product_desc.'<br><br>'; ?>
	<?php if ($prod->contact) echo 'Контактная информация:<br>'.$prod->contact.'<br><br>'; ?>
	
	<table>
		<tr>
			<td>
				<div id="sendLink" >Отправить другу</div>
			</td>
			<td>&nbsp;&nbsp;</td>
			<td>
	<?php
		if ($prod->product_in_stock > 10) {
			echo $addtocart;
		} else if(($prod->product_in_stock > 0) and ($prod->product_in_stock <= 10)){
			echo $addtocart;
		} else {
			echo $addtocart;
		}
	?>
			</td>
		</tr>
	</table>
	<br />
</div>

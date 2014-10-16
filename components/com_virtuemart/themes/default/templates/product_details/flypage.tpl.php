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

$sql = 'SELECT * FROM `#__vm_product_files` 
		WHERE `file_product_id`='.((int) $product_id);
$db->setQuery($sql);
$additionalImages = $db->LoadObjectList();


$user  = JFactory::getUser();
$closesectionaccess = $user->getParam('closesectionaccess', 0);
$closesectionlevel  = $user->getParam('closesectionlevel', 0);

$sql = 'SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = '.((int) $product_id).' LIMIT 1';
$db->setQuery($sql);
$category_id = $db->LoadResult();

$ref = $_SERVER['HTTP_REFERER'];

$mas = explode('?',$ref);
$mas2 = explode('&',$mas[1]);
foreach($mas2 as $item)
	{
		$t = explode('=', $item);
		
		$referer[$t[0]] = $t[1];
	}
	
 ?>
<script>
	jQuery('document').ready(function($){
		$('.additionalimages a img').removeAttr('height').attr('width',115);
		
		$.get('index.php?option=com_sincronise&type=loadCost&tmpl=ajax',{link:'<?php echo $prod->link; ?>'},function(data){
			$('.costValue').html(parseFloat(data)+' USD');
		})
		
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
					if (!isValidEmailAddress(send_email_from)){
						alert('Введите правильно ваш электронный адрес!');
						return;
					}
					if (!send_email_to)
						{
							alert('Введите электронный адрес получателя!');
							return;
						}
					if (!isValidEmailAddress(send_email_to)){
						alert('Введите правильно электронный адрес получателя!');
						return;
					}
					
					$.post('index.php?option=com_auk&view=mail&layout=form&tmpl=ajax',{
									send_name:send_name, send_email_from:send_email_from, id:<?php echo $product_id; ?>,
									send_email_to:send_email_to, send_comment:send_comment, sendlink:'save'},function(data){
						$('table.send_table tr').html('<td>'+data+'</td>');
					});
				});
						
				$('#send_msg_win div.send_close').click(function(){
					$('#send_msg_body').remove();
				});
			});
		});
		
		
		$('.imagecont img').each(function(){
			var src = $(this).attr('src');
			src = src.replace('m.', '');
			$(this).attr('src', src);
		});
		$('.imagecont a').each(function(){
			var src = $(this).attr('href');
			src = src.replace('m.', '');
			$(this).attr('href', src);
		});
	});
	
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
    }
	
	function openCost(){
		if (jQuery('#allPrices tr.cost').css('display') == 'table-row') {
			jQuery('#allPrices tr.cost').css('display','none');
		} else {
			jQuery('#allPrices tr.cost').css('display','table-row');
		}
	}
</script>
<style>
#allPrices tr.cost{
	display: none;
}
</style>
<div style="padding: 5px;">
	<br />
	<div class="brdcrambs" >
	<a href="index.php">Каталог</a> / 
	<a href="index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo $category_id; ?>&Itemid=2"><?php echo $prod->category_name; ?></a>
	<?php 
		if (isset($referer['model']) && isset($referer['cm']) && isset($referer['rul']))
			{
				echo "<a class='activebtn' style='float:right;' href='$ref'>Назад в поиск</a>";
			}
	?>
	</div>

	<h1 class="product_name">
		<span class="marka">
			<?php echo JString::strtolower($prod->marka); ?>
		</span>
		<span class="model">
			<?php echo $prod->model; ?>
		</span>
		<?php echo $prod->year; ?> г. 
		&nbsp;
		(<?php echo substr($prod->NomerKuzov,-4) ?>) 
	</h1>	

	<table class="proddetaylsinfo" cellpadding="0" cellspacing="2" border=0 >
		<tr>
			<td>Год выпуска</td>
			<td><?php if ($prod->year > 1900) echo $prod->year; else echo '-'; ?></td>
			<td>Пробег</td>
			<td><?php if ($prod->Probeg) echo $prod->Probeg; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Обьем</td>
			<td><?php if ($prod->EngineSize) echo $prod->EngineSize; else echo '-'; ?></td>
			<td>Кузов</td>
			<td><?php if ($prod->TipKuzova) echo $prod->TipKuzova; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>КПП</td>
			<td><?php if ($prod->TipKPP) echo $prod->TipKPP; else echo '-'; ?></td>
			<td>Тип топлива</td>
			<td><?php if ($prod->TipTopliva) echo $prod->TipTopliva; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Тип салона</td>
			<td><?php if ($prod->TipSalona) echo $prod->TipSalona; else echo '-'; ?></td>
			<td>Цвет салона</td>
			<td><?php if ($prod->CvetSalona) echo $prod->CvetSalona; else echo '-'; ?></td>
		</tr>
		<?php if ($user->id > 0) { ?>
		<tr>
			<td>Поставщик</td>
			<td><?php if ($prod->Postavshik) echo $prod->Postavshik; else echo '-'; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<?php } ?>
	</table>

	<br />
	<div>
		<table id="allPrices" class="avto_dop_param" cellpadding="0" cellspacing="0" border="1">
			<tr><td onclick="openCost()">Цена</td><td onclick="openCost()"><?php echo $product_price; ?></td></tr>
			<?php if ($closesectionaccess == 1) { ?>
				<tr><td>Аукционная цена</td><td><span class="productPrice"><?php echo round($prod->AukcionnayaCena, 2).' '.$prod->ValutaAukcionnoiCeny; ?></span></td></tr>
				<tr><td>Цена продажи</td><td><span class="productPrice"><?php echo round($prod->CenaProdaji, 2).' '.$prod->ValutaCenyProdaji; ?></span></td></tr>
				<?php if ($closesectionlevel == 3) { ?>
					<tr class="cost"><td>Себестоимость</td><td><span class="productPrice costValue"><?php echo round($prod->Sebestoimost, 2).' USD'; ?></span></td></tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div>
	<br>
	<?php if ($prod->product_desc) echo 'Описание авто:<br>'.$prod->product_desc; ?>
	<?php if ($prod->contact) echo '<br><br>Контактная информация:<br>'.$prod->contact; ?>

	<table>
		<tr>
			<td>
				<div id="sendLink" >Отправить другу</div>
			</td>
			<td>&nbsp;&nbsp;</td>
			<td>
	<?php
		if ($prod->Prodan == 1){
			echo '<span style="color:red;">Этот автомобиль продан '.date("d.m.Y",$prod->DataProdaji).'</span>';
		} else {
			if ($prod->product_in_stock == 0){
				echo '<div class="flypage_message" >
						<div class="flypage_arrow"></div>
						<div class="flypage_text">Выбранный вами автомобиль ещё не доставлен в Бишкек. Если он вас заинтересовал, нажмите кнопку "Уведомить меня".</div>
					</div>';
			}
			echo $addtocart;
		}
	?>
			</td>
		</tr>
	</table>
	<br />

	<div class="car_single_image" >
		<img width="500" src="<?php echo $prod->product_thumb_image; ?>" />
		<?php 
			if ($additionalImages) {
				foreach($additionalImages as $image) {
					echo '<div id="imagecont_'.$image->file_id.'" class="imagecont">';
					echo '    <img width="500" src="'.$image->file_url.'" />';
					echo '</div>';
				}
			}
		?>
	</div>
	
	<div class="ask_seller">
		<a class="button" href="index.php?page=shop.ask&flypage=flypage.tpl&product_id=<?php echo $product_id ?>&option=com_virtuemart">
			Задать вопрос по этому товару
		</a>
	</div>
	<br />
</div>
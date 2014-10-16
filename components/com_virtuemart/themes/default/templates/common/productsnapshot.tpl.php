<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 

$db = JFactory::getDBO();
$sql = 'SELECT * FROM `#__vm_product` WHERE `product_id`='.$product_id;
$db->setQuery($sql);
$prod = $db->LoadObject();
$product_thumb_image = $prod->product_thumb_image;

if ($prod->product_discount_id > 0){
	//echo '<div class="pos_rel"><img class="discount" src="images/discount.png" /></div>';
}

?>
<div onclick="document.location='index.php?page=shop.product_details&flypage=flypage2.tpl&product_id=<?php echo $product_id; ?>&category_id=1&option=com_virtuemart'" class="browseProductContainer">
    <table width="208" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center">
				
				<div class="productPreviewWrap">
					<?php 
						echo ps_product::image_tag( urldecode($product_thumb_image), 'class="browseProductImage" width="208" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ); 
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left">
				<span class="product_price_cont" ><span class="productPrice"><?php echo $price; ?></span></span>
				<span class="marka">
					<?php
						echo $prod->product_name;
					?>
				</span>
			</td>
		</tr>
    </table>  
</div>

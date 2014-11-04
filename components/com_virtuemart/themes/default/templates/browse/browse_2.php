<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC'))
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');
mm_showMyFileName(__FILE__);

$db                  = JFactory::getDBO();
$sql                 = 'SELECT * FROM `#__vm_product` WHERE `product_id`=' . $product_id . ' LIMIT 1';
$db->setQuery($sql);
$prod                = $db->LoadObject();
$product_thumb_image = $prod->product_thumb_image;
?>
<div class="browseProductContainer">
    <a href="<?php echo $product_flypage ?>">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <div class="productPreviewWrap">
                        <img width="200" src="<?php echo $product_thumb_image; ?>" alt="<?php echo $product_name; ?>" />
                    </div>
                </td>
                <td width="10">&nbsp;</td>
                <td align="left" valign="top">
                    <span class="marka">
                        <?php
                        echo $prod->product_name;
                        ?>
                    </span>
                    <br>
                    <br>
                    <span class="product_price_cont" ><?php echo $product_price ?></span>
                </td>
            </tr>
        </table>  
    </a>
</div>
<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC'))
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');
mm_showMyFileName(__FILE__);

if (!$_GET['category_id']) {
    header("Location: index.php");
    exit;
}

$db = JFactory::getDBO();

$sql  = 'SELECT * FROM `#__vm_product` WHERE `product_id`=' . $product_id . ' LIMIT 1';
$db->setQuery($sql);
$prod = $db->LoadObject();

$product_thumb_image = $prod->product_thumb_image;
$product_name        = $prod->marka . ' ' . $prod->model . ' (' . substr($prod->NomerKuzov, -4) . ')';
?>
<div class="browseProductContainer">
    <a href="<?php echo $product_flypage ?>">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" valign="top">
                    <div class="productPreviewWrap">
                        <img width="208" src="<?php echo $product_thumb_image; ?>" alt="<?php echo $product_name; ?>" />
                    </div>
                </td>
                <td width="10">&nbsp;</td>
                <td align="left" valign="top">
                    <span class="marka">
                        <?php
                        $marka               = JString::strtolower($prod->marka);
                        $num1                = mb_strlen($marka);
                        if ($num1 < 20) {
                            echo $marka;
                        } else {
                            echo mb_substr($marka, 0, 20);
                        }
                        ?>
                    </span>
                    <span class="model">
                        <?php
                        $model = $prod->model;
                        $num2  = mb_strlen($model);

                        if ($num1 + $num2 <= 20) {
                            echo $model;
                        } else {
                            echo mb_substr($model, 0, (19 - $num1));
                        }
                        ?>
                    </span>
                    <br>
                    <br>
                    <span class="product_price_cont" ><?php echo $product_price ?></span>
                    <br>
                    <br>
                    <?php if ($prod->year > 1900) echo $prod->year . ' г.'; ?> 
                </td>
            </tr>
        </table>  
    </a>
</div>
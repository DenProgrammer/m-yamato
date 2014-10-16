<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/* Latest Products Module
*
* @version $Id: mod_virtuemart_latestprod.php 1159 2008-01-14 20:30:30Z soeren_nb $
* @package VirtueMart
* @subpackage modules
*
* @copyright (C) 2000 - 2004 Mr PHP
// W: www.mrphp.com.au
// E: info@mrphp.com.au
// P: +61 418 436 690
* Conversion to Mambo and the rest:
* 	@copyright (C) 2004-2005 Soeren Eberhardt
*
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/

global $mosConfig_absolute_path;
// Load the virtuemart main parse code
if( file_exists(dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' )) {
	require_once( dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' );
} else {
	require_once( dirname(__FILE__).'/../components/com_virtuemart/virtuemart_parser.php' );
}

$max_items = $params->get( 'max_items', 2 ); //maximum number of items to display
$category_id = $params->get( 'category_id', null ); // Display products from this category only
$display_style = $params->get( 'display_style', "vertical" ); // Display Style
$products_per_row = 1; // Display X products per Row
$show_price = (bool)$params->get( 'show_price', 1 ); // Display the Product Price?
$show_addtocart = (bool)$params->get( 'show_addtocart', 1 ); // Display the "Add-to-Cart" Link?

require_once( CLASSPATH . 'ps_product.php');
$ps_product = new ps_product;

$db1 = JFactory::getDBO();
$db1->setQuery('SELECT category_name FROM jos_vm_category WHERE category_id = '.$category_id);
$category_name = $db1->LoadResult();

$db =& new ps_DB;
$q  = "SELECT DISTINCT product_sku, product_name, year, product_thumb_image, marka, model, jos_vm_product.product_id AS product_id , (
						SELECT product_price FROM  jos_vm_product_price WHERE product_id=#__{vm}_product.product_id LIMIT 1
					) AS price,(
						SELECT product_currency	 FROM  jos_vm_product_price WHERE product_id=#__{vm}_product.product_id LIMIT 1
					) AS currency  FROM #__{vm}_product, #__{vm}_product_category_xref, #__{vm}_category WHERE ";
$q .= "product_parent_id=''";
$q .= "AND #__{vm}_product.product_id=#__{vm}_product_category_xref.product_id ";
$q .= "AND #__{vm}_category.category_id=#__{vm}_product_category_xref.category_id ";
if( !empty( $category_id ) ) {
	$q .= "AND #__{vm}_category.category_id='$category_id' ";
}
if( CHECK_STOCK && PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS != "1") {
	$q .= " AND product_in_stock > 0 ";
}
$q .= "AND #__{vm}_product.product_publish='Y' ";



if ($_GET['cm']) $q .= ' AND (`#__{vm}_product`.`marka`=\''.$_GET['cm'].'\' OR `#__{vm}_product`.`marka`=\'NONE\')';
if ($_GET['model']) 
	{
		$modelarr = explode(';',$_GET['model']);
		$modelstr = $sep = '';
		foreach($modelarr as $m)
			{
				$modelstr .= "$sep '$m'";
				$sep = ',';
			}
		$q .= ' AND `#__{vm}_product`.`model` IN ('.$modelstr.')';
	}
if ($_GET['year']) $q .= ' AND `#__{vm}_product`.`year`=\''.$_GET['year'].'\'';
if ($_GET['rul']) 
	{
		if ($_GET['rul']=='rul_left') $q .= ' AND `#__{vm}_product`.`RaspolojenieRulya`=\'Леворульная\'';
		if ($_GET['rul']=='rul_right') $q .= ' AND `#__{vm}_product`.`RaspolojenieRulya`=\'Праворульная\'';
	}
if ($_GET['find_text'])
	{
		$find_text = mysql_real_escape_string($_GET['find_text']);
		 $q .= ' AND `#__{vm}_product`.`product_name` LIKE \'%'.$find_text.'%\' ';
	}


$q .= "ORDER BY #__{vm}_product.cdate DESC ";
$q .= "LIMIT 0, $max_items ";
$db->query($q);

$Itemid = ($category_id == 1) ? 2 : 3;
echo '<h3>
		<a href="index.php?option=com_virtuemart&page=shop.browse&category_id='.$category_id.'&Itemid='.$Itemid.'" >'.$category_name.'</a>
	</h3>';
if( $db->num_rows() > 0 ){ ?>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">        
        <?php
        $i = 0;
        while($db->next_record() ){
			if ($i%2)
				$sectioncolor = "sectiontableentry2";
			else
				$sectioncolor = "sectiontableentry1";
              
			if( $display_style == "vertical" ) {
				?>
				<tr align="center" class="<?php echo $sectioncolor ?>">
					<td><?php //$ps_product->show_snapshot($db->f("product_sku"), $show_price, $show_addtocart); ?><br /></td>
				</tr>
				<?php
			}
			elseif( $display_style== "horizontal" ) {
				if( $i == 0 )
					echo "<tr>\n";
				echo "<td align=\"center\">";
				$ps_product->show_snapshot($db->f("product_sku"), $show_price, $show_addtocart);
				echo "</td>\n";
				if( ($i+1) == $max_items )
					echo "</tr>\n";
			}
			elseif( $display_style== "table" ) {
				if( $i == 0 )
					echo "<tr>\n";
				echo "<td>";
				$ps_product->show_snapshot($db->f("product_sku"), $show_price, $show_addtocart);

				echo "</td>\n";
				if ( ($i+1) % $products_per_row == 0)
					echo "</tr><tr>\n";
				if( ($i+1) == $max_items )
					echo "</tr>\n";
			}
			$i++;
        }
?>
</table>
<?php
}
?>
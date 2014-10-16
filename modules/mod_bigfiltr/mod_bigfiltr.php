<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

$selmarka = JRequest::getVar('marka');
$selmodel = JRequest::getVar('model');
$selrul = JRequest::getVar('rul');
$find_text = JRequest::getVar('find_text');
	
$db = JFactory::getDBO();
$sql = 'SELECT DISTINCT `marka` FROM `#__vm_product` WHERE `product_publish` = \'Y\' AND `marka`!=\'NONE\' AND `product_type` = \'automobil\'';
$db->setQuery($sql);
$marka = $db->LoadObjectList();

$models = array();
if ($selmarka) {
	$sql = 'SELECT DISTINCT `model` FROM `#__vm_product` WHERE `product_publish` = \'Y\' AND `marka`=\''.$selmarka.'\' AND `product_type` = \'automobil\'';
	$db->setQuery($sql);
	$models = $db->LoadObjectList();
}

$rul = array('Левое'=>'rul_left','Правое'=>'rul_right');

	
require(JModuleHelper::getLayoutPath('mod_bigfiltr'));

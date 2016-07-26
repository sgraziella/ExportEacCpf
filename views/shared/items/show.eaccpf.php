<?php

include_once(dirname(dirname(dirname(dirname(__FILE__)))).'/helpers/EACcpfExporter.php');


$item = get_current_record('item');
$itemID = $item->id;

$exporter = new EacCpfExporter();


if(!isset($itemID))
  die('ERROR: item ID not set');

header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="Item_'.$itemID.'.xml"');

try{
  echo $exporter->exportItem($itemID);
} catch (Exception $e) {
  //$this->flashMessenger->addMessage($e->getMessage(),'error');;
	die($e->getMessage());
}
?>
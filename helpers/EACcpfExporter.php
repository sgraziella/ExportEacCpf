<?php
Class EacCpfExporter
/*Class ExportEacCpfPlugin*/
{ 
  function __construct()
  {

  }

  /**
   *Returns EAC-CPF XML for a given single Omeka item
   *
   *@param int $itemID The ID of the Omeka item
   *@return string $xml The contents of the EAC-CPF file
   */
  public function exportItem($itemID)
  {
    ob_start();
    $this->_generateXML($itemID,false);
    return ob_get_clean();
  }


  private function _generateXML($itemID)
  {
    if(!is_numeric($itemID))
      {
	     echo "ERROR: Invalid item ID";
	     die();
      }

    $item = get_record_by_id("item",$itemID);
    $owner = $item->getOwner();
    $currentuser = current_user();

    if(is_null($item)||empty($item))
      {
	       echo "ERROR: Invalid item ID";
	       die();
      }

    $titles = $item->getElementTexts('Dublin Core','Title');
    $title = $titles[0];
    $title = htmlspecialchars($title);

    $id = $item->getElementTexts('Dublin Core','Identifier')[0];

    $agencyname = $item->getElementTexts('Dublin Core', 'Publisher')[0];

    $maintenancestatus = $item->getElementTexts('Dublin Core', 'Accrual Method')[0];

    $publicationstatus = $item->getElementTexts('Dublin Core', 'Accrual Policy')[0];

    $language = $item->getElementTexts('Dublin Core', 'Language')[0];

    $conventiondeclaration = $item->getElementTexts('Dublin Core', 'Conforms To');

    $eventdatatime = $item->getElementTexts('Dublin Core', 'Date Created')[0];

    $agent = $item->getElementTexts('Dublin Core', 'Creator')[0];

    $eventdescription = $item->getElementTexts('Dublin Core', 'Instructional Method')[0];

    $entitytype = $item->getElementTexts('Dublin Core', 'Type')[0];

   // $descriptivenote = $item->getElementTexts('Dublin Core', 'Bibliographic Citation')[0];

    
    // EAC-CPF Item Type Metadata
    $nameentryparallel = $item->getElementTexts('Item Type Metadata', 'name Entry Parallel');
    
    $existdates = $item->getElementTexts('Item Type Metadata', 'Dates of Existence')[0];

    $places = $item->getElementTexts('Item Type Metadata', 'Places');

    $functions = $item->getElementTexts('Item Type Metadata', 'Functions');

    $bioghist = $item->getElementTexts('Item Type Metadata', 'Biography or Historical Note');

    $sources = $item->getElementTexts('Item Type Metadata', 'Sources');

    $relations = $item->getElementTexts('Item Type Metadata', 'Relations');

    $type = $item->getItemType();
    $files = $item->getFiles();

    echo '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl"?>
<eac-cpf xsi:schemaLocation="urn:isbn:1-931666-33-4 cpf.xsd" xmlns="urn:isbn:1-931666-33-4"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xlink="http://www.w3.org/1999/xlink">'."\n"; 

     echo "<control>";
     echo "<recordId>$id</recordId>";
     echo "<maintenanceStatus>";
     echo $maintenancestatus;
     echo "</maintenanceStatus>";
     echo "<publicationStatus>";
     echo $publicationstatus;
     echo "</publicationStatus>";
     echo "<maintenanceAgency>";
     echo "<agencyCode/>";
     echo "<agencyName>";
     echo $agencyname;
     echo "</agencyName>";
     echo "</maintenanceAgency>";
     echo "<languageDeclaration>";
     echo "<language>";
     echo $language;
     echo "</language>";
     echo "<script/>";
     echo "</languageDeclaration>";
     foreach ($conventiondeclaration as $key => $value) {
        echo "<conventionDeclaration>";
        echo "<citation>";
        echo $value;
        echo "</citation>";
        echo "</conventionDeclaration>";
     }
     echo "<localTypeDeclaration>";
     echo "<abbreviation/>";
     echo "<citation/>";
     echo "<descriptiveNote>";
     echo "<p/>";
     echo "</descriptiveNote>";
     echo "</localTypeDeclaration>";
     echo "<maintenanceHistory>";
     echo "<maintenanceEvent>";
     echo "<eventDateTime>";
     echo $eventdatatime;
     echo "</eventDateTime>";
     echo "<agent>";
     echo $agent;
     echo "</agent>";
     echo "<eventDescription>";
     echo $eventdescription;
     echo "</eventDescription>";
     echo "</maintenanceEvent>";
     echo "</maintenanceHistory>";
     echo "<sources>";
     foreach ($sources as $key => $value) {
        echo "<source xlink:type=\"#\" xlink:href=\"#\">";
        echo "<sourceEntry>";
        echo $value;
        echo "</sourceEntry>";
        echo "</source>";
     }
     echo "</sources>";
     echo "</control>";


// cpfDescription
    echo "<cpfDescription>";
    echo "<identity>";
    echo "<entityId/>";
    echo "<entityType>";
    echo $entitytype;
    echo "</entityType>";
    echo "<nameEntry>";
    echo $title;
    echo "<authorizedForm/>";
    echo "</nameEntry>";   
    foreach ($nameentryparallel as $key => $value) {
      echo "<nameEntryParallel>";
      echo $value['text'];
      echo "</nameEntryParallel>";
    }
    echo "</identity>";
    echo "<description>";
    echo "<existDates>";
    echo "<dateRange>";
    echo "<date>";
    echo $existdates;
    echo "</date>";
    echo "<descriptiveNote/>"; 
    echo "</dateRange>";
    echo "</existDates>";
    echo "<places>";
    foreach ($places as $key => $value) {
      echo "<place>";
      echo $value;
      echo "</place>";
    }
    echo "</places>";
    echo "<functions>";
    foreach ($functions as $key => $value) {
        echo "<function>";
        echo "<date/>";
        echo "<term>";
        echo $value['text'];
        echo "</term>";
        echo "<descriptiveNote/>";
        echo "<placeEntry/>";
        echo "</function>";
    }
    echo "</functions>";
    echo "<biogHist>";
    echo "<abstract/>";
    echo "<chronList>";
    foreach ($bioghist as $key => $value) {
        echo "<chronItem>";
        echo "<date/>";
        echo "<event>";
        echo $value;
        echo "</event>";
        echo "</chronItem>";
    }
    echo "</chronList>";
    echo "<list/>";
    echo "<citation/>";
    echo "<outline/>";
    echo "</biogHist>";
    echo "</description>";
    echo "</cpfDescription>";


// Relations
    echo "<relations>";
    foreach ($relations as $key => $value) {
        echo "<cpfRelation cpfRelationType=\"#\" xlink:type=\"#\" xlink:arcrole=\"#\">";
        echo "<relationEntry>";
        echo $value;
        echo "</relationEntry>";
        echo "<functionRelation/>";
        echo "<resourceRelation/>";
        echo "</cpfRelation>";
        echo "<descriptiveNote/>";
    }
    echo "</relations>";
    echo "</eac-cpf>";
  }
}

?>
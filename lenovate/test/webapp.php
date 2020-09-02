
<ul class="list" id="ulid">
    <li id="liid">
        <a id="aid"></a>
        <ul id="ul2id">
            <li id="li2id"></li>  
        </ul>                
    </li>
</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(".list > li a").click(function() {
        $(this).parent().find("ul").toggle();
		
    })
});
function createChild(){
	var ulid = document.getElementById("ulid");
	var liid = document.getElementById("liid");
	var cliid = liid.cloneNode(true);
	var aid = document.getElementById("aid");
	var ul2id = document.getElementById("ul2id");
	var li2id = document.getElementById("li2id");
	ulid.appendChild(cliid);
}
function createChild2(){
	var ulid = document.getElementById("ulid");
	var liid = document.getElementById("liid");
	
	var aid = document.getElementById("aid");
	var ul2id = document.getElementById("ul2id");
	var li2id = document.getElementById("li2id");
	var cliid = liid.cloneNode(true);
	ulid.appendChild(cliid);
}
</script>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'PHPExcel.php';

PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
include 'PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load('b1.xlsx');
$foundInCells = array();
$searchValue = 'usa';
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $ws = $worksheet->getTitle();
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);
        foreach ($cellIterator as $cell) {
            if (strcasecmp($cell->getValue(), $searchValue) == 0) {
               	$foundInCells[] = $ws . '!' . $cell->getCoordinate();
					
					if(strcasecmp($cell->getColumn(),"A") == 0){
							echo "check1";
							echo '<script type="text/javascript">	
							aid.innerHTML = '.json_encode($searchValue).'			
							createChild();   
							</script>';
					}
					
					if(strcasecmp($cell->getColumn(),"B") == 0){
						echo "check2";
						$xyz = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $cell->getRow())->getValue();
						echo $xyz;
						echo '<script type="text/javascript">
							aid.innerHTML = '.json_encode($xyz).'
							li2id.innerHTML = '.json_encode($searchValue).' 
						  
						   </script>';
					}
            }
        }
    }
}
foreach($foundInCells as $foundInCell){
	
	echo '<h1><center>'.$foundInCell."\n".'</h1></center>';
}

?>

<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json; charset=UTF-8');

include "config.php";

$postjson = json_decode(file_get_contents('php://input'), true);
$today = date('Y-m-d');


//tracabilite bijoux

if($postjson['aksi']=='getbijouxinfostock'){
    $data = array();
    $query = mysqli_query($mysqli, "SELECT  ospos_items.item_id,ospos_items.prix_vente_g,ospos_items.heure,ospos_items.type_or,ospos_items.name,ospos_items.deleted,ospos_items.pic_filename,ospos_item_quantities.quantity,ospos_item_quantities.poids,ospos_item_quantities.location_id,ospos_stock_locations.location_id,ospos_stock_locations.location_name from ospos_items inner join ospos_item_quantities on ospos_item_quantities.item_id=ospos_items.item_id  inner join ospos_stock_locations on ospos_stock_locations.location_id=ospos_item_quantities.location_id  where   ospos_item_quantities.poids>0 limit 1 ");
  
    while($row = mysqli_fetch_array($query)){
  
        $data[] = array(
          'item_id'   => $row['item_id'],
          'type_or'   => $row['type_or'],
          'name'   => $row['name'],
          'deleted' => $row['deleted'],
          'pic_filename' => $row['pic_filename'],
          'location_name'=>$row['location_name'],
          'poids'=>$row['poids'],
          'quantity'=>$row['quantity'],
          'heure'=>$row['heure'],
          'prix_vente_g'=>$row['prix_vente_g'],
            
           
           
           
        );
    }
  
    if($query) $result = json_encode(array('success'=>true, 'result'=>$data));
    else $result = json_encode(array('success'=>false));
    
    echo $result;
  }



?>
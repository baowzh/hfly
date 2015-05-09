<?php
 $item_get = explode(",", $_GET["item"]);
        $item_get = array_intersect(array_keys($assgin['item']), $item_get);
        if ($item_get) {
            $where["hotel.service_item"] = array("in" => $item_get);
            $search["item"] = $item_get;
        }   

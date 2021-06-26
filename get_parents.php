<?php
    
    $host = 'localhost' ;
    $user = 'root' ;
    $pass = '' ;
    $db = 'test_magna' ;

    $cnn = mysql_connect($host,$user,$pass);
    if (!$cnn) {
      exit ('Koneksi Gagal');
    }
    //mysql_set_charset('utf8',$cnn);

    $db = mysql_select_db($db);
    if (!$db) {
      exit ('Gagal Memilih Database');
    }

    function getParent($id) {
        $sql_get_parents = 'SELECT * FROM member where id = "'.$id.'"';
        $res_get_parents = mysql_query($sql_get_parents);
        $row_get_parents = mysql_fetch_assoc($res_get_parents);

        return $row_get_parents;
    }

    function get_parents($name) {
        $sql_get_parents = 'SELECT * FROM member where name = "'.$name.'"';
        $res_get_parents = mysql_query($sql_get_parents);

        $arrName = array();
        while ($row_get_parents = mysql_fetch_assoc($res_get_parents)) {
            do {
                $parent_name = getParent($row_get_parents['parent_id']);
                $row_get_parents['parent_id'] = $parent_name['parent_id'];

                if(!in_array($parent_name['name'], $arrName)) {
                    array_push($arrName, $parent_name['name']);
                } else {
                    $parent_name = false;
                }
            } while ($parent_name != false);
        }

        return $arrName;
    }


    $tree = get_parents('Derpina');
    echo json_encode($tree);
?>
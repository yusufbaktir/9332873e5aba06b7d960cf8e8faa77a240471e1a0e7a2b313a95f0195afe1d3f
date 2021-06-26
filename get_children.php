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

    function getChild($name) {
        $sql_get_parents = 'SELECT * FROM member where name = "'.$name.'"';
        $res_get_parents = mysql_query($sql_get_parents);
        $arrChild = array();
        while ($row_get_parents = mysql_fetch_assoc($res_get_parents)) {
            $sql_get_child = 'SELECT * FROM member where parent_id = "'.$row_get_parents['id'].'"';
            $res_get_child = mysql_query($sql_get_child);

            while ($row_get_child = mysql_fetch_assoc($res_get_child)) {
                array_push($arrChild, $row_get_child['name']);
            }
        }

        return $arrChild;
    }


    $tree = getChild('John');
    echo json_encode($tree);
?>
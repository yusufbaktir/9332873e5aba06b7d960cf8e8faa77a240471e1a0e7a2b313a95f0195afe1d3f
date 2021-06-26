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

    // function getChildren($id_member) {
    //     $sql_get_children = 'SELECT * FROM member where parent_id = "'.$id_member.'"';
    //     $res_get_children = mysql_num_rows(mysql_query($sql_get_children));
    //     $row_get_children = mysql_fetch_assoc(mysql_query($sql_get_children));
    //     return ($res_get_children > 0) ? $row_get_children['name'] : FALSE;
    // }

    function getChildren($id_member) {
        $sql_get_children = 'SELECT * FROM member where parent_id = "'.$id_member.'" AND id != "'.$id_member.'"';
        $res_get_children = mysql_query($sql_get_children);
        $arrChild = array();
        while ($row_get_children = mysql_fetch_assoc($res_get_children)) {
            $arrTampung = array();
            $arrTampung['name'] = $row_get_children['name'];
            $arrTampung['children'] = $row_get_children['id'];

            array_push($arrChild, $arrTampung);
        }

        return $arrChild;
    }

    function get_tree($name="root") {
        $sql_get_tree = 'SELECT * FROM member where name = "'.$name.'"';
        $res_get_tree = mysql_query($sql_get_tree);
        $row_get_tree = mysql_fetch_assoc($res_get_tree);

        $arrTree = array();
        // do {
            $child = getChildren($row_get_tree['id']);

            $arrTampung = array();
            $arrTampung['name'] = $row_get_tree['name'];
            $arrTampung['children'] = $child;

            array_push($arrTree, $arrTampung);
        // } while (!empty($child));

        return $arrTree;
    }


    $tree = get_tree();
    echo json_encode($tree);
?>
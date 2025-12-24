<?php 
    session_start();
    include './database/db_connect.php';

    $nav_sql = $conn->query("select * from navigation order by id");
    // $nav_stmt = $conn->prepare($nav_sql);
    // $nav_stmt->execute();
    // $nav = $nav_stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($nav);

    // // echo var_dump($nav) . "<br/>" . "<br/>";

    // echo $nav[0]["name"] . "<br>";

    // echo "<ul>";
    // foreach($nav as $n){
    //     // echo $n . "=>" . $nk . "<br>";
    //         foreach($n as $k => $v){
    //             echo $k . "=>" . $v . "<br>";
    //         }
    // }
    // echo "</ul>";




    //     function echo_menu($menu_array) {
    //         //go through each top level menu item
    //         foreach($menu_array as $menu) {
    //             echo "<li>{$menu['name']}</a>";
    //             //see if this menu has children
    //             if(array_key_exists('parent_id', $menu)) {
    //                 echo '<ul>';
    //                 //echo the child menu
    //                 echo_menu($menu['parent_id']);
    //                 echo '</ul>';
    //             }
    //             echo '</li>';
    //         }
    //     }

    //     echo '<ul>';
    //     echo_menu($nav);
    //     echo '</ul>';


                    // $pdo = new PDO("mysql:dbname=newdummy;host=localhost","root","");

                    // $query = $pdo->query("Select * from hierarchy");

                    $family_tree = [];
                    $root_parent = -1;
                    $root_parent_name = "";

                    function makeTree($query,&$family_tree,&$root_parent,&$root_parent_name){
                        while($row = $query->fetch(PDO::FETCH_ASSOC)){
                            if($row['parent_id'] == 0){
                                $root_parent = $row['id'];
                                $root_parent_name = $row['name'];
                            }else{
                                if(!isset($family_tree[$row['parent_id']])){
                                    $family_tree[$row['parent_id']] = [];
                                }          
                                $family_tree[$row['parent_id']][] = array($row['name'],$row['id']);
                            }    
                        }
                    }

                    function buildList($family_tree,$parent){
                        $list = "<ul>";

                        foreach($family_tree[$parent] as $each_child){
                            $list .= "<li>" . $each_child[0];
                            if(isset($family_tree[$each_child[1]])){
                                $list .= buildList($family_tree,$each_child[1]);
                            }
                            $list .= "</li>";
                        }

                        $list .= "</ul>";

                        return $list;
                    }


                    makeTree($nav_sql,$family_tree,$root_parent,$root_parent_name);


                    echo "<ul>";
                    echo "<li>$root_parent_name";
                    echo buildList($family_tree,$root_parent);
                    echo "</li>";
                    echo "</ul>";
?>
<?php
function loadClass($className) {
    echo "<div>Loading class: $className</div>";
    require ($className  . ".class.php");
}
spl_autoload_register('loadClass');


// get opinions detail information
if(isset($_GET['id'])){
    $id = mysql_clean($conn,$_GET['id']);
    $opinion_arr = array();
    $opinion_arr['data'] = array();
    $opinion_arr['reply'] = array();

 
    $sql = 'SELECT * FROM post WHERE id='.$id;
    $result = $conn->query($sql);
    if(!$result) die("Database access failed: ". $conn->error);

    $row = $result->fetch_array();
    extract($row);
    $opinion_item = array(
     'id' => $id,
     'name' => $name,
     'text' => $text,
     'post_date' => $post_date,
     'likes' => $likes,
     'reply_to' => $reply_to
     );
     array_push($opinion_arr['data'],$opinion_item);

   // reply
     $sql = 'SELECT * FROM post WHERE reply_to='.$id;
     $result = $conn->query($sql);
     if(!$result) die("Database access failed: ". $conn->error);
     $rows = $result->num_rows;
     if($rows > 0)
     {
         for($j = 0; $j < $rows; ++$j)
         {
             $result->data_seek($j);
             $row = $result->fetch_array();
             extract($row);

             $opinion_item = array(
                 'id' => $id,
                 'name' => $name,
                 'text' => $text,
                 'post_date' => $post_date,
                 'likes' => $likes,
                 'reply_to' => $reply_to
                 );
             array_push($opinion_arr['reply'],$opinion_item);    

         }
     }
     else // opinion with no replies
     {
        $opinion_item = array(
            'id' => 0,
            'text' => 'This opinion has not been replied'
        );
         array_push($opinion_arr['reply'],$opinion_item);
     }
     // opinion to json object
     echo json_encode($opinion_arr);
 } 

//getting all top-level opinions
else
{
    $sql = 'SELECT * FROM post WHERE isnull(reply_to) ORDER BY post_date DESC';

        $result = $conn->query($sql);    
        if(!$result) die("Database access failed: ". $conn->error);

        $rows = $result->num_rows;

        $opinions_arr = array();
        $opinions_arr['data'] = array();
        if($rows > 0)
        {
            for( $j = 0; $j < $rows; ++$j){
                $result->data_seek($j);
                $row = $result->fetch_array();
                extract($row);
    
                $opinion_item = array(
                    'id' => $id,
                    'name' => $name,
                    'text' => $text,
                    'post_date' => $post_date,
                    'likes' => $likes,
                    'reply_to' => $reply_to
                );
            }

        }
        else 
        {
            echo json_encode();
        }

}        
        $result->close();
        $conn->close();
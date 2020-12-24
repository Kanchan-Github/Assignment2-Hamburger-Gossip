<?php
function loadClass($className) {
    echo "<div>Loading class: $className</div>";
    require ($className  . ".class.php");
}
spl_autoload_register('loadClass');


// liking an opinion

if(isset($_POST['like']) && isset($_POST['id']))
{
    $like = mysql_clean($conn,$_POST['like']);
    $id = mysql_clean($conn,$_POST['id']);
    if($like == 1)
    {
        //calling initial likes
        $sql = "SELECT likes FROM hamburger WHERE id=$id";
        $result = $conn->query($sql);
        if(!$result) die("Database access failed: ". $conn->error);

        //increasing the number of likes
        $row = $result->fetch_array();
        $likes = $row['likes'];
        $new_likes = $likes + 1;
        $sql = "UPDATE hamburger SET likes=$new_likes WHERE id=$id";
        $result = $conn->query($sql);
        if(!$result) die("Database access failed: ". $conn->error);

    }
    elseif($like == 0) 
    {
        //decreasing the number of likes
        $sql = "SELECT likes FROM hamburger WHERE id=".$id;
        $result = $conn->query($sql);
        if(!$result) die("Database access failed: ". $conn->error);

        $row = $result->fetch_array();
        $likes = $row['likes'];
        $new_likes = $likes - 1; 
        $sql = "UPDATE hamburger SET likes=$new_likes WHERE id=$id";
        $result = $conn->query($sql);
        if(!$result) die("Database access failed: ". $conn->error);
    }
}
$conn->close()

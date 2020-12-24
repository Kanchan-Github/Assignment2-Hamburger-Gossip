<?php 

class Router {
    private $handlers = array();
    public $regex;
    public $meethod;
    public $function;

    function register($regex, $method, $function){
        $this->handlers[] = new Handler ($regex, $method, $function);
    }

    function route($url, $method){
        $params = null;
        foreach ($this->handlers as $handler){
            if($handler->handle($url,$method)){
                return;
            }
        }
    }
}

$router = new Router();
// declare output in json format
header("Content-Type: application/json"); 
$router->register('#^/list/sort/#', "POST", function($params){
    require_once "includes/dbh.inc.php";
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    if($params[1] ==="date")
    $query = 'SELECT * FROM event ORDER BY event_post_date';
    else
    $query = 'SELECT * FROM event ORDER BY reviewer_name ';
    $results = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($results)){
        $m[]=[
            "reviewer_name"=>$row['reviewer_name'],
            "reviewer_id"=>$row['reviewer_id'],
            "review_time"=>$row['review_time'],
            "reviewer_post date"=>$row['reviewer_post_date'],
            "reviewer_poster_name"=>$row['reviewer_poster_name']
        ];
    }
    echo json_encode($m);
});

$router->register('#^/list/(\d+)#', "GET", function($params){
   require_once "includes/dbh.inc.php";
   $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    $query = 'SELECT * from post where reply_to=?';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $params[1]);
    // If the execution works properly
    if(mysqli_stmt_execute($stmt))
    {
        // get the results
        $results = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($results)){
            $m[] = [
                "name"=>$row['name'],
                "id"=>$row['id'],
                "text"=>$row['text'],
                "post_date"=>$row['post_date'],
                "likes"=>$row['likes'],
                "reply_to"=>$row['reply_to']
                //"links"=>$mylink
            ];
        }
    }
    echo json_encode($m);
});

$router->register('#^/list/#', "GET",function($params){
    // registers list all
    require_once "includes/dbh.inc.php";
    $conn = mysqli_connect($DB_HOST, $DB_PASSWORD, $DB_NAME);
    $query = 'SELECT * FROM Post where reply_to is NULL order by post_date DESC';
    $results = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($results)) {
        $id = $row['id'];
        $mylink = "api/list/$id";
        $m[] = [
            "name"=>$row['name'],
            "id"=>$row['id'],
            "text"=>$row['text'],
            "post_date"=>$row['post_date'],
            "likes"=>$row['likes'],
            "reply_to"=>$row['reply_to'],
            "links"=>$mylink
        ];
    }
    echo json_encode($m);
});
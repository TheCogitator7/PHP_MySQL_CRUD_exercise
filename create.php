<?php 
    $link=mysqli_connect('localhost', 'port12345', 'ca11com1!');
    if(!$link){
        echo "Not connected".mysqli_error($link);
    }

    $selected_DB=mysqli_select_db($link, 'port12345');
    if(!$selected_DB){
        echo "Not selected the DB".mysqli_error($selected_DB);
    }

    $sql="SELECT * FROM topic";
    $result=mysqli_query($link, $sql);
    $list='';
    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $filtered_title=htmlspecialchars($row['title']);
        $list=$list."<li><a href='index.php?id={$row['id']}'>{$filtered_title}</a></li>";
    }
    
    $article['title']="Welcome";
    $article['description']="Hello, PHP";
    $article['date']="2023-11-30";

    if(isset($_GET['id'])){
        $filtered_id=mysqli_real_escape_string($link, $_GET['id']);
        $sql="SELECT * FROM topic WHERE id={$filtered_id}";
        $result=mysqli_query($link, $sql);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
        $article['title']=$row['title'];
        $article['description']=$row['description'];
        $article['date']=$row['date'];
    }
?>

<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WEB</title>
    </head>
    <body>
        <h1><a href="index.php">WEB</a></h1>
        <ol>
            <?=$list ?>
        </ol>
        <form action="process_create.php" method="post">
            <p><input type="text" name="title" placeholder="title"></p>
            <p><textarea type="text" name="description" placeholder="description"></textarea></p>
            <p><input type="submit"></p>
        </form>
    </body>
</html>
<?php 
    $link=mysqli_connect('localhost', 'port12345', 'ca11com1!');
    if(!$link){
        echo "Not connected".mysqli_error($link);
    }

    $selected_DB=mysqli_select_db($link, 'port12345');
    if(!$selected_DB){
        echo "Not selected the DB".mysqli_error($selected_DB);
    }
?>

<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WEB</title>
        <style>
            table, th, td{
                border:1px solid black;
            }
        </style>
    </head>
    <body>
        <h1><a href="author.php">Author list</a></h1>
        <h2><a href="index.php">Topic</a></h2>
        <table>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>profile</th>
                <th></th>
            </tr>
            <?php 
                $sql="SELECT * FROM author";
                $result=mysqli_query($link, $sql);
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    $filtered=array(
                        'id'=>htmlspecialchars($row['id']),
                        'name'=>htmlspecialchars($row['name']),
                        'profile'=>htmlspecialchars($row['profile'])
                    );
            ?>
            <tr>
                <td><?=$filtered['id'] ?></td>
                <td><?=$filtered['name'] ?></td>
                <td><?=$filtered['profile'] ?></td>
                <td><a href="author.php?id=<?=$filtered['id'] ?>">Update</a></td>
                <td><form action="process_delete_author.php" method="post">
                    <input type="hidden" name="id" value="<?=$filtered['id'] ?>">
                    <input type="submit" value="Delete">
                </form></td>
                <?php } ?>
            </tr>
        </table>
        <?php 
            $action_label='process_create_author.php';
            $value_label='Create author';
            $article['name']='';
            $article['profile']='';

            if(isset($_GET['id'])){
                $filtered_id=mysqli_real_escape_string($link, $_GET['id']);
                $sql="SELECT * FROM author WHERE id={$filtered_id}";
                $result=mysqli_query($link, $sql);
                $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
                $article['name']=htmlspecialchars($row['name']);
                $article['profile']=htmlspecialchars($row['profile']);

                $action_label='process_update_author.php';
                $value_label='Update author';
            }
        ?>
        <form action="<?=$action_label ?>" method="post">
            <input type="hidden" name="id" value="<?=$_GET['id'] ?>">
            <p><input type="text" name="name" placeholder="name" value="<?=$article['name'] ?>"></p>
            <p><textarea type="text" name="profile" placeholder="porfile"><?=$article['profile'] ?></textarea></p>
            <p><input type="submit" value="<?=$value_label ?>"></p>
        </form>
    </body>
</html>
<?php
$instanceDB = new PDO(
    "mysql:host=localhost;dbname=ukolnicek;charset=utf8mb4",
    "root",
    "",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);
$prikaz = $instanceDB->prepare("SELECT * FROM ukol");
$prikaz->execute(array());

$poleUkolu = $prikaz->fetchAll(PDO::FETCH_ASSOC);

if(array_key_exists("submit-task",$_POST)){
    $task = $_POST["task"];
    $taskPrikaz = $instanceDB->prepare("INSERT INTO ukol set popis_ukolu=?");
    $taskPrikaz->execute(array($task));
    header("Location: ?");
    exit;
}
if(array_key_exists("remove-task",$_GET)){
    $taskId = $_GET["remove-task"];
    $taskPrikaz = $instanceDB->prepare("DELETE FROM ukol WHERE id_ukolu=?");
    $taskPrikaz->execute(array($taskId));
    header("Location: ?");
    exit;
}

if(array_key_exists("remove-all-taks",$_POST)){
    $taskPrikaz = $instanceDB->prepare("DELETE FROM ukol");
    $taskPrikaz->execute(array());
    header("Location: ?");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Waiting+for+the+Sunrise&display=swap" rel="stylesheet">
    <title>TO-DO-LIST</title>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <h1>TO-DO LIST</h1>
            <div class="input-box">
                <form action="" method="post" id="add">
                    <input type="text" name="task" id="task" placeholder="Example:Make dishes...">
                    <input type="submit" name="submit-task" value="Add task">
                </form>
            </div>
            <ul>
                <?php
                    foreach ($poleUkolu as $ukol) {
                        echo "<div class='listContainer'>";
                        echo "<li>{$ukol["popis_ukolu"]}</li>";
                        echo "<a href=?remove-task={$ukol["id_ukolu"]}>Remove</a>";
                        echo "</div>";
                    }
                    ?>
            </ul>
            <form action="" method="post" id="remove">
                <input type="submit" name="remove-all-tasks" value="Remove all">
            </form>
        </div>
    </div>

</body>

</html>
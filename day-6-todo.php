
<?php

$Error_message ='';

    //Connecting to the database
    $todo_list =  mysqli_connect('localhost','root','','todo_list');

    /*testing if the submit button has been click for a new task to be 
to be inputed.
    */
    if(isset($_POST['submit'])){

        #declearing variable for task (this varriable collect the task form the input box and saves in the database).
        $task = $_POST['task'];

            #carring out present check to ensure that a user does not creat and empty task
            if(empty($task)){
                 $Error_message = "Sorry! You must fill in a task";
            
                }else{
            #Saving user input (task) in the database.
                 mysqli_query($todo_list,"INSERT INTO tasks (task) VALUES ('$task')");
            
            #To prevent user redirection to a null page.
                 header('location: To_Do_list.php');
                }
        
    }
    
        #Creating varriable for tasks which will enable data saved in the database to be represented on a form.
        $tasks = mysqli_query($todo_list,"SELECT * FROM tasks");

        #Deleting Data on the form
        if(isset($_GET['del_task'])){
            $ID = $_GET['del_task'];
            mysqli_query($todo_list,"DELETE FROM tasks WHERE ID=$ID");
            header('location: To_Do_list.php');
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPLE-TO-DO-LIST-WEB-APPLICATION</title>

   <style>

    body{
        background:white;
    }
   // .contianer{
        background-color:gray;
        padding: 20px;
        width:900px;
        margin:30px auto;
    }
    .heading{
        width:50%;
        margin:30px auto;
        text-align:center;
        color:white;
        background:black;
        border:2px solid  rgba(245, 245, 245, 0.74);
        border-radius:20px;
        box-shadow:5px 5px 5px black;
        text-shadow: -2px 2px 20px rgba(245, 245, 245, 0.74);
    }

    form{
        width: 45%;
        margin:30px auto;
        border-radius:10px;
        padding:10px;
        background:grey;
        border:1px solid rgba(245, 245, 245, 0.74);
    }
    .task-input{
        width:373px;
        height:15px;
        padding:10px;
        border:2px solid black;
        border-style:groove;
        border-radius:5px;
        padding:5px 20px;
        font-weight:bold;
    }
    .task-btn{
        height:39px;
        background:black;
        color:white;
        border:2px solid rgba(245, 245, 245, 0.74);
        border-radius:5px;
        padding:5px 20px;
        box-shadow:3px 3px 5px black;
        font-weight:bold;
        letter-spacing:2px;
        text-transform:uppercase;
        transition:10ms;
    }
    .task-btn:active{
        color:green;
    }
    table{
        width:49%;
        margin: 30px auto;
    }
    tr{
        border-bottom:1px solid black;
        border-left:1px solid black;
    }
    th{
        font-size:19px;
        text-transform:uppercase;
    }
    th,td{
        border:none;
        height:30px;
        padding:px;
        font-size:19px;
    }
    td input{
        
    }
    tr:hover{
        background:gray;
    }
    .task{
        text-align:center;
    }
    .delete{
        text-align:center;
    }
    .delete a{
        background:red;
        padding:6px;
        border-radius:7px;
        text-decoration:none;
        font-weight:bold;
        color:black;
    }
    form p{
        color:red;
        margin:0px;
        font-weight:bold;
        letter-spacing:1px;
    }
    
   </style>
</head>
<body>

<!--setting up the mian contianer -->
    <div class="contianer">

    <!-- setting up the title bar -->
<div class="heading">
    <h2>TODO LIST APPLICATION WITH PHP AND MYSQL</h2>
</div>

<!-- seeting up the form which will accept user input -->
<form action="To_Do_list.php" method="post">

<!-- to display error message when task is not typed In -->
    <?php if(isset($Error_message)) { ?>
        <p><?php echo $Error_message;?> </p>
    <?php }?>

    <input type="text" name="task" class="task-input">
    <button type="submit" class="task-btn" name="submit">Add Task</button>

</form>

<!-- setting up the table where user input will be represented-->
<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Task</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>

    <!-- creating a new variable to fetch data from database (note that this data are save and considered as arrays in the database -->
     <?php $i =1; while($row = mysqli_fetch_array($tasks)) { ?>
        <tr>
            <!-- the first td normaly should get its numbering form the database,
                  but that numbering will afect the way data is numbered when a task is created,
                  then deleted the numbering the task that remain will not change, thus we set an
                  itirration: no longer taking the numbering fro the id row in the database ( $row['ID']; )
                  but now creating a number systerm which increases by one anytime a new a new task is added
                  and vice versal.-->

            <td> <?php echo $i; ?> </td>
            <td class="task"> <?php echo $row['Task'];  ?> </td>
            <td class="delete"><a href="To_Do_list.php?del_task=<?php echo $row['ID'] ?>">X</a></td>
        </tr>
        <?php $i++;} ?>

    </tbody>
</table>
</div>
</body>
</html>



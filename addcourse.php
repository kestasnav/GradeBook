<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    }
    include("dblogin.php");
    
   
    $error = [];
    if (isset($_POST['action']) && $_POST['action'] == 'insert') { 
      $pvd = test_input($_POST["title"]);   
   
    
      if(empty($pvd)) {
        $error['title'] = "Pavadinimas privalomas";
      }      
      

if(empty($error)){
        $sql="INSERT INTO kursai (title) VALUES (?)";
        $stm=$pdo->prepare($sql);
        $stm->execute([ $_POST['title']]);
        header("location:pazymiai.php");
        die();
    }
   
    }
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naujo kurso sukūrimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5 mb-5">
                    <div class="card-header">Pridėti naują kursą</div>
                    <div class="card-body">
                        
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="insert"> 
                            <div class="mb-3">
                                <label for="" class="form-label">Kurso pavadinimas</label>
                                <input name="title" type="text" class="form-control" >
                             
                          
                                <?php if (isset($error['title'])){ echo'<div class="alert alert-danger w-25 text-center">'. $error['title'].'</div>';}?>
                                                        
                            </div>
                          
                           
                            <button class="btn btn-success">Pridėti</button>
                            <a href="pazymiai.php" class="btn btn-info float-end">Atgal</a>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

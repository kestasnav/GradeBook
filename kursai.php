<?php
include("dblogin.php");

$lectures="SELECT *, p.title as paskaitos, p.id as PID FROM paskaitos p
WHERE p.kursu_id=?";
$result=$pdo->prepare($lectures);
$result->execute([$_GET['id']]);
$paskaitos=$result->fetchAll(PDO::FETCH_ASSOC);

$res=$pdo->prepare("SELECT * FROM kursai WHERE id=?");
$res->execute([$_GET['id']]);
$kursas=$res->fetchAll(PDO::FETCH_ASSOC);

/* paskaitos pridejimas */
if (isset($_POST['action']) && $_POST['action']=='insert'){  
    $id = $_GET['id'];
    
$sql="INSERT INTO paskaitos (kursu_id, title) VALUES (?,?)";
$stm=$pdo->prepare($sql);
$stm->execute([ $id, $_POST['title']]);
header("location:kursai.php?id=$id");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurso paskaitų kortelė</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style type="text/css">
.curr {
	text-align: right;
}
</style>
</head>
<body>
<div class="container" id="content" tabindex="-1">
	<a class="btn btn-primary mt-3" href="pazymiai.php">Grįžti į studentų ir kursų sąrašą</a>
        
 <div class="col-md-6">
                <div class="card mt-5">
                <?php foreach($kursas as $kur){  ?>
                    <div class="card-header"><b><?=$kur['title']?></b> kurso paskaitų sąrašas</div>
                    <?php } ?>
                    <div class="card-body">
                     
                        <table class="table">
                            <thead>                            
                        
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="insert"> 
                            <div class="mb-3">
                                <label for="" class="form-label">Pridėti naują paskaitą</label> <button class="btn btn-success mb-1">Pridėti</button>
                                <input name="title" value="<?=$kur['title']?>/" type="text" placeholder="Paskaitos pavadinimas" class="form-control w-50" >
                                                          
                                <?php if (isset($error['title'])){ echo'<div class="alert alert-danger w-25 text-center">'. $error['title'].'</div>';}?>
                                                        
                            </div>                          
                           
                            
                          
                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
                                <tr class="text-center">
                                    <th>Paskaitų pavadinimas</th>
                                    <th></th>                                                                                                   
                                </tr>
                            </thead>
                            <tbody>
                            
                             <?php foreach($paskaitos as $paskaita){  ?>  
                                <tr class="text-center">             
                                    <td><?=$paskaita['paskaitos']?></td>
                                   
                                    <td><td><a class="btn btn-success" href="paskaita.php?id=<?=$paskaita['PID']?>">Detaliau</a></td>
                                <?php }  ?> 
                                </tr>
                                
                            </tbody>
                        </table>
                        </div>
			</div>

			</div>
            
            </div>
    
    </body>
    </html>
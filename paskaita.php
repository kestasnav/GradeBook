<?php

include("dblogin.php");

/* paskaitos */
$kursas="SELECT p.title as paskaitos, s.name as name, s.surname as surname, s.id as SID
FROM paskaitos_kursai ps  
LEFT JOIN studentai s ON s.id=ps.student_id
LEFT JOIN paskaitos p ON p.id=ps.paskaitos_id

WHERE ps.paskaitos_id=?";
$result=$pdo->prepare($kursas);
$result->execute([$_GET['id']]);
$kursai=$result->fetchAll(PDO::FETCH_ASSOC);

/* prideti pazymi */

 if (isset($_GET['id'])){if (isset($_POST['action']) && $_POST['action']=='insert'){   
     $studentoID = $_POST['studentID'];
    $paskaitosID = $_GET['id'];
    $sql="INSERT INTO pazymiai (grade, student_id, paskaitos_id) VALUES (?, ?, ?)";
    $stm=$pdo->prepare($sql);
    $stm->execute([ $_POST['grade'], $studentoID, $paskaitosID]);
   
    header("location:paskaita.php?id=$paskaitosID");
    die();
    
}

  $sql="SELECT * FROM pazymiai";
    $stm=$pdo->prepare($sql);
    $stm->execute([]);
    $studentoKursai=$stm->fetchAll(PDO::FETCH_ASSOC);
  }else{
    header("location:paskaita.php?id=$paskaitosID");
    die();
  } 

  /* prideti lankomuma */

  if (isset($_GET['id'])){if (isset($_POST['action']) && $_POST['action']=='insert'){   
    $studentoID = $_POST['studentID'];
   $paskaitosID = $_GET['id'];
   $sql="INSERT INTO lankomumas (student_id, paskaitos_id, dalyvavimas) VALUES (?, ?, ?)";
   $stm=$pdo->prepare($sql);
   $stm->execute([ $studentoID, $paskaitosID, $_POST['lankomumas']]);
  
   header("location:paskaita.php?id=$paskaitosID");
   die();
   
}

 $sql="SELECT * FROM lankomumas";
   $stm=$pdo->prepare($sql);
   $stm->execute([]);
   $studentoKursai=$stm->fetchAll(PDO::FETCH_ASSOC);
 }else{
   header("location:paskaita.php?id=$paskaitosID");
   die();
 }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studento kortelė</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style type="text/css">
.curr {
	text-align: right;
}
</style>
</head>
<body>
<div class="container" id="content" tabindex="-1">
	<a class="btn btn-primary mt-3" href="pazymiai.php">Grįžti į studentų sąrašą</a>
		<div class="row">
	
				<div class="card mt-3">
				
				<div class="card-header">
                    
					<h1><?=$kursai[0]['paskaitos']?> paskaitos studentų sąrašas</h1>
				</div>		
			
    <!-- studento pazymiai lankomumas -->
    
				<div class="col-md-8">
					
                   
					<table class="table  table-hover">
                    
                    <thead>
                        
                        <tr class="text-center">
                          
                                    
                                    <th>Studentas</th>
                                    <th>Pažymys</th> 
                                    <th>Ar dalyvavo paskaitoje</th> 
                                                                                                                        
                                </tr>                               
                            </thead>
                            <tbody>  
                                <form action="" method="POST">
                                <input type="hidden" name="action" value="insert"> 
                                <?php foreach($kursai as $paskaita){ ?>
                                    <tr class="text-center">
                                       <td><input type="hidden" name="studentID" value="<?=$paskaita['SID']?>"> <?=$paskaita['name'] ?> <?=$paskaita['surname'] ?></td>                             
                                        <td><input type="number" name="grade" class="form-control text-center"></td>
                                      <td>     
                                                                 
                                <select name="lankomumas" class="form-control mb-3">
                                    <option value="Taip">Taip</option>
                                    <option value="Ne">Ne</option>
                                     </select>       
                                     </td>
                                </tr>
                                
                                 <?php } ?>
                                
                           </tbody>
                       </table>	
                       <button class="btn btn-success float-end mb-2">Patvirtinti</button>
                                </form>			
				</div>
			</div>

			</div>
			
		</div>
</div>
	</div>
    
</body>
</html>
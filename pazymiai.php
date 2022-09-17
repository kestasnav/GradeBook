<?php

include("dblogin.php");
/* studentai */
$students="SELECT * FROM studentai ORDER BY surname ASC"; 
/*LEFT JOIN paskaitos_kursai ps ON ps.student_id=studentai.id 
LEFT JOIN paskaitos ON paskaitos.id=ps.paskaitos_id 
LEFT JOIN kursai ON kursai.id=paskaitos.kursu_id */
/* LEFT JOIN pazymiai ON paskaitos.id=pazymiai.paskaitos_id 
 LEFT JOIN lankomumas ON ps.student_id=lankomumas.student_id*/

$result=$pdo->query($students);
$studentai=$result->fetchAll(PDO::FETCH_ASSOC);
/* kursai */

$course="SELECT *, kursai.title as kursai FROM kursai";
$result=$pdo->query($course);
$kursai=$result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darbuotojo kortelė</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style type="text/css">
.curr {
	text-align: right;
}
</style>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header"><b>Studentų sąrašas</b></div>
                    
                    <div class="card-body">
	
                        <table class="table">
                            <thead>
                            <span><a href="addstudent.php" class="btn btn-warning">Pridėti naują studentą</a></span><hr>
                                <tr class="text-center">
                                    <th>Vardas</th>
                                    <th>Pavardė</th>
                                    <th></th>
                                  <!--  <th>Kursas</th>
                                     <th>Paskaita</th>  -->                                                                 
                                </tr>
                            </thead>
                            <tbody>
                            
                             <?php foreach($studentai as $studentas){  ?>  
                                <tr class="text-center">             
                                    <td><?=$studentas['name']?></td>
                                    <td><?=$studentas['surname']?></td>
                                <!--    <td><?=($studentas['kursas']==true)?$studentas['kursas']:'Studentas nesimoko jokiame kurse'?></td>
                                    <td><?=($studentas['kursas']==true)?$studentas['paskaita']:'Studentas nesimoko paskaituose'?></td>  -->                                
                                   <td><td><a class="btn btn-success" href="studentas.php?id=<?=$studentas['id']?>">Detaliau</a></td>
                                <?php }  ?> 
                                </tr>
                               
                            </tbody>
                        </table>
                        </div>
			</div>

			</div>
			
		
        <!-- Kursu sarasas -->
        
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header"><b>Kursų sąrašas</b></div>
                    <div class="card-body">
	
                        <table class="table">
                            <thead>
                            <span><a href="addcourse.php" class="btn btn-warning">Pridėti naują kursą</a></span><hr>
                                <tr class="text-center">
                                    <th>Kursų pavadinimas</th> 
                                    <th></th>                                                                                                  
                                </tr>
                            </thead>
                            <tbody>
                            
                             <?php foreach($kursai as $kursas){  ?>  
                                <tr class="text-center">             
                                    <td><?=$kursas['kursai']?></td>
                                    <td><td><a class="btn btn-success" href="kursai.php?id=<?=$kursas['id']?>">Detaliau</a></td>
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
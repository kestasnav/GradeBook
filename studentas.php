<?php

include("dblogin.php");
/* studentai */
$studentas="SELECT s.name as name, s.surname as surname FROM studentai s
WHERE s.id=?";
$result=$pdo->prepare($studentas);
$result->execute([$_GET['id']]);
$studentai=$result->fetchAll(PDO::FETCH_ASSOC);

/* kursai */
$kursas="SELECT k.title as kursas, p.title as paskaitos, u.destytojas as destytojas
FROM paskaitos_kursai ps  
LEFT JOIN paskaitos p ON p.id=ps.paskaitos_id
LEFT JOIN kursai k ON k.id=p.kursu_id
LEFT JOIN users u ON u.id=k.destytojo_id
WHERE ps.student_id=?";
$result=$pdo->prepare($kursas);
$result->execute([$_GET['id']]);
$kursai=$result->fetchAll(PDO::FETCH_ASSOC);

/* pazymiai */
 $pazymiai="SELECT pz.grade as grades, p.title as paskaitos 
 FROM pazymiai pz 
 LEFT JOIN paskaitos p ON p.id=pz.paskaitos_id WHERE pz.student_id=?;";
$result=$pdo->prepare($pazymiai);
$result->execute([$_GET['id']]);
$pazymiai=$result->fetchAll(PDO::FETCH_ASSOC);  

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
                    
					<h1><?=$studentai[0]['name']?> <?=$studentai[0]['surname']?></h1>
				</div>
				<div class="card-body">
				<div class="col-md-6 d-flex flex-row">				
			
			</div> 
				</div>
			</div>
		</div>
			
					<div class="row">
			<div class="card mt-5 mb-5">
			

				<div class="card-body">
				<div class="col-md-8">
					<div class="card-header"><b>Kursas(-ai): </b></div>
                   
					<table class="table  table-hover">
                    
                    <thead>
                        
                        <tr class="text-center">
                            <?php foreach($kursai as $kursas){ ?>
                                    
                                    <th><?=$kursas['kursas']?> (<?=$kursas['destytojas']?>)</th>
                                    
                                    <?php } ?>                                                                                        
                                </tr>                               
                            </thead>
                            <tbody>  
                                <tr class="text-center">
                                <?php foreach($kursai as $kursas){ ?>
                                    
                                    <td><?=$kursas['paskaitos']?></td> 
                                    
                                    <?php } ?>    

                                </tr>
                           </tbody>
                       </table>				
				</div>
			</div>

			</div>
			
		</div>

    <!-- studento pazymiai lankomumas -->
    <div class="row">
			<div class="card mt-5 mb-5">
			

				<div class="card-body">
				<div class="col-md-8">
					<div class="card-header"><b>Paskaitos: </b></div>
                   
					<table class="table  table-hover">
                    
                    <thead>
                        
                        <tr class="text-center">
                          
                                    
                                    <th>Paskaita</th>
                                    <th>Pažymys</th> 
                                    <th>Lankomumas</th> 
                                                                                                                        
                                </tr>                               
                            </thead>
                            <tbody>  
                                
                                <?php foreach($pazymiai as $pazymys){ ?>
                                    <tr class="text-center">
                                       <td><?=$pazymys['paskaitos'] ?></td>                             
                                        <td><?=($pazymys['grades'] == true)?$pazymys['grades']:'Studentas negavo pažymio'?></td>
                                        <td></td>
                                </tr>
                                <?php } ?>  
                           </tbody>
                       </table>				
				</div>
			</div>

			</div>
			
		</div>
</div>
	</div>
    
</body>
</html>
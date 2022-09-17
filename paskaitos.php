<?php

$lectures="SELECT *, paskaitos.title as paskaitos FROM paskaitos";
$result=$pdo->query($lectures);
$paskaitos=$result->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Paskaitų sarasas -->
        
 <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header"><b>Pasktaitų sąrašas</b></div>
                    <div class="card-body">
	
                        <table class="table">
                            <thead>
                            <span><a href="addcourse.php" class="btn btn-warning">Pridėti naują paskaitą</a></span><hr>
                                <tr class="text-center">
                                    <th>Paskaitų pavadinimas</th>
                                    <th></th>                                                                                                   
                                </tr>
                            </thead>
                            <tbody>
                            
                             <?php foreach($paskaitos as $paskaita){  ?>  
                                <tr class="text-center">             
                                    <td><?=$paskaita['paskaitos']?></td>
                                    <td><td><a class="btn btn-success" href="paskaita.php?id=<?=$paskaita['id']?>">Priskirti paskaitą</a></td>
                                <?php }  ?> 
                                </tr>
                                
                            </tbody>
                        </table>
                        </div>
			</div>

			</div>
<?php

include("dblogin.php");
/* studentai */
$studentas = "SELECT s.name as name, s.surname as surname, k.title as kursas, k.id as kurID, u.destytojas as destytojas, ps.kursu_id as KID FROM studentai s
LEFT JOIN paskaitos_kursai ps on s.id=ps.student_id
LEFT JOIN kursai k on ps.kursu_id=k.id
LEFT JOIN users u ON u.id=k.destytojo_id
WHERE s.id=?";
$result = $pdo->prepare($studentas);
$result->execute([$_GET['id']]);
$studentai = $result->fetchAll(PDO::FETCH_ASSOC);

/* pazymiai */
$pazymiai = "SELECT pz.grade as grades, p.title as paskaitos, pz.lankomumas as lankomumas
 FROM pazymiai pz 
 LEFT JOIN paskaitos p ON p.id=pz.paskaitos_id WHERE pz.student_id=?;";
$result = $pdo->prepare($pazymiai);
$result->execute([$_GET['id']]);
$pazymiai = $result->fetchAll(PDO::FETCH_ASSOC);

/* studentui priskirti kursa */

/* paskaitos */
$sql = "SELECT p.title as paskaitos, ps.kursu_id as KID
FROM paskaitos p  
LEFT JOIN paskaitos_kursai ps ON ps.kursu_id=p.kursu_id
WHERE ps.kursu_id ";
$result = $pdo->prepare($sql);
$result->execute();
$paska = $result->fetchAll(PDO::FETCH_ASSOC);

$paskaitos=[];
foreach($paska as $psk){
    $paskaitos[$psk['KID']][]=$psk;
}

if (isset($_GET['id'])) {
    if (isset($_POST['action']) && $_POST['action'] == 'insert') {
        $studentoID = $_GET['id'];

        $sql = "INSERT INTO paskaitos_kursai (student_id, kursu_id) VALUES (?, ?)";
        $stm = $pdo->prepare($sql);
        $stm->execute([$studentoID, $_POST['kursu_id']]);

        header("location:studentas.php?id=$studentoID");
        die();
    }

    $sql = "SELECT * FROM kursai";
    $stm = $pdo->prepare($sql);
    $stm->execute([]);
    $studentoKursai = $stm->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("location:studentas.php?id=$studentoID");
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

                    <h1><?= $studentai[0]['name'] ?> <?= $studentai[0]['surname'] ?></h1>
                </div>
                <div class="card-body">
                    <div class="col-md-6 d-flex flex-row">
                        <form action="" method="POST">
                            <input type="hidden" name="action" value="insert">

                            <div class="mb-3">
                                <label for="" class="form-label">Pridėti studentui kursus: <button class="btn btn-success">Pridėti</button></label>
                                <select name="kursu_id" class="form-control mb-3">
                                    <?php foreach ($studentoKursai as $sk) { ?>

                                        <option value="<?= $sk['id'] ?>"><?= $sk['title'] ?></option>
                                    <?php } ?>
                                </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card mt-2 mb-2">


                <div class="card-body">
                    <div class="col-md-8">
                        <div class="card-header"><b>Kursas(-ai): </b></div>

                        <table class="table  table-hover">

                            <thead>
                               

                                    <?php

                                   
                                    foreach ($studentai as $kursas) { ?>
                                         <tr>
                                        <th><?= $kursas['kursas'] ?> (<?= $kursas['destytojas'] ?>)</th>



                                </tr>
                                
                            </thead>
                            <tbody>
                                <?php 
                                /*  paskaitos 
                                        $sql = "SELECT p.title as paskaitos, ps.kursu_id as psid
                                                    FROM paskaitos p  
                                                    LEFT JOIN kursai k ON k.id=p.kursu_id 
                                                    LEFT JOIN paskaitos_kursai ps ON k.id=p.kursu_id
                                                    WHERE ps.student_id=?";
                                        $result = $pdo->prepare($sql);
                                        $result->execute([$kursas['KID']]);
                                        $paskaitos = $result->fetchAll(PDO::FETCH_ASSOC); */

                                        foreach ($paskaitos[$kursas['KID']] as $paskaita) {
                                          
                                            ?>
                                        
                                    <tr>
                                        <td colspan="4"><?= $paskaita['paskaitos']?><br></td>

                                    <?php } ?>
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
            <div class="card mb-2">


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

                                <?php foreach ($pazymiai as $pazymys) { ?>
                                    <tr class="text-center">
                                        <td><?= $pazymys['paskaitos'] ?></td>
                                        <td><?= ($pazymys['grades'] == true) ? $pazymys['grades'] : 'Studentas negavo pažymio' ?></td>
                                        <td><?= $pazymys['lankomumas'] ?></td>
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
<?php
    $akcija_pregled = $conn->prepare("select * from akcije where id_akcije = :idakcije");
    $akcija_pregled->execute(array(':idakcije' => $_GET['id_akcije']));
    while($akcija_pregled_output = $akcija_pregled->fetch()){
        echo '<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header h1-proizvod pull-left">'.$akcija_pregled_output['naslov_akcije'].'</h1>
                <div class="cena-proizvoda pull-right">';
                if($akcija_pregled_output['status']=='0'){
                    echo 'AKCIJA VISE NIJE U PONUDI!';
                }elseif(!empty($akcija_pregled_output['cena_akcije'])){
                echo $akcija_pregled_output['cena_akcije'].''.$valuta;
                }elseif (empty($akcija_pregled_output['cena_akcije'])) {
                    echo 'Pozovite ze cenu';
                }
                

                echo '</div>
            </div>
        </div>

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-4">
                <img class="img-responsive" src="'.$url.$akcija_pregled_output['slika'].'" alt="'.$akcija_pregled_output['naslov_akcije'].'">
            </div>

            <div class="col-md-8">
                <h3 class="h3-opis-proizvoda">Opis akcije</h3>
                <p>'.$akcija_pregled_output['opis'].'</p>
            </div>

        </div>

        ';
    }

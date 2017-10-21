                    <div class="main col-lg-7 col-md-7">
                        <?php
                        // Po ovom fajlu je moguce dodavati jos stranice, takodje i uredjivati main dao na stranici.
                        if(!empty($_GET['id_pkat'])){
                            include_once 'podkategorija.php';
                        }elseif(!empty($_GET['id_kat'])){
                            include_once 'kategorija.php';
                        }elseif(!empty($_GET['id_proiz'])){
                            include_once 'proizvod.php';
                        }elseif (!empty($_GET['id_ppkat'])) {
                            include_once 'ppkategorija.php';
                        }elseif (!empty($_GET['id_akcije'])) {
                            include_once 'akcija.php';
                        }elseif(!empty($_GET['404'])){
                            include_once '404.php';
                        }elseif($_GET['page']=="kontakt"){
                            include_once 'kontakt.php';
                        }elseif($_GET['page']=="akcija"){
                            include_once 'akcija.php';
                        }elseif($_GET['page']=="akcije"){
                            include_once 'akcije.php';
                        }elseif($_GET['page']=="kako-do-nas"){
                            include_once 'kako_do_nas.php';
                        }elseif(empty($_GET)){
                            include_once 'pocetna.php';
                        }
                        ?>
                    </div>
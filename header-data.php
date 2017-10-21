   <?php
   function mb_ucfirst($string, $encoding = "UTF-8"){
       $strlen = mb_strlen($string, $encoding);
      $firstChar = mb_substr($string, 0, 1, $encoding);
      $then = mb_substr($string, 1, $strlen - 1, $encoding);
      return mb_strtoupper($firstChar, $encoding) . $then;
   }
   function opis($opis){
      $opis_bez_html_tagova = strip_tags($opis);
      $opis_za_meta = substr($opis_bez_html_tagova, 0, 160);
      return $opis_za_meta;
   }
   if(!empty($_GET['id_pkat'])){
 	  	$naslov_pkat = $conn->prepare("select * from kat_pkat where id_pkat = :idpkat");
 	  	$naslov_pkat->execute(array(':idpkat' => $_GET['id_pkat']));
 	  	while ($naslov_pkat_output = $naslov_pkat->fetch()) {
         // Pocetak podkategorije 
         echo "<meta name='description' content='".opis($naslov_pkat_output["opis_pkat"])."'>\n";
 	  		echo '<title>'.mb_ucfirst(mb_strtolower($naslov_pkat_output[ime_pkat], "UTF-8")).'</title>';
         echo '<meta property="og:type"   content="product.group" />
         <meta property="og:url"    content="'.$http_https.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" /> 
         <meta property="og:title"  content="'.$naslov_pkat_output[ime_pkat].'" /> 
         <meta property="og:image"  content="'.$url.str_replace(' ', '%20',$naslov_pkat_output[slika_pkat]).'" /> 
         <meta property="og:description"  content="'.opis($naslov_pkat_output[opis_pkat]).'" />
         <meta name="twitter:card" content="summary" /> 
         <meta name="twitter:image" content="'.$url.str_replace(' ', '%20',$naslov_pkat_output[slika_pkat]).'" />
         <meta name="twitter:description" content="'.opis($naslov_pkat_output[opis_pkat]).'" />
         <meta name="twitter:title" content="'.$naslov_pkat_output[ime_pkat].'" />';
 	  	}
   }elseif(!empty($_GET['id_kat'])){
      $naslov_kat = $conn->prepare("select * from kategorija where id_kat = :idkat");
      $naslov_kat->execute(array(':idkat' => $_GET['id_kat']));
      while ($naslov_kat_output = $naslov_kat->fetch()) {
         // Pocetak kategorije
         echo "<meta name='description' content='".opis($naslov_kat_output["opis_kat"])."'>\n";
         echo '<title>'.mb_ucfirst(mb_strtolower($naslov_kat_output[ime_kat], "UTF-8")).'</title>';
         echo '<meta property="og:type"   content="product.group" /> 
         <meta property="og:url"    content="'.$http_https.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" /> 
         <meta property="og:title"  content="'.$naslov_kat_output[ime_kat].'" /> 
         <meta property="og:image"  content="'.$url.str_replace(' ', '%20',$naslov_kat_output[slika_kat]).'" /> 
         <meta property="og:description"  content="'.opis($naslov_kat_output[opis_kat]).'" />
         <meta name="twitter:card" content="summary" /> 
         <meta name="twitter:image" content="'.$url.str_replace(' ', '%20',$naslov_kat_output[slika_kat]).'" />
         <meta name="twitter:description" content="'.opis($naslov_kat_output[opis_kat]).'" />
         <meta name="twitter:title" content="'.$naslov_kat_output[ime_kat].'" />';
      }
   }elseif(!empty($_GET['id_ppkat'])){
      $naslov_ppkat = $conn->prepare("select * from ppkategorija where id_ppkat = :idppkat");
      $naslov_ppkat->execute(array(':idppkat' => $_GET['id_ppkat']));
      while ($naslov_ppkat_output = $naslov_ppkat->fetch()) {
         // Pocetak pod-podkategorije
         echo "<meta name='description' content='".opis($naslov_ppkat_output["opis_ppkat"])."'>\n";
         echo '<title>'.mb_ucfirst(mb_strtolower($naslov_ppkat_output[ime_ppkat], "UTF-8")).'</title>';
         echo '<meta property="og:type"   content="product.group" /> 
         <meta property="og:url"    content="'.$http_https.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" /> 
         <meta property="og:title"  content="'.$naslov_ppkat_output[ime_ppkat].'" /> 
         <meta property="og:image"  content="'.$url.str_replace(' ', '%20',$naslov_ppkat_output[slika_ppkat]).'" /> 
         <meta property="og:description"  content="'.opis($naslov_ppkat_output[opis_ppkat]).'" />
         <meta name="twitter:card" content="summary" /> 
         <meta name="twitter:image" content="'.$url.str_replace(' ', '%20',$naslov_ppkat_output[slika_ppkat]).'" />
         <meta name="twitter:description" content="'.opis($naslov_ppkat_output[opis_ppkat]).'" />
         <meta name="twitter:title" content="'.$naslov_ppkat_output[ime_ppkat].'" />';
      }
   }elseif(!empty($_GET['id_proiz'])){
      $naslov_proiz = $conn->prepare("select  * from proizvod where id_proiz = :idproiz");
      $naslov_proiz->execute(array(':idproiz' => $_GET['id_proiz']));
      while ($naslov_proiz_output = $naslov_proiz->fetch()) {
         // Pocetak proizvoda
         echo "<meta name='description' content='".opis($naslov_proiz_output[opis_proiz])."'>\n";
         echo '<title>'.mb_ucfirst(mb_strtolower($naslov_proiz_output[ime_proiz], "UTF-8")).'</title>';
         echo '<meta Property="og:description" Content="'.opis($naslov_proiz_output[opis_proiz]).'" />
               <meta name="twitter:card" content="summary" />
               <meta Property="og:image" Content="'.$url.str_replace(' ', '%20', $naslov_proiz_output[slika_proiz]).'" />
               <meta Property="og:type" Content="product" />
               <meta name="twitter:image" content="'.$url.str_replace(' ', '%20', $naslov_proiz_output[slika_proiz]).'" />
               <meta name="twitter:description" content="'.opis($naslov_proiz_output[opis_proiz]).'" />
               <meta name="twitter:site" content="@'.$naslov.'" />
               <meta Property="og:url" Content="'.$http_https.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />
               <meta name="twitter:title" content="'.$naslov_proiz_output[ime_proiz].'" />
               <meta Property="og:title" Content="'.$naslov_proiz_output[ime_proiz].'" />';
      }
   }elseif(!empty($_GET['id_akcije'])){
      $naslov_akcija = $conn->prepare("select  * from akcije where id_akcije = :idakcije");
      $naslov_akcija->execute(array(':idakcije' => $_GET['id_akcije']));
      while ($naslov_akcija_output = $naslov_akcija->fetch()) {
         // Pocetak proizvoda
         echo "<meta name='description' content='".opis($naslov_akcija_output[opis_proiz])."'>\n";
         echo '<title>'.mb_ucfirst(mb_strtolower($naslov_akcija_output[naslov_akcije], "UTF-8")).'</title>';
         echo '<meta Property="og:description" Content="'.opis($naslov_akcija_output[opis]).'" />
               <meta name="twitter:card" content="summary" />
               <meta Property="og:image" Content="'.$url.str_replace(' ', '%20', $naslov_akcija_output[slika]).'" />
               <meta Property="og:type" Content="product" />
               <meta name="twitter:image" content="'.$url.str_replace(' ', '%20', $naslov_akcija_output[slika]).'" />
               <meta name="twitter:description" content="'.opis($naslov_akcija_output[opis]).'" />
               <meta name="twitter:site" content="@'.$naslov.'" />
               <meta Property="og:url" Content="'.$http_https.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />
               <meta name="twitter:title" content="'.$naslov_akcija_output[naslov_akcije].'" />
               <meta Property="og:title" Content="'.$naslov_akcija_output[naslov_akcije].'" />';
      }
   }elseif($_GET['page']=='kako-do-nas'){
      echo '<title> Kako do nas</title>';

   }elseif($_GET['page']=='kontakt'){
      echo '<title> Kontakt</title>';

   }elseif(!empty($_GET['404'])){
      // Pocetak 404 stranice
         echo "<meta name='description' content='404'>\n";
         echo '<title>404</title>';
   }elseif(empty($_GET)){
      // Pocetak naslovne strane
         echo "<meta name='description' content='".$opis."'>\n";
         echo '<title>'.mb_ucfirst(mb_strtolower($naslov, "UTF-8"))."</title>\n";
  }
         if(!empty($google_site_verification)){
         echo '<meta name="google-site-verification" content="'.$google_site_verification.'" />';
         }
         if(!empty($fb_app_id)){
         echo '<meta Property="fb:app_id" content="'.$fb_app_id.'" />';
         }
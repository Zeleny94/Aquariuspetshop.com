    <!-- Navigation -->
   <nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid navbar-border">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li <?php if(empty($_GET)) echo 'class="active"'; ?>><a href="<?php echo $url; ?>">Pocetna</a></li>
        <?php
        $kat_upit = $conn->query("SELECT * FROM kategorija");
        while($kat_output = $kat_upit->fetch()){                       
        echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$kat_output[ime_kat].' <span class="caret"></span></a>';
        echo '<ul class="dropdown-menu" role="menu">';
        $pkat_upit = $conn->prepare("select * from podkategorija where id_kat = :idkat");
        $pkat_upit->execute(array(':idkat' => $kat_output[id_kat]));
        while($pkat_output = $pkat_upit->fetch()){
            $link_menu_podkategorija = new linkovanje();
            echo '<li><a href="'.$link_menu_podkategorija->getLink($url.$kat_output['ime_kat'].'/'.$pkat_output['ime_pkat'].'/'.$pkat_output['id_pkat']).'"> &#10151;&nbsp;&nbsp;'.$pkat_output[ime_pkat].'</a></li>';
        }
        echo '</ul>';
        echo '</li>';
        }
    ?>
      </ul>
       <ul class="nav navbar-nav navbar-right">
        <li <?php if($_GET['page']=='kontakt') echo 'class="active"'; ?> ><a href="<?php echo $url ?>kontakt">Kontakt</a></li>
        <li <?php if($_GET['page']=='kako-do-nas') echo 'class="active"'; ?> ><a href="<?php echo $url ?>kako-do-nas">Gde se nalazimo</a></li>
        <li><a href="<?php echo $fburl ?>"><i class="fa fa-facebook color-facebook"></i></a></li>
        </ul>
        
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
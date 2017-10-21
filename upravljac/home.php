<?php
  if(isset($_POST['submit'])){
    header('Refresh:2');
}
  include_once("../konfiguracija.php");
  include_once("../konekcija.php");
	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript">
  tinymce.init({
    selector: 'textarea',
    language_url : '<?php echo $url; ?>upravljac/langs/tinymce/sr.js',
  theme: 'modern',  
  relative_urls : false,
  remove_script_host : false,

  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });
</script>
<title>welcome - <?php echo $userRow['user_email']; ?></title>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Navigacija za mobilne uredjaje</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="font-size-adjust: 23px;"><?php echo mb_strtoupper ($naslov, "UTF-8"); ?> ADMIN PANEL</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          
            <li <?php if(empty($_GET['upravljac-page'])) { echo 'class="active"';} ?>><a href="home.php">Pocetna</a></li>
            <li <?php if($_GET['upravljac-page']=="kategorije") { echo 'class="active"';} ?>><a href="kategorije">Kategorije</a></li>
            <li <?php if($_GET['upravljac-page']=="podkategorije") { echo 'class="active"';} ?>><a href="podkategorije">Podkategorije</a></li>
            <li <?php if($_GET['upravljac-page']=="podpodkategorije") { echo 'class="active"';} ?>><a href="podpodkategorije">Pod-podkategorije</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Proizvodi</span>&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li <?php if($_GET['upravljac-page']=="proizvodi") { echo 'class="active"';} ?> ><a href="proizvodi">Proizvodi</a></li>
                <li <?php if($_GET['upravljac-page']=="akcije") { echo 'class="active"';} ?> ><a href="akcije">Akcije</a></li>
                </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-cog"></span>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li <?php if($_GET['upravljac-page']=="konfiguracija") { echo 'class="active"';} ?>><a href="konfiguracija">&nbsp;Osnovna podesavanja</a></li>
                <li <?php if($_GET['upravljac-page']=="pozadina") { echo 'class="active"';} ?>><a href="pozadina">&nbsp;Pozadina sajta</a></li>
              </ul>
            </li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Cao <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="profil"><span class="glyphicon glyphicon-user"></span>&nbsp;Profil</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Odjavi se</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="clearfix"></div>
    	
    
<?php
  if(empty($_GET['upravljac-page'])){
      include 'pocetna.php';
  }elseif ($_GET['upravljac-page']=="kategorije") {
    include 'kategorije.php';
  }elseif ($_GET['upravljac-page']=="podkategorije") {
    include 'podkategorije.php';
  }elseif ($_GET['upravljac-page']=="podpodkategorije") {
    include 'ppkategorije.php';
  }elseif ($_GET['upravljac-page']=="proizvodi") {
    include 'proizvodi.php';
  }elseif ($_GET['upravljac-page']=="akcije") {
    include 'akcije.php';
  }elseif ($_GET['upravljac-page']=="konfiguracija") {
    include 'konfiguracija-sajta.php';
  }elseif ($_GET['upravljac-page']=="pozadina") {
    include 'pozadina.php';
  }elseif ($_GET['upravljac-page']=="profil") {
    include 'profil.php';
  }
   function greska($naslov_greske,$greska){
    echo '<br><div class="alert alert-danger">
          <strong>'.$naslov_greske.'</strong> '.$greska.'
          </div>';
  }
?>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});
  $('ul.nav li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(150);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut(150);
});
</script>
</body>
</html>
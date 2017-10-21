<?php
    include_once 'konfiguracija.php';
    include_once 'konekcija.php';
    foreach (glob("klase/*.php") as $imefajla) {
                            include $imefajla;
                        }?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" lang="sr">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <!-- Hotjar Tracking Code for http://www.aquariuspetshop.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:659472,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'header-data.php'; ?>
    <!-- Bootstrap Core CSS --><link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">


<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo $url; ?>css/shop-homepage.php" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
    <div class="container glavni-container-top top-baner">
            <a href="<?php echo $baner_top_link; ?>">
                <img class="img-responsive" src="<?php echo $baner_top_slika; ?>" alt="<?php echo $naslov; ?>">
            </a>
    </div>
    <div class="clearfix"></div>

    <div class="container glavni-container">
    <?php
        include 'sadrzaj/navigacija.php';
    ?>
    <div class="clearfix"></div>

    <!-- Page Content -->

        <div class="row"><?php 
                        include 'sadrzaj/sidebar_left.php';
                        include 'sadrzaj/main.php';
                        include 'sadrzaj/sidebar_right.php';
                    ?></div>
    </div>
    </div>
    <!-- /.container -->
    <div class="container">
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p><a href="https://joker.rs">Joker</a> CMS &copy; <a  href="<?php echo $url; ?>"><?php echo $naslov; ?></a> <?php echo date("Y"); ?></p>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.container -->
    <!-- jQuery -->
    <script src="<?php echo $url; ?>js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $url; ?>js/bootstrap.min.js"></script>
    <script type="text/javascript">
         $('ul.nav li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(150);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut(150);
});
    </script>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-91053485-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>

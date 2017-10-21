<?php 
header('Content-Type: text/css');
include '../konfiguracija.php';
?>
/*!
 * Start Bootstrap - Shop Homepage (http://startbootstrap.com/)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */

body {
   /* padding-top: 70px; /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
   background-color: #242930;
   background-image: url("../images/dizajn/pozadina/<?php echo $background_image; ?>");
   background-repeat: repeat;
}
.main {
    padding: 0 15px 30px 15px;
    background-color: #939598;
}
.akcije-naslov{
    color: #0080c5;
    font-weight: 700;
    }
.main-pocetna {
    padding-top: 30px;
}

.slika-mala {
    width: 100%;
    height: 100px;
}
.slika-velika {
    width: 100%;
    height: 250px;
}
.row-pocetna {
    padding-left: 17px;
    padding-right: 17px;
}
.desna-slika{
    font-size: 17px;
}
.h3-opis-proizvoda{
    margin-top: 0;
}
.cena-proizvoda{
    line-height: 1.7;
    font-size: 27px;
}
.h1-proizvod {
    margin-top:1px;
    border: 0;
}
.proiz-ime {
    border-bottom: 1px solid #eee;
}
.kategorija-navigator, .kategorija-navigator > a {
    color:#0080c5;
    font-size: 15px;
    font-weight: 600;
}
#kako-do-nas-mapa {
    height: 300px;
    padding: 10px;
    background-color: #FFF;
}
.slide-image {
    width: 100%;
}

.carousel-holder {
    margin-bottom: 30px;
}

.carousel-control,
.item { 
    border-radius: 4px;
}

.caption {
    height: 130px;
    overflow: hidden;
}

.caption h4 {
    white-space: nowrap;
}

.thumbnail img {
    width: 100%;
}

.ratings {
    padding-right: 10px;
    padding-left: 10px;
    color: #d17581;
}

.thumbnail {
    padding: 0;
}

.thumbnail .caption-full {
    padding: 9px;
    color: #333;
}

footer {
    margin: 50px 0;
} 
.social > img {
    width: 70px;
}
.social > img:hover {
    box-shadow: inset 0 0 6px 6px black;
}

.top-baner {
    height: auto;
    background-color: #01a2b4;
}
.top-baner .img-responsive {
margin: 0 auto;
}


.kategorija {
    margin-left: 5px;
    background-color: #939598;
    padding: 10px;
}
.kategorija > a {
    margin-bottom: 6px;
    #position: relative;
    width: 100%;
    padding: 3px 15px;
    font-size: 17px;
    color: black;
    text-transform: uppercase;
}

.kategorija > p {
    text-transform: uppercase;
    color: #0080c5;
    font-weight: 700;
    font-size:25px;
    margin-bottom: 4px;
}
.sidebar-2 {
    margin-right: 5px;
    background-color: #939598;
    padding: 10px;
}
.sidebar-2 > div, .kategorija > div {
    margin-bottom: 8px;
    #position: relative;
    width: 100%;
    padding: 10px;
    font-size: 20px;
    color: black;
    background-color: white;
    font-weight: 700;
}
.sidebar-2 > p, .glavni-pocetna > p{
    text-transform: uppercase;
    color: #0080c5;
    font-weight: 700;

}
.imena-href{
    font-weight: 500;
    color: #0080c5;
}
.glavni-pocetna > p {
    margin-left: 15px;
}
.marr-top {
    margin-top: 25px;
}

@media (max-width: 992px) {
        .kategorija > a {
        width: 100%;
        right:0;
        text-align: center;
    }
    .sidebar-2 > div {
        width: 100%;
        left: 0;
    }

    }
 /*COLORS*/
.color-red{color: #FF0000;}
.color-green{color: #6cbc42;}
.color-blue{color: #0080c5;}
.color-youtube{color:red;}
.color-facebook{color:#00539f;}
.color-google{color:red;}

/*NAVBAR STYLES*/
.navbar-border{border-bottom: solid 5px #0080c5;}
.login-panel { 
    min-width: 250px; 
    border-top: 14px solid #0080c5;
    border-right: 1px solid #0080c5;
    border-bottom-right-radius:0.5em;
    -moz-border-radius-bottomright:0.5em;
    border-bottom: 3px solid #0080c5;
    border-left: 1px solid #0080c5;
    border-bottom-left-radius:0.5em;
    -moz-border-radius-bottomleft:0.5em;
    }
.dropdown-header { display: block !imnportant; padding-bottom: 30px; height: 10px; }
.login-header { font-size: 20px; font-weight: bold; display: inline; float: left; }
.forgot-password { font-size: 10px; display: inline; float: right; vertical-align: bottom; padding-top: 10px; }
.center-text { text-align: center; }
.error-message { font-size: 11px; }
.glavni-container {
    border: 1px solid white;
    padding: 0;
    border-radius: 6px;
    background-color: white;
}
.glavni-container-top {
    padding: 0;
    border-radius: 6px;
    background-color: #01a2b4;
}
small, .small {
    font-size: 50%; 
    font-weight: 400;
    line-height: 15px;
}
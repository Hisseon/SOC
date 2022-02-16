<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
  <!-- Twitter meta-->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:site" content="@pratikborsadiya">
  <meta property="twitter:creator" content="@pratikborsadiya">
  <!-- Open Graph Meta-->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Vali Admin">
  <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
  <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
  <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
  <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
  <title>SOC</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script crossorigin="anonymous" src="https://kit.fontawesome.com/97f0a9a435.js"></script>
  </script>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
  </script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
  </script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
  </script>
  <script crossorigin="anonymous" src="https://kit.fontawesome.com/97f0a9a435.js">
  </script>
</head>

<body class="app sidebar-mini sidenav-toggled">
  <!-- Navbar-->
  <header class="app-header"><a class="app-header__logo mt-auto mb-2" href="#"><img src="assets/images/pass-logo.png"></a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle mt-auto mb-auto" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
  </header>

  <?php

  #ISSET: isset() determina si una variable esta definida y no es NULL

  if (isset($_GET["pagina"])) {
    if (
      $_GET["pagina"] == "page-login" ||
      $_GET["pagina"] == "page-logout" ||
      $_GET["pagina"] == "page-inicio" ||
      $_GET["pagina"] == "page-inicio-compra" ||
      $_GET["pagina"] == "page-proveedor" ||
      $_GET["pagina"] == "page-user" ||
      $_GET["pagina"] == "page-PO" ||
      $_GET["pagina"] == "page-historial-compras" ||
      $_GET["pagina"] == "page-listado-proveedores" ||
      $_GET["pagina"] == "delete" ||
      $_GET["pagina"] == "page-po-details" ||
      $_GET["pagina"] == "page-ver-pdf-PO" ||
      $_GET["pagina"] == "page-ver-archivo"



    ) {
      include "views/pages/" . $_GET["pagina"] . ".php";
    } else {
      include "views/pages/page-error.php";
    }
  } else {

    include "views/pages/page-login.php";
  }

  ?>

</body>

</html>
<!-- Essential javascripts for application to work-->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="asssets/js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<!-- Google analytics script-->
<script type="text/javascript">
  if (document.location.hostname == 'pratikborsadiya.in') {
    (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-72504830-1', 'auto');
    ga('send', 'pageview');
  }
</script>
<?php
ini_set("display_errors", 0);
ob_start(); session_start();
require('dts/dbaSis.php');
require('dts/getSis.php');
require('dts/setSis.php');
require('dts/outSis.php');
header('Content-Type: text/html; charset=UTF-8');
viewManager('61');

$lerConfig = read('up_config');
foreach($lerConfig as $cfg);
$online = $cfg['online'];

if($online != 1){
  echo utf8_decode('Site em manutenção...');
}else{
?>
<!DOCTYPE html>
<html>
<head>
    
    <title>BSB-TI Education</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!--Favicon -->
  <link rel="icon" type="image/png" href="images/favicon.png" />
  <link rel="stylesheet" href="<?php setHome();?>/css/reset.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/animate.min.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/owl.carousel.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/socials.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/player/YTPlayer.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/magnific-popup.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/prettyPhoto.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/revslider.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/settings.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/settings-ie8.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/style.css" />
  <link rel="stylesheet" href="<?php setHome();?>/css/responsive.css" />

  <!-- Cores de elementos da pagina-->
  <link id="changeable_color" rel="stylesheet" href="<?php setHome();?>/css/colors/lightslategray.css" />
  <!-- /Cores de elementos da pagina- -->
  <!-- Tive que colocar o css aqui... não sei qual era o problema (não era cache), eu trocava o código do style.css (para o código abaixo) e o browser não carregava -- by NataN-->
  <style type="text/css" media="screen">
    /* Insreva-se Form */

  #inscreva-se .inner{
    padding-bottom:68px;
  }

  #inscreva-se .contact{
    max-width: 970px;
    margin:75px auto 0;
  }

  #inscreva-se .contact form .form{
    width:100%;
    height: auto;
    padding:15px 15px 12px;
    font-size:18px;
    margin-bottom:18px;
    color:#7f7f7f;
    letter-spacing: 0.5px;
  }

  #inscreva-se .contact form .textarea{
    height: 201px;
    max-width: 100%;
    max-height: 201px;
  }

  #inscreva-se .contact form button.contact-form-button{
    margin-bottom:0;
  }
  </style>

  <!-- / CSS Files -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-53693327-1', 'auto');
        ga('send', 'pageview');

    </script>
 
</head>

<body class="parallax">
<?php getHome();?>

<!-- Keep In Touch -->
  <section id="contact" class="container">

    <!-- Inner -->
    <div class="inner">
      <!-- Header -->
	  <?php 
		$lerContato = read('up_contato');
		foreach($lerContato as $contato);
	  ?>
      <h1 class="header uppercase dark oswald">
        <?php echo utf8_decode($contato['titulo']);?>
      </h1>
      <!-- Header Strip(s) -->
      <div class="header-strips-one"></div>
      <!-- Header Description -->
      <h2 class="description dark">
        <?php echo utf8_decode($contato['descricao']);?>
      </h2>

      <!-- Contact -->
      <div class="contact animated" data-animation="fadeIn" data-animation-delay="200">
        <!-- Contact Form -->
        <form id="contact-form" name="cform" class="clearfix" method="post" action="php/gmail.php">
          <!-- Left Inputs -->
          <div class="col-xs-6 left">

            <!-- Name -->
            <span class="name-missing">Digite seu nome</span>
            <input type="text" name="name" id="name" class="form light-form oswald light" placeholder="NOME" />

            <!-- Email -->
            <span class="email-missing">Digite seu e-mail</span>
            <input type="text" name="email" id="email" class="form light-form oswald light" placeholder="E-MAIL" />

            <!-- Subject -->
            <span class="subject-missing">Digite um assunto</span>
            <input type="text" name="subject" id="subject" class="form light-form oswald light" placeholder="ASSUNTO" />

          </div>
          <!-- Fim Left Inputs -->
          <!-- Right Text Area -->
          <div class="col-xs-6 right">

            <!-- Message -->
            <span class="message-missing">Deixe sua mensagem</span>
            <textarea name="message" id="message" class="form light-form textarea oswald light" placeholder="MENSAGEM"></textarea>

          </div>
          <!-- Fim Right Text Area -->
          <!-- Send Button -->
          <div class="col-xs-12">
            <!-- Button -->
            <button type="submit" id="submit" name="submit" class="form contact-form-button light-form oswald light">ENVIAR</button>
          </div>
          <!-- Fim Send Button -->
        </form>
        <!-- Fim Form -->

        <!-- Your Mail Message -->
        <div class="mail-message-area">
          <!-- Message -->
          <div class="alert light-form mail-message not-visible-message">
            <strong>Obrigado!</strong> Seu e-mail foi enviado.
          </div>
        </div>
        <!-- Fim Mail Message -->
      </div><!-- Fim Contact Form -->
    </div><!-- Fim Inner -->
  </section><!-- Fim Contact Section -->




  <!-- Adress Section -->
  <section id="address" class="container soft-bg-1 parallax7">
    <!-- Inner -->
    <div class="inner">
      <!-- Fim endereço -->
      <div class="address-soft t-center">

        <!-- Botão de telefone-->
        <a href="tel:123456" class="phone-button round white">
          <i class="fa fa-phone"></i>
        </a>

        <!-- Telefone -->
        <h1 class="phone-text oswald white">
          (61) 21312312 
        </h1>

        <!-- Fimereço -->
        <h2 class="phone-text oswald uppercase">
          Brasília/DF - Endereço tal
        </h2>

        <!-- E-Mail -->
        <a href="mailto:contato@bsb-ti.com.br" class="mail-text uppercase oswald">
          ccontato@bsb-ti.com.br
        </a>

        <!-- Social, Facebook -->
        <a href="#" target="_blank" class="social round dark-bg facebook">
          <i class="fa fa-facebook"></i>
        </a>

        <!-- Twitter -->
        <a href="#" target="_blank" class="social round dark-bg twitter">
          <i class="fa fa-twitter"></i>
        </a>

        <!-- Linkedin -->
        <a href="#" target="_blank" class="social round dark-bg linkedin">
          <i class="fa fa-linkedin"></i>
        </a>

        <!-- YouTube -->
        <a href="#" target="_blank" class="social round dark-bg youtube">
          <i class="fa fa-youtube"></i>
        </a>

      </div><!-- Fimereço -->
    </div><!-- Fim Inner -->
  </section><!-- Fim Endereço Section -->

  


  <!-- Google Map -->
  <section id="map">
    <!-- Google Map Script -->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <!-- Google Map ID -->
    <div id="google-map"></div>
  </section>
  <!-- Fim Google Map -->




  <!-- Footer -->
  <footer class="footer white-bg t-center">
    <!-- Logo -->
    <img src="images/logo.png" alt="BSB Education"/>
    <!-- Text -->
    <p class="uppercase semibold">
      ©2014 all rights reserved. designed by <a href="http://www.astralis.com.br" target="_blank">Astralis</a> 
    </p>
  </footer>
  <!-- Fim Footer -->



  <!-- Voltar ao início -->
  <section id="back-top">
    <a href="#home" class="scroll t-center white">
      <i class="fa fa-angle-double-up"></i>
    </a>
  </section>
  <!-- Fim Back To Top Button -->

  <!-- JS Files -->
  <script type="text/javascript" src="<?php setHome();?>/js/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.appear.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/waypoints.min.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/modernizr-latest.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/SmoothScroll.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.superslides.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.isotope.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.parallax-1.1.3.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.fitvids.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.flexslider.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/owl.carousel.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.mb.YTPlayer.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.magnific-popup.min.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.prettyPhoto.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/jquery.sticky.js"></script>
  <!-- Rev Slider -->
  <script type="text/javascript" src="<?php setHome();?>/js/revslider/jquery.themepunch.revolution.min.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/revslider/jquery.themepunch.plugins.min.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/revslider/revslider.js"></script>
  <!-- Fim Rev Slider -->
  <script type="text/javascript" src="<?php setHome();?>/js/plugins.js"></script>
  <script type="text/javascript" src="<?php setHome();?>/js/google-map.js"></script>
  <!-- Fim JS Files -->
<!-- Tive que colocar esse js aqui... não sei qual era o problema (não era cache), eu trocava o código do pluguins.js (para o código abaixo) e o browser não carregava -- by natan-->
<script>
$(document).ready(function(){
  $(".scroll").click(function(){
    $("section").css("padding-top" , "22px");
  });
});
</script>

</body>

</html>
<?php
}
?>
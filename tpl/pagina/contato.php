<!-- Meta -->
    <meta charset="utf-8">
    <meta name="keywords" content="<?php echo SITETAGS; ?>" />
    <meta name="description" content="<?php echo SITEDESC; ?>">
    <meta name="author" content="BSB-TI Services">
    <meta name="robots" content="all" />
    <meta name="rating" content="general" /> 
    <meta name="googlebot" content="noodp" />
    <meta name="expires" content="never" /> 
    <meta name="publisher" content="BSB-TI Services" />
    <meta name="copyright" content="Astralis Desenvolvimento de Sistemas Web" />
    <meta name="language" content="pt-br" /> 
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BSB-TI | Services :: Contato</title>
</head>
<body>

<?php setArq('tpl/header'); ?>

<!-- Page Title -->
<div id="page-title">
    <h1 class="container">CONTATO
    <span class="sub-title">Fale conosco</span>
    </h1>
</div>
<!-- End of page title -->
<!-- Content -->
<div id="content" class="clearfix">
    <!-- Google Maps -->
    <div id="google-map"></div>
    <!-- End of Google Maps -->
  <div class="container">      
      <hr class="sep40" />
      <!-- Contact form -->
      <div class="two-third">
        <?php
        if(isset($_POST['sendForm'])){
            $f['nome']      = mysql_real_escape_string($_POST['nome']);
            $f['assunto']   = mysql_real_escape_string($_POST['assunto']);
            $f['email']     = mysql_real_escape_string($_POST['email']);
            $f['mensagem']  = strip_tags(trim($_POST['mensagem']));
            
            if(in_array('',$f)){
                echo '<p class="erro radius">Erro: Desculpe, para que possamos enviar sua mensagem você deve preencher todos os campos. Obrigado!</p>';
            }elseif(!valMail($f['email'])){
                echo '<p class="erro radius">Erro: O E-mail que você informou não tem um formato válido, favor informe um e-mail válido. 
                Obrigado!</p>';
            }else{
                $msgSend = '<p style="font:14px \'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#333">'.nl2br($f['mensagem']).'</p><hr /><h4>Nova mensagem via contato do site:</h2><p><strong>Nome: </strong>'.$f['nome'].'<br /><strong>Email: </strong>'.$f['email'].'<br /><strong>Assunto: </strong>'.$f['assunto'].'<br /><strong>Data: </strong>'.date('d/m/Y H:i');

                sendMail($f['assunto'],$msgSend,MAILUSER,SITENAME,MAILUSER,SITENAME,$f['email'],$f['nome']);
                $_SESSION['return'] = '<p class="accept radius">Obrigado por entrar em contato com a '.SITENAME.', 
                Recebemos sua mensagem e estaremos respondendo em breve</p>';
                header('Location: '.BASE.'/pagina/contato');
            }
        }elseif(!empty($_SESSION['return'])){
            echo $_SESSION['return'];
            unset($_SESSION['return']); 
        }
        ?>   
        <h2><strong>Escreva</strong>-nos</h2>            
        <form method="post" action="">
            <input id="name" name="nome" type="text" value="NOME" onfocus="if (this.value == 'NOME') {this.value = '';}" onblur="if (this.value == '') {this.value = 'NOME';}" required/>
            <input id="email" type="email" name="email" value="E-MAIL" onfocus="if (this.value == 'E-MAIL') {this.value = '';}" onblur="if (this.value == '') {this.value = 'E-MAIL';}" required />
            <input id="assunto" type="text" name="assunto" value="ASSUNTO" onfocus="if (this.value == 'ASSUNTO') {this.value = '';}" onblur="if (this.value == '') {this.value = 'ASSUNTO';}" required />
            <textarea rows="5" cols="60" id="message" name="mensagem" onfocus="if (this.value == 'MENSAGEM') {this.value = '';}" onblur="if (this.value == '') {this.value = 'MENSAGEM';}" required>MENSAGEM</textarea>
            <button class="button-outline defalut" type="submit" name="sendForm"><strong>Enviar</strong> mensagem!</button>
        </form>
      </div>
      <!-- End of contact form -->
      <!-- Adress -->
      <div class="one-third last-in-row">
        <h2><strong>Localização</strong></h2>    
        <ul class="contact-list">
            <?php
            $lerConf = read('up_config');
            foreach($lerConf as $conf);
            ?>
            <li><i class="icon-phone"></i> Telefone: <span><?php echo $conf['telefone'];?></span></li>
            <li><i class="icon-envelope"></i> E-mail: <span><a href="#"><?php echo $conf['email'];?></a></span></li>
            <li><i class="icon-location-arrow"></i> Endereço: <span><?php echo $conf['endereco'];?></span></li>
            <li><i class="icon-time"></i> Horário de funcionamento: <span>8:00 - 18:00</span></li>
        </ul>
      </div>
      <!-- End of adress -->
      <hr class="sep40" />
    </div>
</div>
<!-- End of content -->
    
    
        
    	   
</div><!-- /form -->
</div><!-- //content -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
<!-- End of scripts -->

<!-- Google Maps config -->
<script type="text/javascript" src="<?php sethome();?>/javascript/google-maps-config.js"></script>
<!-- End of Google Maps config -->

<!-- Scripts Configuration -->
<script type="text/javascript" src="<?php sethome();?>/javascript/custom.js"></script>
<!-- End of scripts configuration -->
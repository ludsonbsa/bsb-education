<?php
ob_start();
session_start();
require('../dts/dbaSis.php');
require('../dts/outSis.php');

if(!empty($_SESSION['autUser'])){
	header('Location: index2.php');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITENAME;?> - Gestor de Conteúdo</title>

<meta name="title" content="Painel Administrativo - <?php echo SITENAME;?>" />
<meta name="description" content="Área restrita aos administradores <?php echo SITENAME;?>" />
<meta name="keywords" content="Login, Recuperar Senha, <?php echo SITENAME;?>" />

<meta name="author" content="Ludson Almeida" />   
<meta name="url" content="http://www.astralis.com.br" />
   
<meta name="language" content="pt-br" /> 
<meta name="robots" content="NOINDEX,NOFOLLOW" /> 

<link rel="icon" type="image/png" href="ico/chave.png" />
<link rel="stylesheet" href="css/style.css" media="all" />

</head>

<body class="login">

	<section>
	<img src="images/logo.png" width="295" height="125" alt="Área administrativa | Login" title="Área administrativa | Login" />
	<hr style="margin-bottom:10px;"/>
	
    <?php
 		if(isset($_POST['sendLogin'])){
			$f['email']		= mysql_real_escape_string($_POST['email']);
			$f['senha']		= mysql_real_escape_string($_POST['senha']);
			$f['salva']		= mysql_real_escape_string($_POST['remember']);

			
			
			if(!$f['email'] || !valMail($f['email'])){
				echo '<div class="red2" style="color:#fff">
						Erro! Campo e-mail vazio ou não possui formato válido.
					</div>';
			}
			elseif(strlen($f['senha']) < 6 || strlen($f['senha']) > 12){
				echo '<div class="orange2" style="color:#fff">
							<strong>Atenção!</strong> Senha deve conter em 6 e 12 caracteres.
						 	</div>';
			}
			else{
				$autEmail = $f['email'];
				$autSenha = $f['senha'];
				$autSenha = md5($autSenha);
				$readAutUser = read('up_users',"WHERE email = '$autEmail'");
				

				if($readAutUser){
					foreach($readAutUser as $autUser);

					if($autUser['status'] != 1){
						echo '<div class="orange2" style="color:#fff">
						<strong>Atenção!</strong> Sua conta ainda não foi ativada, contate um administrador.
					 	</div>';
					 	echo '<a href="index2.php" style="margin-top:10px;"><button class="">Voltar</button></a>';
					 exit();
					 }
					 
					if($autEmail == $autUser['email'] && $autSenha == $autUser['senha']){

						if($autUser['nivel'] == 1 || $autUser['nivel'] == 2){
							if($f['salva']){
								$cookiesalva = base64_encode($autEmail).'&'.base64_encode($f['senha']);
								setcookie('autUser',$cookiesalva,time()+60*60*24*30,'/');	
							}else{
								setcookie('autUser','',time()+3600,'/');
							}
								$_SESSION['autUser'] = $autUser;
								header('Location: '.$_SERVER['PHP_SELF']);
						}else{
							echo '
							<div class="red2" style="color:#fff">
							<strong>Erro!</strong> Seu nível não permite acesso a está área. 
							Vamos redirecionar você para o login de usuários.
						 	</div>
							';
							header('Refresh: 5;url='.BASE.'/pagina/login');							
						}
					}else{
						echo '<div class="red2" style="color:#fff">
								<strong>Erro!</strong> Senha informada não confere.
							  </div>';	
					}
				}else{
					echo '<div class="red2" style="color:#fff">
							<strong>Erro!</strong> E-mail informado não é válido.
						  </div>';
				}				
			}
		}elseif(!empty($_COOKIE['autUser'])){
			$cookie = $_COOKIE['autUser'];
			$cookie = explode('&',$cookie);
			$f['email'] = base64_decode($cookie[0]);
			$f['senha'] = base64_decode($cookie[1]);
			$f['salva'] = 1;
		}
		  
		   		$remember=$_GET['remember'];
		   
		   if(!$remember){
        	
		?>
    	<form name="login" action="" method="post">
        	<label>
                <input type="text" class="radius" name="email" value="<?php if(isset($f['email'])) echo $f['email'];?>" placeholder="Digite seu E-mail" />
            </label>
            <label>
                <input type="password" class="radius" name="senha" value="<?php if(isset($f['senha'])) echo $f['senha'];?>" placeholder="Digite sua Senha" />
            </label>
            <button class="blue" name="sendLogin">Login</button>
            
            <div id="remember">
	      	 <input type="checkbox"  name="remember" value="1" <?php if(isset($f['salva'])) echo 'checked="checked"'; ?> />
	      	 <p>Lembrar meus dados de acesso!</p>
	  		 </div>
            <br><br><br>
            <p><a class="esqueci" href="index.php?remember=true" class="link" title="Esqueci minha senha!">Esqueceu a senha?</a></p>
        </form>
    	<?php
			}else{
				if(isset($_POST['sendRecover'])){
					$recover = mysql_real_escape_string($_POST['email']);
					if(valMail($recover)){
						$readRec = read('up_users',"WHERE email = '$recover'");
						if(!$readRec){
							echo '<div class="red2">
									<p>Erro! E-mail não confere.</p>
								</div>';
						}else{
							foreach($readRec as $rec);
							if($rec['nivel'] == 1 || $rec['nivel'] == 2){
								$msg = '<h3 style="font:16px \'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#526e9b;">Prezado '.$rec['nome'].', recupere seu acesso!</h3><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#666;">Estamos entrando em contato pois foi solicitado em nosso nível administrativo / editor a recuperação de dados de acesso. Verifique logo abaixo os dados de seu usuário:</p><hr><p style="font:italic 14px \'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#069">E-mail: '.$rec['email'].'<br>Senha: '.$rec['code'].'</p><hr><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#F00;">Recomendamos que você altere seus dados em seu perfil após efetuar o login!</p><hr><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#666;">Atenciosamente a administração - '.date('d/m/Y H:i:s').' - <a style="color:#900" href="http://www.astralis.com.br" title="Astralis TI">Astralis Desenvolvimento em TI</a><hr><img alt="Astralis TI" title="Astralis TI" src="http://www.astralis.com.br/images/astralis.png"></p>';
								sendMail('Recupere seus dados!',$msg,MAILUSER,SITENAME,$rec['email'],$rec['nome']);
								echo '<div class="green2" style="color:#fff">
										Seus dados foram enviados com suscesso para: 
									<strong>'.$rec['email'].'</strong>. Por favor verifique!
									</div>';

							}else{
								echo '<div class="red2" style="color:#fff">
								<strong>Erro!</strong> Seu nível não permite acesso a está área. 
								Vamos redirecionar você para o login de usuários.
							 	</div>';
								header('Refresh: 5;url='.BASE.'/pagina/login');	
							}
						}
					}else{
						echo '<div class="red2">
								<p>Erro! Formato do e-mail informado não é válido.</p>
							  </div>';
					}
				}
		?>
        <form name="recover" action="" method="post">
        	<p style="color:#fff">Informe seu e-mail para receber seus dados de acesso.</p>
        	<label>
                <input type="text" class="radius" name="email"  value="<?php if(isset($recover)) echo $recover;?>" placeholder="Digite seu E-mail" />
            </label>
            <button class="blue" name="sendRecover">Recuperar</button>

            	<p><a href="index.php" class="link" title="Voltar">Voltar</a></p>

        </form>
    	<?php
			}
		?>
</div><!-- //login -->

</body>
<?php ob_end_flush();?>
</html>
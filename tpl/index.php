
<?php setArq('tpl/header'); ?>

  
      <!-- Content Right -->
      <div class="content-right white">
        <!-- Button One -->
        <a href="#about" class="page-content-button oswald uppercase white scroll">
          NAVEGAR
        </a>

      </div>
      <!-- Fim Content Right -->

    </div><!-- Fim Inner -->
  </section><!-- Fim Page Content -->




  <!-- About Section -->
  <section id="about" class="container">
    <!-- About Inner -->
    <div class="inner about">
      <!-- Header -->
      <h1 class="header uppercase dark oswald animated" data-animation="fadeIn" data-animation-delay="100">
        <?php
            $readSobre = read('up_sobre');
            foreach($readSobre as $sobre);
            echo $sobre['titulo'];
        ?>
      </h1>
      <!-- Header Strip(s) -->
      <div class="header-strips-one animated" data-animation="fadeIn" data-animation-delay="100"></div>
      <!-- Header Description -->
      <h2 class="description normal animated" data-animation="fadeIn" data-animation-delay="100">
        <?php echo $sobre['descricao'];?>
      </h2>

      <!-- About Boxes -->
      <div class="about-boxes clearfix t-center">
          <?php echo $sobre['content'];?>

    </div><!-- Fim About Inner -->
  </section><!-- About Section -->






  <!-- What We Do Section -->
  <section id="what-we-do" class="container soft-bg parallax1">
    <!-- What We Do Inner -->
    <div class="inner what-we-do">
      <!-- Header -->
      <h1 class="header white uppercase dark oswald">
        O QUE FAZEMOS
      </h1>
      <!-- Header Strip(s) -->
      <div class="header-strips-one"></div>
      <!-- Header Description -->

      <div class="fullwidth relative t-center">

        <!-- Items -->
        <div class="w-items t-left">
        <?php
        $lerOquefazemos = read('up_oquefazemos');
        foreach($lerOquefazemos as $fazemos);
        ?>
          <!-- Item -->
          <div class="w-item white movie">

            <!-- Item Description -->
            <p class="normal">
            <?php echo $fazemos['descricao'];?>
            </p>
          </div>
          <!-- Fim Item -->


        </div><!-- Fim Items -->

        <!-- What We Do Second Area -->
        <div class="w-second-area fullwidth clearfix">
          <!-- Left -->
          <div class="col-xs-6 w-left t-left no-padding animated" data-animation="fadeInLeft" data-animation-delay="0">
            <!-- Mini Header -->
            <?php
                echo $fazemos['texto'];
            ?>

          </div>
          <!-- Fim Left -->

          <!-- Right -->
          <div class="col-xs-6 w-right t-right no-padding animated" data-animation="fadeInRight" data-animation-delay="0">
            <!-- Mac Image -->
            <img src="uploads/paginas/<?php echo $fazemos['thumb'];?>" alt="North Preview"/>
          </div>
          <!-- Fim Right -->

        </div><!-- Fim Second Area -->
      </div><!-- Fim Boxes Area -->
    </div><!-- Fim What We Do Inner -->
  </section><!-- Fim What We Do Section -->


  <!-- Services -->
  <section id="services" class="container parallax5 soft-white-bg">

    <!-- Inner -->
    <div class="inner">
<!--MODAL CURSOS  PS: NÃO ME PERGUNTEM COMO FIZ ISSO FUNCIONAR! MAS FUNCIONA!!!! Testado Crossbrowser e Responsividade, tudo finfando de boa -- by Natan-->
<!--fiz uma réplica do modal dos professores e adaptei o formulário dos contatos no corpo do modal by Natan-->
    <?php
        $lerModal = read('up_cursos');
        foreach($lerModal as $modal):
    ?>
    <!-- Team Member Dialogs -->
    <div class="member-modals">

      <!-- Modal team-01 -->
      <div class="modal fade" id="team-0<?php echo $modal['id'];?>" tabindex="-1" role="dialog" aria-hidden="true">
        <!-- Modal Inner -->
        <div class="modal-inner t-center clearfix">
          <!-- Modal Head -->
          <div class="modal-head">
            <!-- Close Button -->
            <a class="close" data-dismiss="modal" aria-hidden="true">x</a>
            <!-- Member Name -->
            <h1 class="member-name oswald uppercase dark">
                <?php echo $modal['titulo']; ?>
            </h1>
            <!-- Member Position -->
            <h3 class="member-position oswald colored no-margin no-padding uppercase dark">
                <?php echo $modal['descricao']; ?>
            </h3>
          </div>
          <!-- Fim Head -->
          <!-- Modal Left -->
          <div class="modal-left col-xs-5">
            <!-- Img, Div -->
            <div class="modal-img">
              <!-- Member Image -->
                <img src="tim.php?src=uploads/cursos/<?php echo $modal['thumb'];?>&w=443&h=400&q=100&zc=1" alt="" />
            </div>
          </div>
          <!-- Fim Member Left -->
          <!-- Modal Right -->
          <div class="modal-right col-xs-7 t-left">
              <!-- Contact -->
            <div id="inscreva-se" class="container" style="padding-top:0px;">

              <!-- Inner -->
              <div class="inner"  style="padding-top:0px;">
                <div class="contact animated" style="margin-top:0px;" data-animation="fadeIn" data-animation-delay="200">
                  <!-- Contact Form -->
                  <form id="inscreva-se-form" name="cform" class="clearfix" method="post" action="php/gmail.php">
                    <!-- Left Inputs -->
                    <div class="col-xs-12">
                      <span class="name-missing">Preencha o Nome.</span>
                      <input type="text" name="nome" id="nome" class="form light-form oswald light" placeholder="Nome" />

                      <!-- Email -->
                      <span class="email-missing">Preencha seu E-mail.</span>
                      <input type="text" name="mail" id="mail" class="form light-form oswald light" placeholder="E-mail" />
                      <!-- Name -->
                      <span class="name-missing">Preencha seu Telefone.</span>
                      <input type="text" name="telefone" id="telefone" class="form light-form oswald light" placeholder="Telefone" />

                      <!-- Subject -->
                      <span class="subject-missing">Campo5</span>
                      <input type="text" name="subject" id="subject" class="form light-form oswald light" placeholder="Campo5" />

                    </div>
                    <!-- Fim Right Text Area -->
                    <!-- Send Button -->
                    <div class="col-xs-12">
                      <!-- Button -->
                      <button type="submit" id="submit" name="submit" class="form contact-form-button light-form oswald light">APPLY</button>
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
              </div><!-- Fim inner -->
            </div>
        <!-- Fim Form -->
          </div>
          <!-- Modal Right -->
        </div><!-- Fim Modal Right -->
      </div>
      <!-- Fim Modal -->
    </div><!-- Fim Team Member Modals -->
    <?php endforeach; ?>

      <!-- Header -->
        <?php
        $lerCursos = read('up_cursodesc');
        foreach($lerCursos as $desc);
        ?>
      <h1 class="header uppercase dark oswald">
        <?php echo $desc['titulo'];?>
      </h1>
      <!-- Header Strip(s) -->
      <div class="header-strips-one"></div>
      <!-- Header Description -->
      <h2 class="description dark">
          <?php echo $desc['descricao'];?>
      </h2>

      <!-- Service Boxes -->
      <div class="service-boxes clearfix t-center">
    <?php
        $lerCursos = read('up_cursos');
        foreach($lerCursos as $cursos):
      ?>
        <!-- Service Box -->
        <div class="item service-box">
          <a class="member-detail-button colored-bg" data-toggle="modal" data-target="#team-0<?php echo $cursos['id']?>"><!--Chama o modal -- by Natan-->
          <!-- Service Icon -->
            <img src="tim.php?src=../uploads/cursos/<?php echo $cursos['thumb']?>&w=150&h=85&zc=1&q=100" />
          <!-- Service Box Header -->
          <h3 class="uppercase normal oswald">
              <?php echo $cursos['titulo'];?>
          </h3>

          <!-- Service Box Description -->
          <p class="normal">
              <?php echo $cursos['descricao'];?>
          </p>
          </a><!--Fecha href do botão que chama o modal -- by Natan-->
        </div>
        <!-- Fim Service Box -->
<?php endforeach;?>

    </div><!-- Fim Inner -->
  </section><!-- Fim Skills -->

  <!-- Team Section -->
  <section id="team" class="container">
    <!-- Team Inner -->
    <div class="inner team">
      <!-- Header -->
	  <?php
		$lerdesc = read('up_profdesc');
		foreach($lerdesc as $desc);
	  ?>
      <h1 class="header uppercase dark oswald">
        <?php echo $desc['titulo']; ?>
      </h1>
      <!-- Header Strip(s) -->
      <div class="header-strips-one"></div>
      <!-- Header Description -->
      <h2 class="description">
        <?php echo $desc['descricao']; ?>
      </h2>


      <!-- Team Boxes -->
      <div class="team-boxes t-center">
      <?php
        $lerProf = read('up_professores');
        foreach($lerProf as $prof):
      ?>
        <!-- Team Box -->
        <div class="item">
          <!-- Box Inner -->
          <div class="box-inner">
            <!-- Team Member Image -->
            <div class="member-image">
              <!-- Image -->
              <img src="tim.php?src=<?php setHome();?>/uploads/professores/<?php echo $prof['thumb'];?>&w=443&h=400&q=100&zc=1" alt="Team Member" />
            </div>
            <!-- Team Member Details -->
            <div class="member-details">
              <!-- Name and Position -->
              <div class="member-name">
                <!-- Member Name -->
                <h1 class="name oswald uppercase no-padding no-margin">
                  <?php echo $prof['nome'];?>
                </h1>
                <!-- Member Position -->
                <h3 class="position oswald uppercase no-padding">
                    <?php echo $prof['funcao'];?>
                </h3>
              </div>
              <!-- Fim Team Member Details -->

              <!-- Member Details -->
              <div class="details">
                <!-- Description -->
                <p class="member-description normal">
                    <?php echo lmWord($prof['descricao'],200);?>
                </p>

                <!-- Button trigger modal -->
                <a class="member-detail-button colored-bg" data-toggle="modal" data-target="#team-0<?php echo $prof['id']?>"></a>
              </div><!-- Fim Member Details -->
            </div><!-- Fim Team Member Details -->

          </div><!-- Fim Team Box Inner -->

        </div><!-- Fim Team Box -->
        <?php endforeach;?>
      </div><!-- Fim Team Boxes -->
    </div><!-- Fim Team Inner -->


    <?php
        $lerModal = read('up_professores');
        foreach($lerModal as $modal):
    ?>
    <!-- Team Member Dialogs -->
    <div class="member-modals">

      <!-- Modal team-01 -->
      <div class="modal fade" id="team-0<?php echo $modal['id'];?>" tabindex="-1" role="dialog" aria-hidden="true">
        <!-- Modal Inner -->
        <div class="modal-inner t-center clearfix">
          <!-- Modal Head -->
          <div class="modal-head">
            <!-- Close Button -->
            <a class="close" data-dismiss="modal" aria-hidden="true">x</a>
            <!-- Member Name -->
            <h1 class="member-name oswald uppercase dark">
                <?php echo $modal['nome']; ?>
            </h1>
            <!-- Member Position -->
            <h3 class="member-position oswald colored no-margin no-padding uppercase dark">
                <?php echo $modal['funcao']; ?>
            </h3>
          </div>
          <!-- Fim Head -->
          <!-- Modal Left -->
          <div class="modal-left col-xs-5">
            <!-- Img, Div -->
            <div class="modal-img">
              <!-- Member Image -->
                <img src="tim.php?src=uploads/professores/<?php echo $modal['thumb'];?>&w=443&h=400&q=100&zc=1" alt="" />
            </div>
          </div>
          <!-- Fim Member Left -->
          <!-- Modal Right -->
          <div class="modal-right col-xs-7 t-left">
            <!-- Header -->
            <h4 class="oswald dark no-padding uppercase dark">
              Quem é <?php echo $modal['nome']; ?>?
            </h4>
            <!-- Description One -->
            <p class="member-detail-one">
                <?php echo $modal['descricao']; ?>
            </p>
            <!-- Member Skills -->
            <div class="member-skills">
              <!-- Header -->
              <h4 class="oswald dark no-padding uppercase dark">
                Técnicas
              </h4>
              <!-- Progress -->
              <div class="progress">
                <!-- Progress Bar -->
                <div class="progress-bar t-left" data-value="50">
                  <span class="skill-value uppercase white oswald light"><?php echo $modal['tecnica_um']; ?></span>
                </div>
                <!-- Fim Progress Bar -->
              </div>
              <!-- Fim Progress Bar -->
              <!-- Progress -->
              <div class="progress">
                <!-- Progress Bar -->
                <div class="progress-bar t-left" data-value="85">
                  <span class="skill-value uppercase white oswald light"><?php echo $modal['tecnica_dois']; ?></span>
                </div>
                <!-- Fim Progress Bar -->
              </div>
              <!-- Fim Progress Bar -->
              <!-- Progress -->
              <div class="progress">
                <!-- Progress Bar -->
                <div class="progress-bar t-left" data-value="75">
                  <span class="skill-value uppercase white oswald light"><?php echo $modal['tecnica_tres']; ?></span>
                </div>
                <!-- Fim Progress Bar -->
              </div>
              <!-- Fim Progress Bar -->
            </div>
            <!-- Fim Member Skills -->
            <!-- Descriiption Two -->
            <p class="member-detail-two">
                <?php echo $modal['pos_desc']; ?>
            </p>
          </div>
          <!-- Modal Right -->
        </div><!-- Fim Modal Right -->
      </div>
      <!-- Fim Modal -->
    </div><!-- Fim Team Member Modals -->
    <?php endforeach; ?>
  </section><!-- Fim Team Section -->


  <!-- Testimonials -->
  <section id="testemonials" class="testimonials soft-bg-1 bg1 parallax3 t-center">

    <!-- Arrow -->
    <a class="t-arrow"></a>

    <!-- Quote -->
    <h1 class="quote white">
      <i class="fa fa-quote-right"></i>
    </h1>

    <!-- Text Slider -->
    <ul class="text-slider clearfix">
        <?php
        $lerdepo = read('up_depoimento');
        foreach($lerdepo as $depo):
            ?>
      <!-- Slide -->
      <li class="text normal">
        <!-- Quote -->
        <h1 class="white">
          <?php echo $depo['depoimento'];?>
        </h1>
        <!-- Author -->
        <p class="author uppercase">
            <?php echo $depo['nome'];?>
        </p>
      </li>
      <!-- Fim Slide -->
        <?php endforeach; ?>

    </ul><!-- Fim Text Slider -->
  </section><!-- Fim Testimonials -->
<?php 
header('Content-Type: text/html; charset=UTF-8');
?>
<!-- Page Loader -->
  <section id="pageloader" class="white-bg">
    <div class="outter dark-border">
      <div class="mid dark-border"></div>
    </div>
  </section>

  <!-- Navegação -->
  <nav id="navigation-sticky" class="white-nav b-shadow">
    <!-- Navegação Inner -->
    <div class="nav-inner">
      <div class="logo">
        <!-- Navegação Logo Link -->
        <a href="#home" class="scroll">
          <!-- Your Logo -->
          <img src="images/logo.png" class="site_logo" alt="BSB Education"/>
        </a>
      </div>
      <!-- Mobile Menu -->
      <a class="mobile-nav-button colored"><i class="fa fa-bars"></i></a>
      <!-- Navigation Menu -->
      <div class="nav-menu clearfix semibold">
        <ul class="nav uppercase oswald">
          <li><a href="#home" class="scroll">home</a></li>
          <li class="dropdown-toggle nav-toggle" ><a href="#about" class="scroll">sobre<b data-toggle="dropdown"></b></a>
            <!-- DropDown Menu -->
            <ul class="dropdown-menu uppercase gray-border clearfix">
              <li><a href="#what-we-do" class="scroll">o que fazemos</a></li>
            </ul>
            <!-- Fim DropDown Menu -->
          </li>
          <li><a href="#services" class="scroll">cursos</a></li>
          <li><a href="#team" class="scroll">professores</a></li>
          <li><a href="#testemonials" class="scroll">depoimentos</a></li> 
          <li><a href="<?php echo BASE;?>/faq">faq</a></li> 
          <li><a href="#contact" class="scroll">contato</a></li>
        </ul>
      </div><!-- Fim Navigation Menu -->
    </div><!-- Fim Navigation Inner -->
  </nav><!-- Fim Navigation -->




  <!-- Home -->
  <section id="home" class="container relative">
    <!-- Slider Wrapper -->
    <div id="full-slider-wrapper">
      <div class="tp-banner-container">
        <div class="tp-banner" >
          <ul>
          <?php
            $lerSlide = read('up_slides');
            foreach ($lerSlide as $slide):
          ?>
            <!-- SLIDE  -->
            <li data-transition="random" data-slotamount="7" data-masterspeed="1000" >
              <!-- MAIN IMAGE -->
              <img src="uploads/slides/<?php echo $slide['thumb'];?>"  alt="slidebg1"  data-bgfit="cover" data-bgposition="center top" data-bgrepeat="no-repeat">
              <!-- LAYERS -->

              <!-- LAYER NR. 1 -->
              <div class="tp-caption customin customout text-type5 bigger t-center uppercase semibold"
                data-x="center"
                data-y="center" data-voffset="-50"
                data-customin="x:0;y:-100;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;"
                data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                data-speed="500"
                data-start="1600"
                data-easing="Power4.easeOut"
                data-endspeed="500"
                data-endeasing="Power4.easeIn"
                data-captionhidden="on"
                style="z-index: 2">
                  <?php echo $slide['titulo'];?>
              </div>

              <!-- LAYER NR. 2 -->
              <div class="tp-caption customin customout text-type6 bigger t-center"
                data-x="center"
                data-y="center" data-voffset="0"
                data-customin="x:0;y:100;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;"
                data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                data-speed="500"
                data-start="1600"
                data-easing="Power4.easeOut"
                data-endspeed="500"
                data-endeasing="Power4.easeIn"
                data-captionhidden="on"
                style="z-index: 999">
                  <?php echo $slide['descricao'];?>
              </div>

              <!-- LAYER NR. 4 -->
              <div class="tp-caption customin customout home-button-1 scroll uppercase" style="margin-left:-6%"
                data-x="center" data-hoffset="65"
                data-y="center" data-voffset="40"
                data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                data-speed="500"
                data-start="3100"
                data-easing="Power4.easeOut"
                data-endspeed="500"
                data-endeasing="Power4.easeIn"
                data-captionhidden="on"
                style="z-index: 999;">
                <a href="<?php setHome();?>/<?php echo $slide['link'];?>" class="scroll">
                  Leia Mais
                </a>
              </div>

            </li>
            <!-- Fim Slide -->
            <?php
              endforeach;
            ?>
           
            
          </ul>
          <div class="tp-bannertimer"></div>
        </div>
      </div>
    </div><!-- Fim Slider Wrapper -->
  </section><!-- Fim Home Section -->

<nav>
    <ul>
        <li class="section"><a href="index2.php"><span class="icon">&#59176;</span> Dashboard</a></li>
        <!--<li>
            <a href="index2.php?exe=posts/posts"><span class="icon">&#9998;</span> Artigos<span class="pip">3</span></span></a>
            <ul class="submenu">
                <li><a href="index2.php?exe=posts/posts-create" title="Criar artigo">Criar artigo</a></li>
                <li><a href="index2.php?exe=posts/posts" title="Editar artigo">Editar artigos</a></li>
                <?php //if($_SESSION['autUser']['nivel'] == '1'){?>
                <li><a href="index2.php?exe=posts/categorias" title="Categorias">Categorias</a></li>
                <?php //}?>
            </ul>   
        </li>-->
        <?php if($_SESSION['autUser']['nivel'] == '1'){?>
        <li>
            <a href="index2.php?exe=home/slides"><span class="icon">&#128188;</span> Home</a>
        </li>
        <li>
            <a href="index2.php?exe=sobre/sobre-edit"><span class="icon">&#128196;</span> Sobre<span class="pip">2</span></span></a>
            <ul class="submenu">
                <li><a href="index2.php?exe=sobre/oquefazemos-edit" title="Criar Página">O que fazemos</a></li>
            </ul>
        </li>
        <li>
            <a href="index2.php?exe=cursos/cursos"><span class="icon">&#128188;</span> Cursos</a>
        </li>
        <li>
            <a href="index2.php?exe=professores/professores"><span class="icon">&#59160;</span> Professores</a>
        </li>
        <li>
            <a href="index2.php?exe=depoimentos/depoimentos"><span class="icon">&#59170;</span> Depoimentos</a>
        </li>
        <li>
            <a href="index2.php?exe=contato/contato"><span class="icon">&#128188;</span> Contato</a>
        </li>
        <?php }?>
        <li>
            <a href="index2.php?exe=usuarios/usuarios"><span class="icon">&#128101;</span> Usuários <span class="pip">3</span></a>
            <ul class="submenu">
                <li><a href="index2.php?exe=usuarios/usuarios-edit&userid=<?php echo $_SESSION['autUser']['id'];?>" title="Perfil">Meu perfil</a></li>
                
                <?php if($_SESSION['autUser']['nivel'] == '1'){?>
                <li><a href="index2.php?exe=usuarios/usuarios-create" title="Criar Usuário">Criar usuário</a></li>
                <li><a href="index2.php?exe=usuarios/usuarios" title="Gerenciar Usuário">Gerenciar usuários</a></li>
                <?php }?>
            </ul>
        </li>
        <li>
            <a href="index2.php?exe=config/config"><span class="icon">&#9881;</span> Configurações</a>
            <ul class="submenu">
                <li><a href="index2.php?exe=auditoria/auditoria" title="Ações do sistema">Auditoria</a></li>
                <li><a href="index2.php?exe=social/social" title="Redes Sociais">Redes Sociais</a></li>
            </ul>
        </li>
        <li>
    </ul>
</nav>

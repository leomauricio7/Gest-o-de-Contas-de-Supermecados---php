<nav class="col-md-2 d-none d-md-block bg-light sidebar" style="position: fixed;" id="menu-lateral">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item text-center">
                <img src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-512.png" width="80">
                <p class="text-centert"><?php echo $_SESSION['user'].'<br><strong>'.Validation::getTipoUsario($_SESSION['idTipo']).'</strong>'; ?></p>
            </li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Menu de Navegação</span>
                <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="home"></span>
                </a>
            </h6>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo Url::getBase();?>">
                    <span data-feather="home"></span>
                    Página Inicial <span class="sr-only">(current)</span>
                </a>
            </li>
            <?php if($_SESSION['idTipo'] == 1){?>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo Url::getBase();?>usuarios">
                    <span data-feather="user"></span>
                   Usuários <span class="sr-only">(current)</span>
                </a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo Url::getBase();?>clientes">
                    <span data-feather="users"></span>
                   Clientes <span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="<?php echo Url::getBase();?>contas">
                    <span data-feather="shopping-cart"></span>
                   Dividas <span class="sr-only">(current)</span>
                </a>
            </li>
            <?php if($_SESSION['idTipo'] == 1){?>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo Url::getBase();?>relatorios">
                    <span data-feather="file-text"></span>
                   Relatórios <span class="sr-only">(current)</span>
                </a>
            </li>
            <?php } ?>

        </ul>
    </div>
</nav>
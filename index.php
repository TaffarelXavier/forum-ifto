<?php
include 'autoload.php';
if (!isset($_SESSION['CONECTADO'])) {
    header("location:login");
}
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title><?php echo 'Discussões'; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="CRUD_TX Framework para PHP - Construtor de Aplicações" />
        <meta name="author" content="Taffarel" />
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
        <!--<link href="bootstrap/css/font-awesome.css" rel="stylesheet" />-->
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
        <style>
            body {
                font-family: 'ABeeZee';
            }
        </style>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="./" title="Clique para voltar"><?php echo APP_NAME; ?></a></li>
                        </ul>
                        <ul class="nav pull-right">
                            <li><a href="funcoes/funcao.sair.php" class="text-error"
                                   style="color:red;"
                                   title="#">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="hero-unit">
                <br/><h1>Início</h1>
                <div class="subheader"> 
                    <hr/>
                    <a href="discussoes" title="#" class="icones-area-principal">Discussão |</a>
                    <a href="turmas" title="Clique para add/remover/atualizar" class="icones-area-principal">Turmas |</a>
                    <a href="usuarios" title="Clique para add/remover/atualizar" class="icones-area-principal">Usuários</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr><footer class="muted">
                <div><small><?php echo APP_NAME . VERSAO_EVTX_SYSTEM; ?> &copy; </small></div>
            </footer>
        </div>

        <script src="scripts/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="scripts/jquery.form.js"></script>

    </body>
</html>
<?php
include 'autoload.php';
if (!isset($_SESSION['CONECTADO'])) {
    header("location:login");
}
$Disc = new discussao($connection);
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
        <script src="scripts/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="scripts/jquery.form.js"></script>
        <style>
            body {
                font-family: 'ABeeZee';
            }
            @media (min-width: 1200px) {
                .icone-forum{
                    width:20%;max-width: 30%;min-height: 140px !important;padding:1.5%;border-radius:0px;
                    background: #006E6D;box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
                    margin:4px;text-align: center;border:1px solid rgba(240,240,240,.8);float:left;
                } 
                .titulo-pagina{
                    margin-top: 40px;
                }
            }
            /* tables em formato porta retrato até os desktos no formato paisagem */
            @media (min-width: 768px) and (max-width: 979px) {
                .icone-forum{
                    width:27%;min-height: 140px !important;padding:1.5%;border-radius:0px;
                    background: #006E6D;box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
                    margin:4px;text-align: center;border:1px solid rgba(240,240,240,.8);float:left;
                }  
                body {
                    font-size: 60px;
                }
            }
            /* dispositivo em paisagem até os tablets em formato porta-retrato */
            @media (max-width: 767px) {
                .icone-forum{
                    width:100%;min-height: 140px !important;padding:1.5%;border-radius:0px;
                    background: #006E6D;box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
                    margin:4px;text-align: center;border:1px solid rgba(240,240,240,.8);float:left;
                } 
                body {
                    font-size: 30px;
                }
                .titulo-pagina{
                    font-size:35px !important;
                }
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
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="modal_discussao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Add Novo</h3>
            </div>
            <div class="modal-body"><form action="modelos/model.discussao.php" id="form_discussao" method="POST">
                    <div class="row-fluid"> <label><b>TÍTULO:</b></label>
                        <input name="titulo" autofocus="" required="" type="text" class="span12" />
                        <label><b>DESCRICÃO:</b></label>
                        <input name="descricao" required="" type="text" class="span12" />
                        <input type="hidden" name="acao" value="inserir" /></div></form><br/></div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary" form="form_discussao">Salvar mudanças</button>
            </div>
        </div>
        <div class="container">
            <div class="hero-unit">
                <h1 class="titulo-pagina">Discussões</h1>
                <div class="subheader"> 

                    <?php
                    $disc_id = val_input::sani_url('disc_id');
                    if ($disc_id !== false) {
                        if ($Disc->is_discussao_existe((int) $disc_id) > 0) {
                            $info = $Disc->get_discussao_por_id((int) $disc_id);
                            ?>
                            <hr style="border:0px; border-top:1px solid #ccc;">
                            <div class="row-fluid">
                                <form action="modelos/model.discussao.php" id="formEditarDiscussao" method="POST">
                                    <label class="text-info">Criado Por: <?php echo $info->usu_username; ?></label>
                                    <input type="hidden" value="<?php echo $info->dis_id; ?>" name="dis_id" />
                                    <label class="">Título:</label>
                                    <input type="text" id="titulo_id" class="span6"
                                           required=""
                                           value="<?php echo $info->dis_titulo; ?>" name="titulo" autofocus="" />
                                    <label class="">Descrição:</label>
                                    <textarea name="descricao" id="descricao_id" class="span6"
                                              required=""
                                              rows="6" cols="30"><?php echo $info->dis_descricao; ?></textarea>
                                    <label class="">Disponibilidade:</label>
                                    <select name="name" required="">
                                        <option value="">Selecione...</option>
                                        <option value="1">Público</option>
                                        <option value="2">Privado</option>
                                        <option value="3">Personalizado</option>
                                    </select>
                                    value="<?php echo $info->dis_disponibilidade; ?>"
                                    <label class="">Mensagem fixa:</label>
                                    <textarea name="mensagem_fixa" class="span6" rows="4" cols="30"><?php echo $info->dis_mensagem_fixa; ?></textarea>
                                    <div class="row-fluid" style="margin:0 !important;">
                                        <hr style="border:0px; border-top:1px solid #ccc;margin:0px;padding:0px;" class="span6">
                                        <div class="clearfix"></div>
                                        <button id="btnSalvarAlteracoes" class="btn btn-success">Salvar Alterações</button>
                                        <a href="discussoes" class="text-error">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                            <script>
                                $(document).ready(function () {
                                    $("#formEditarDiscussao").ajaxForm({
                                        beforeSend: function () {

                                        },
                                        uploadProgress: function (event, position, total, percentComplete) {

                                        },
                                        success: function (data) {
                                            if (data == '1') {
                                                alert('Operação realizada com sucesso!');
                                            } else if (data == '2') {
                                                alert('Não foi possível fazer a alteração.');
                                            } else {
                                                alert('Houve um erro. Tente novamente.' + "\nCódigo do erro:" + data);
                                            }
                                        },
                                        complete: function (xhr) {

                                        }
                                    });
                                });
                            </script>
                            <?php
                        } else {
                            ?>
                            <div class="row-fluid">
                                <div class="alert alert-block">
                                    <p class="text-error">Discussão <b>não</b> existe.</p>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <hr/>
                        <a href="#modal_discussao" role="button" class="btn btn-success" data-toggle="modal">Adicionar Nova Discussão</a>
                        <hr/>
                        <?php
                        $f = $Disc->getDados();

                        while ($row = $f->fetch(PDO::FETCH_OBJ)) {
                            ?>
                            <a data-discussao="<?php echo $row->dis_id ?>" class="abrir-discussao" style="cursor:pointer;">
                                <div class="icone-forum">
                                    <p style="color:white;">
                                        <b><?php echo $row->dis_titulo ?></b>
                                    </p>
                                    <p style="font-size: 12px;color:black;">
                                        <?php
                                        if (strlen($row->dis_descricao) > 40) {
                                            echo $row->dis_descricao;
                                        } else {
                                            echo $row->dis_descricao, '<br/><br/>';
                                        }
                                        ?>
                                    </p>
                                    <p style="font-size: 12px;color:black;">

                                        <?php echo $row->dis_data ?>
                                    </p>
                                    <!--EDITAR-->
                                    <button class="btn btn-editar btn-success"
                                            data-discussao-id="<?php echo $row->dis_id ?>" 
                                            ><i class="icon-edit"></i></button>
                                    <!--EXCLUIR-->
                                    <button class="btn btn-danger btn-excluir-registro"
                                            data-id="<?php echo $row->dis_id ?>"><i class="icon-trash"></i></button>
                                </div>
                            </a>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <div class="clearfix"></div>
            <hr><footer class="muted">
                <div><small><?php echo APP_NAME . VERSAO_EVTX_SYSTEM; ?> &copy; </small></div>
            </footer>
        </div>
        <script>
            $("#form_discussao").ajaxForm({
                beforeSend: function () {

                },
                success: function (data) {
                    if (data == '1') {
                        alert("Operação realizada com sucesso!");
                        window.location.reload();
                    } else {
                        alert("Não foi possível fazer a inserção de dados.\nCódigo do erro:" + data);
                    }
                }
            });
            //Abrir
            $(".abrir-discussao").click(function () {
                var _this = $(this);
                window.location.href = "area-discussao/?discussao=" + _this.attr('data-discussao');
            });
            //Editar
            $(".btn-editar").click(function () {
                var _this = $(this);
                window.location.href = "?disc_id=" + _this.attr('data-discussao-id');
                return false;
            });
            $('.btn-excluir-registro').click(function () {
                var _id = $(this).attr('data-id');
                if (confirm('Deseja realmente excluir este registro?')) {
                    $('#linha_' + _id).remove();
                    $.post('modelos/model.discussao.php', {acao: 'excluir', id: _id}, function (_result) {
                        if (_result == '1') {
                            alert('Registro excluído com sucesso!');
                        } else {
                            alert('Houve um erro ao tentar exluir este registro.' +
                                    'Código do erro:' + _result);
                        }
                    });
                }
                return false;
            });
        </script>
    </body>
</html>
<?php
include 'autoload.php';
if (!isset($_SESSION['CONECTADO'])) {
    header("location:../login");
}
$Disc = new discussao($connection);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title><?php echo APP_NAME; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="CRUD_FX Framework for PHP - Application Builder" />
        <meta name="author" content="CRUD_FX" />
        <!-- Le styles -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../bootstrap/fontawesome/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../styles/base_index.min.css"/>
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    </head>
    <body style="background:#303030;color:#ABB2A0;">
        <!-- Modal -->
        <div id="modalAbrirImagens" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Abrir Imagens</h3>
            </div>
            <div class="modal-body">
                <p style="overflow: auto;">
                    <img id="getImagemSelected" style="overflow: auto;width: auto;height: auto;">
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
            </div>
        </div>
        <?php
        $Usuario = new Usuarios($connection);
        $ft = $Usuario->getDataFromUsers(USER_ID);
        ?>
        <div class="container">
            <div class="row-fluid" style="padding-top:10px;">
                <div class="span4">
                    <p class="text-success">
                        <i class="fas fa-user"></i> 
                        <span class="hidden-phone hidden-tablet">Usuário conectado:</span>
                        <a href="../usuarios"><b><?php
        echo $ft->usu_username;
        ?></b>
                        </a>
                    </p>
                </div>
                <div class="span4" style="text-align: center;">
                    <a href="../discussoes"><i class="fa fa-book" aria-hidden="true"></i> <b><?php echo APP_NAME; ?></b></a>
                </div>
                <div class="span4" style="padding-right: 15px;">
                    <a id="btnSair" title="Clique para Sair" class="text-error pull-right">
                        <i class="fas fa-sign-out-alt"></i> <!-- uses solid style -->
                        <span class="hidden-phone hidden-tablet">Sair</span>
                    </a>
                </div>
            </div>

            <hr style="border:0px; border-top:1px solid #ccc;margin-top:5px;margin-bottom: 5px;">
            <div id="divResult">
                <div id="resultado"></div>
                <button id="goParaTopo" hidden=""><i class="fas fa-angle-double-up fa-3x"></i></button>
            </div>
            <!--Editor-->
            <div class="row-fluid" id="painel-editor">
                <div class="row-fluid" style="position: relative;">
                    <button class="btn btn-mini btn-danger"
                            id="btnFecharImgPreview" title="Clique para excluir esta imagem"
                            style="position: absolute;display: none;border-radius: 0;left:611px;bottom:10px;">X</button>
                    <img id="pastedImage" class="img-polaroid"
                         style="max-width: 600px;max-height: 600px;position: absolute;bottom:10px;
                         display: none;border:1px solid #ccc;" />
                </div>
                <form method="POST" id="formEnviarMsg" style="position: relative;margin:0px; padding:0px;">
                    <!--MOSTRAR ARQUIVOS FEITO UPLOAD-->
                    <div id="gerResultImagesUploaded" style="position: absolute;border:1px solid transparent;width: 100%;bottom:0px;"></div>
                    <!----->
                    <div style="padding:0px !important;margin:0px !important;width: 80%;float:left;">
                        <!--label error ao enviar mensagem-->
                        <label class="text-error hidden" id="labelError" style="display: none;"></label>
                        <!--EDITOR-->
                        <textarea class="span12"
                                  autofocus="" id="msg" name="mensagens"
                                  cols="30" placeholder="Digite sua mensagem"></textarea>
                        <!--BOTÃO PARA ANEXAR ARQUIVOS-->
                        <label id="btnAnexarArquivos"
                               for="anexarArquivos"
                               type="button"><i class="fas fa-paperclip fa-2x"></i></label>
                    </div>
                    <!--BOTÃO PARA ENVIAR MENSAGEM-->
                    <button type="button" id="btnEnviar" title="Clique para enviar" >
                        <i class="fa fa-paper-plane fa-2x" aria-hidden="true"></i></button>

                    <?php
                    $discussao_fkid = val_input::val_int('discussao');
                    ?>
                    <div id="getFilesUploaded"></div>
                    <input type="hidden" value="<?php echo $discussao_fkid; ?>" name="discussao_fkid" />
                    <input type="hidden" value="<?php echo USER_ID; ?>" name="user_id" />
                    <input type="hidden" id="edit_imagem" name="edit_imagem" />
                    <input type="hidden" value="text" id="msg_tipo" name="msg_tipo" />
                    <input type="hidden" value="inserir" name="acao" />

                </form>
                <!--style="display: none;" hidden=""-->
                <!--Upload Múltiplos Arquivos display: none;-->
                <div class="row-fluid" style="position: absolute;max-width: 100%;height: 0;
                     bottom:120px;right: 0px;left:0px;z-index: 9999;background: white;
                     padding:0 !important;background: transparent;" id="displayImagensAnexos">
                    <form style="padding:0;" id="formUploadFiles"
                          action="../modelos/model.upload.php"
                          enctype="multipart/form-data" method="POST">
                        <!--border:0;width: 0;outline: 0;display: none;;;-->
                        <div id="mostrarArquivos" style="color:black;"></div>
                        <input type='file' name='files[]' accesskey="e" multiple="" id="anexarArquivos" style="display: none;" />
                    </form>
                </div>
            </div>

            <!--
            <hr><footer class="muted">
            <div><small><?php echo APP_NAME; ?> &copy; </small></div>
          </footer>
            -->
        </div>

        <script src="../scripts/jquery-1.9.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../scripts/jquery.form.js"></script>
        <script src="../scripts/longpolling.min.js"></script>
        <script src="../scripts/base.min.js"></script>
    </body>
</html>

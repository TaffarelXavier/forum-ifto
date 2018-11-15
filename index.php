<?php
include 'autoload.php';
if (!isset($_SESSION['CONECTADO'])) {
    header("location:login");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta charset="utf-8">
        <title>If</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="CRUD_FX Framework for PHP - Application Builder" />
        <meta name="author" content="CRUD_FX" />
        <!-- Le styles -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <!--<link href="bootstrap/css/font-awesome.css" rel="stylesheet" />-->
        <link rel="stylesheet" href="styles/base_index.min.css"/>
    </head>
    <?php
    $Usuario = new Usuarios($connection);
    $ft = $Usuario->getDataFromUsers(USER_ID);
    ?>
    <div class="container" style="position:fixed;width: 90%;right: 5%;left:5%;overflow: hidden;">
        <div class="row-fluid" style="padding-top:10px;">
            <div class="span4">
                <p class="text-success">Usuário conectado:<a href="usuarios"><b><?php
                            echo $ft->usu_username;
                            ?></b></a></p>
            </div>
            <div class="span4" style="text-align: center;">
                <a href="discussoes"><b><?php echo APP_NAME; ?></b></a>
            </div>
            <div class="span4">
                <a id="btnSair" title="Clique para Sair" class="text-error pull-right">Sair</a>
            </div>
        </div>

        <hr style="border:0px; border-top:1px solid #ccc;margin-top:5px;margin-bottom: 5px;">
        <div id="divResult">
            <div id="resultado" style="position: fixed;padding-bottom:0px;bottom: 125px;top:40px;
                 overflow: auto !important;border:0px solid red;width: 90%;right: 5%;
                 left:5%;border-bottom:1px solid #ccc;"></div>
        </div>
        <!--Editor-->
        <div class="row-fluid" style="position: fixed;padding:0px !important;
             width: 90%;right: 5%;left:5%;bottom:0px !important;border:0px solid red;margin:0px !important;">
            <div class="row-fluid" style="position: relative;">
                <button class="btn btn-mini btn-danger"
                        id="btnFecharImgPreview" title="Clique para excluir esta imagem"
                        style="position: absolute;display: none;border-radius: 0;left:211px;bottom:10px;">X</button>
                <img id="pastedImage" class="img-polaroid" 
                     style="max-width: 200px;max-height: 200px;position: absolute;bottom:10px;
                     display: none;border:1px solid #ccc;" />
            </div>
            <form method="POST" id="formEnviarMsg" style="position: relative;margin:0px; padding:0px;">
                <div class="row-fluid" style="padding:0px !important;margin:0 !important;">
                    <div class="span9" style="padding:0px !important;margin:0 !important;">
                        <div class="row-fluid" style="position: relative;margin:0 !important;">
                            <label class="text-error hidden" id="labelError" style="position: absolute;padding:5px;
                                   top:-30px;background: rgba(0,0,0,1);display: none;"></label>
                            <!--EDITOR-->
                            <textarea class="span12" rows="3" style="max-width: 101%;min-width: 101%;font-size:18px;
                                      max-height: 400px;min-height: 80px;border:0px solid lime;"
                                      autofocus="" id="msg" name="mensagens"
                                      cols="30" placeholder="Digite sua mensagem"></textarea>
                        </div>
                    </div>
                    <div class="span3" style="padding:0px !important;margin:0 !important;">
                        <button class="btn span12 btn-success" type="button" id="btnEnviar" >Enviar</button>
                    </div>
                </div>  
                <input type="hidden" id="edit_imagem" name="edit_imagem" />
                <input type="hidden" id="msg_tipo" value="text" name="msg_tipo" />
                <input type="hidden" value="inserir" name="acao" />
                <?php
                $discussao_fkid = val_input::val_int('discussao');
                ?>
                <input type="hidden" value="<?php echo $discussao_fkid; ?>" name="discussao_fkid" />
                <input type="hidden" value="<?php echo USER_ID; ?>" name="user_id" />
            </form>
        </div>
        <!--
        <hr><footer class="muted">
            <div><small><?php echo APP_NAME; ?> &copy; </small></div>
        </footer>
        -->
    </div>
    <script src="scripts/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="scripts/jquery.form.js"></script>
    <script src="scripts/longpolling.min.js"></script>
    <script src="scripts/base.min.js"></script>

</body>
</html>
<?php
include 'autoload.php';

if (!defined('CONECTADO')) {
    header("location:login?next=" . $_SERVER['REQUEST_URI']);
}
$Usuario = new Usuarios($connection);

$obj = $Usuario->getDataFromUsers(USER_ID);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>If</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="CRUD_TX Framework para PHP - Construtor de Aplicações" />
        <meta name="author" content="Taffarel" />
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <!--<link href="bootstrap/css/font-awesome.css" rel="stylesheet" />-->
        <style>
            #btnSair{
                cursor:pointer;
            }
        </style>
    </head>
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
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">
                        <li><a id="btnSair" class="pull-right" style="color:red;" title="Clique para voltar">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="hero-unit">
            <br/><h2><?php
//                $path = 'img/avatar.png';
//                $type = pathinfo($path, PATHINFO_EXTENSION);
//                $data = file_get_contents($path);
//                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//                echo $base64;
//                
                
                if ($obj->usu_acesso == 'admin') {
                    echo 'ADMINISTRADOR<br/>Usuários: <span class="text-info">' . $obj->usu_username . '</span>';
                } else {
                    echo 'Usuário:  <span class="text-info">' . $obj->usu_username . '</span>';
                }
                ?></h2>
            <div class="subheader"> 
                <?php
                if ($obj->usu_acesso == 'admin') {
                    ?>
                    <hr/>
                    <a href="#modal_usuarios" role="button" class="btn btn-success" data-toggle="modal">Adicionar Novo</a>
                    <!-- Modal -->
                    <div id="modal_usuarios" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Add Novo</h3>
                        </div>
                        <div class="modal-body"><form action="modelos/model.usuarios.php" id="form_usuarios" method="POST">
                                <div class="row-fluid"> <label><b>USERNAME:</b></label>
                                    <input name="username" autofocus="" required="" type="text" class="span12" />
                                    <label><b>PASSWORD:</b></label>
                                    <input name="password" required="" type="password" class="span12" />
                                    <label class=""><b>Escolher Nível de Acesso</b></label>
                                    <select name="nivel_acesso" required="">
                                        <option value="">Selecione...</option>
                                        <option value="admin">ADMINISTRADOR</option>
                                        <option value="padrao" selected="">PADRÃO</option>
                                    </select>
                                    <input type="hidden" name="acao" value="inserir" /></div></form><br/></div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                            <button class="btn btn-primary" form="form_usuarios">Salvar mudanças</button>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <hr/>
                <table class="table">
                    <tr>
                        <th>ID:</th>
                        <th>Username:</th>
                        <?php
                        if ($obj->usu_acesso == 'admin') {
                            ?>
                            <th>Nível de Acesso:</th>
                            <?php
                        }
                        ?>
                        <th style="text-align: right;">#</th>
                    </tr>
                    <?php
                    $f = $Usuario->getDados();

                    while ($row = $f->fetch(PDO::FETCH_OBJ)) {

                        if ($obj->usu_acesso == 'padrao') {
                            if ($obj->usu_id == $row->usu_id) {
                                ?>
                                <tr id="linha_<?php echo $row->usu_id; ?>">
                                    <td><?php echo $row->usu_id; ?></td>
                                    <td><?php echo $row->usu_username; ?></td>
                                    <td style="text-align: right;">
                                        <a class="btn btn-editar btn-success" data-object='<?php echo json_encode($row); ?>'>
                                            <i class="icon-edit"></i>
                                        </a>
                                        <!--EXCLUIR-->
                                        <button class="btn btn-danger btn-excluir-registro" data-id="<?php echo $row->usu_id ?>"><i class="icon-trash"></i></button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else if ($obj->usu_acesso == 'admin') {
                            ?>
                            <tr id="linha_<?php echo $row->usu_id ?>">
                                <td><?php echo $row->usu_id ?></td>
                                <td><?php echo $row->usu_username ?></td>
                                <td><?php echo strtoupper($row->usu_acesso); ?></td>
                                <td style="text-align: right;">
                                    <a  class="btn btn-editar btn-success" data-object='<?php echo json_encode($row); ?>'>
                                        <i class="icon-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-excluir-registro"
                                            data-id="<?php echo $row->usu_id ?>"><i class="icon-trash"></i></button></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <!--EDITAR USUÁRIO-->
        <div id="modal_editar_usuario" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="modalEditarUsuario">Editar Usuário</h3>
            </div>
            <div class="modal-body">
                <form action="modelos/model.usuarios.php" id="form_editar_usuario" method="POST">
                    <div class="row-fluid"> <label><b>USERNAME:</b></label>
                        <input name="username" autofocus="" id="edit_username" 
                               required="" type="text" class="span12" />
                        <label><b>PASSWORD:</b></label>
                        <input name="password" id="edit_password"  required="" type="password" class="span12" />
                        <?php
                        if ($obj->usu_acesso == 'admin') {
                            ?>
                            <label class=""><b>Escolher Nível de Acesso</b></label>
                            <select name="nivel_acesso" required="" id="edit_nivel_acesso">
                                <option value="">Selecione...</option>
                                <option value="admin">ADMINISTRADOR</option>
                                <option value="padrao" selected="">PADRÃO</option>
                            </select>
                            <?php
                        }
                        ?>
                        <input type="hidden" name="acao" value="editar" />
                        <input type="hidden" name="user_id" id="edit_user_id" value="" />
                    </div>
                </form><br/>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                <button class="btn btn-primary" form="form_editar_usuario">Salvar mudanças</button>
            </div>
        </div>
        <hr><footer class="muted">
            <div><small><?php echo APP_NAME . VERSAO_EVTX_SYSTEM; ?> &copy; </small></div>
        </footer>
    </div>

    <script src="scripts/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="scripts/jquery.form.js"></script>
    <script>
<?php
if ($obj->usu_acesso == 'admin') {
    ?>
            //Inserir
            $("#form_usuarios").ajaxForm({
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
    <?php
}
?>

        //Editar
        $("#form_editar_usuario").ajaxForm({
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

        $('.btn-excluir-registro').click(function () {
            var _id = $(this).attr('data-id');
            if (confirm('Deseja realmente excluir este registro?')) {
                $('#linha_' + _id).remove();
                $.post('modelos/model.usuarios.php', {acao: 'excluir', id: _id}, function (_result) {
                    if (_result == '1') {
                        alert('Registro excluído com sucesso!');
                    } else {
                        alert('Houve um erro ao tentar exluir este registro.' +
                                'Código do erro:' + _result);
                    }
                });
            }
        });


        //Sair
        $("#btnSair").click(function () {
            //if (confirm('Deseja realmente sair?')) {
            $.get('funcoes/funcao.sair.php', function () {
                window.location.href = "login";
            });
            //}
        });

        /**
         * Editar usuário
         * @type type
         */
        $(".btn-editar").click(function () {
            var _this = $(this), obj = JSON.parse(_this.attr('data-object')),
                    edit_nivel_acesso = document.getElementById('edit_nivel_acesso');
            $('#edit_username').val(obj.usu_username);
            $('#edit_user_id').val(obj.usu_id);
<?php
if ($obj->usu_acesso == 'admin') {
    ?>
                if (obj.usu_acesso == 'padrao') {
                    edit_nivel_acesso.selectedIndex = 2;
                } else if (obj.usu_acesso == 'admin') {
                    edit_nivel_acesso.selectedIndex = 1;
                }

    <?php
}
?>
            $('#modal_editar_usuario').modal('show');
        });
    </script>

</body>
</html>
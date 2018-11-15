<?php
include 'autoload.php';
if (isset($_SESSION['CONECTADO'])) {
    header("location:./");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta charset="utf-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Framework for PHP - Application Builder" />
        <meta name="author" content="" />
        <!-- Le styles -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <!--<link href="bootstrap/css/font-awesome.css" rel="stylesheet" />-->
        <link href="styles/builder.min.css" rel="stylesheet" />
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

        </style>
    </head>

    <div class="container">

        <form class="form-signin" method="POST" id="formLogin">
            <h2 class="form-signin-heading">Please sign in</h2>
            <input type="text" name="username" class="input-block-level" placeholder="Username" autofocus="">
            <input type="password" name="password" class="input-block-level" placeholder="Password">
            <button class="btn btn-large btn-primary" id="btnSubmit" type="submit">Sign in</button>
        </form>
    </div>
    <script src="scripts/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="scripts/jquery.form.js"></script>
    <script>
        $(document).ready(function () {
            var btn = $('#btnSubmit');

            $("#formLogin").ajaxForm({
                url: 'modelos/model.login.php',
                beforeSend: function () {
                    btn.html("Entrando, aguarde...").attr("disabled", true);
                },
                uploadProgress: function (event, position, total, percentComplete) {

                },
                success: function (data) {
                    if (data == '-1') {
                        alert('Usuário não encontrado.');
                        btn.html("Sign in").attr("disabled", false);
                    } else if (data == '0') {
                        alert('Usuário ou senha incorretos.');
                        btn.html("Sign in").attr("disabled", false);
                    } else if (data == '1') {

                        var url = new URL(window.location.href);
                        var c = url.searchParams.get("next");

                        if (c == null) {
                            window.location.href = "./discussoes.php";
                        } else {
                            window.location.href = "../discussoes.php" + c;
                        }
                    }
                },
                complete: function (xhr) {

                }
            });
        });
    </script>
</body>
</html>
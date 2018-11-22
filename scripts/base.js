/**
 * Descrição:
 * 
 * 
 * 
 * Desenvolvido por Taffarel Xavier.
 * <p style="font:bold 16px arial;">taffarel_deus@hotmail.com</p>
 */
$(document).ready(function () {

    var btnEnviar = $('#btnEnviar'),
            labelError = $('#labelError'),
            formEnviar = $('#formEnviarMsg'), editor = $('#msg'),
            btnClosePreviewImg = $("#btnFecharImgPreview"), isClipBoardImage = false,
            url = new URL(window.location.href);

    var _discussao = parseInt(url.searchParams.get("discussao"));

    /*Evento para quando clicar em enviar a mensagem*/
    btnEnviar.click(function () {
        if (editor.val().trim().length > 0) {
            formEnviar.submit();
        } else {
            if (isClipBoardImage == true) {
                labelError.html('Digite um título para sua imagem').show().delay(3000).fadeOut();
            } else {
                labelError.html('Digite alguma mensagem').show().delay(3000).fadeOut();
            }
            editor.focus();
        }
    });

    function rolarDown() {
        var topPos = screen.availHeight;
        $("#resultado").animate({scrollTop:
                    parseInt($('#resultado').prop("scrollHeight")) * topPos}, 1000);
    }

    rolarDown();

    //Atualiza os dados na hora do load
    $.get("../views/view.get_messages.php", {
        discussao_id: _discussao
    }, function (d) {
        getMensagens(d);
    });

    var cores = [
        '#99b433', '#00a300', '#1e7145', '#ff0097', '#7e3878', '#ee1111', '#2B70AD',
        '#1d1d1d', '#00aba9', '#2d89ef', '#2b5797', '#ffc40d', '#e3a21a', '#da532c'
    ];
    //Rolagem e mostra o botão
    $("#resultado").scroll(function (ev) {
        var scroll = $(this).scrollTop();
        if (scroll >= 150) {
            $('#goParaTopo').slideDown();
        } else {
            $('#goParaTopo').slideUp();
        }
    });

    function swipe(largeImage) {
        $(largeImage).css({display: 'block',
            width: 200 + "px",
            height: 200 + "px"
        });
        var url = $(largeImage).attr('src');

        var newWind = window.open('_top');
        newWind.document.write("<img src='" + url + "' />");
        newWind.document.title = "Visualização de Imagem";
    }

    function getMensagens(_data) {

        var obj = JSON.parse(_data), str = "", k = 0,
                dt = new Date(),
                dtRest = dt.getHours() + ':' + dt.getMinutes(),
                mensagemPadrao = "Esta é uma mensagem fixa";

        str += '<div class="row-fluid">' +
                '<div class="mensagens">' +
                '<p>' +
                '<b style="color:' + cores[6] + ' ">Usuário padrão.</b></p>' +
                '<p><pre>' +
                mensagemPadrao
                + '</pre></p>' +
                '<label class="text-info data-msg" title="' +
                dt.getDate() + "-" + (dt.getMonth() + 1) + '-' +
                dt.getFullYear() + '">' + dtRest + '</label>' +
                '<hr class="msg-hr"/></div>' +
                '</div>';


        $.each(obj, function (index, value) {

            dt = new Date(value.men_data * 1000),
                    dtRest = dt.getHours() + ':' + dt.getMinutes(),
                    img = "", _rand = parseInt(Math.random() * (cores.length - 0) + 0);

            //Verifica o tipo das mensagens:

            switch (value.men_tipo) {
                case "image":
                    img += "<a><img src='" + value.men_image + "' class='msg-imagens img-responsive'  /></a>";
                    break;
                case "arquivos":
                    if (value.imagens) {
                        if (value.imagens.length > 0) {
                            for (var im = 0; im < value.imagens.length; im++) {
                                img += "<a><img src='../uploads/" + value.imagens[im].arq_file_md5 +
                                        "' class='msg-imagens img-responsive'  /></a>";
                            }
                        }
                    }
                    break;
            }

            while (k < cores.length) {

                k++;
            }

            str += '<div class="row-fluid">' +
                    '<div class="mensagens">' +
                    '<p>' +
                    '<b style="color:' + cores[0] + ' ">&nbsp;<i>' + value.nome + '</i></b></p>' +
                    '<p><pre>' + value.men_mensagens + '</pre></p>' +
                    img +
                    '<div class="clearfix"></div><label class="text-info data-msg" title="' +
                    dt.getDate() + "-" + (dt.getMonth() + 1) + '-' +
                    dt.getFullYear() + '">' + dtRest + '</label>' +
                    '<hr class="msg-hr"/></div>' +
                    '</div>';
        });
        $('#resultado').html(str);

        /*ABRIR IMAGENS*/
        $(".msg-imagens").click(function () {
            var self = $(this);
            /*$('#getImagemSelected').attr('src', self.attr('src'));
             $('#modalAbrirImagens').modal('show');*/
            swipe(self);
        });
        //console.clear();
    }

    $('#goParaTopo').click(function () {
        var _self = $(this);
        _self.slideUp();
        $("#resultado").animate({scrollTop:
                    parseInt(0)}, 500);

    });

    //Paste from clipboard
    document.getElementById('msg').onpaste = function (event) {
        // use event.originalEvent.clipboard for newer chrome versions
        var items = (event.clipboardData || event.originalEvent.clipboardData).items;
        //console.log(JSON.stringify(items)); // will give you the mime types
        // find pasted image among pasted items
        var blob = null;
        for (var i = 0; i < items.length; i++) {
            if (items[i].type.indexOf("image") === 0) {
                blob = items[i].getAsFile();
            }
        }
        // load image if there is a pasted image
        if (blob !== null) {
            var reader = new FileReader();
            reader.onload = function (event) {
                console.log(event.target.result); // data url!
                $('#pastedImage').show();
                btnClosePreviewImg.show();
                $('#edit_imagem').val(event.target.result);
                $('#msg_tipo').val('image');
                isClipBoardImage = true;
                editor.attr("placeholder", "Digite um título para sua imagem");
                document.getElementById('pastedImage').src = event.target.result;
            };
            reader.readAsDataURL(blob);
        }
    };

    btnClosePreviewImg.click(function () {
        $(this).hide();
        $('#pastedImage').hide();
        $('#msg_tipo').val('text');
        editor.attr("placeholder", "Digite sua mensagem");
        isClipBoardImage = false;
    });

    //Long Polling
    $(this).LongPolling({
        nomeDaVariavelLocalStorage: "dados",
        url: "../views/view.get_messages.php",
        tempoCarregamento: 1000,
        metodo: "POST",
        dataHttp: {discussao_id: _discussao},
        objetoParaPreencher: '',
        receberDados: function (d) {
            getMensagens(d);
        }
    });

    editor.keyup(function (evt) {
        var _this = $(this);
        if (evt.keyCode == 13 && (evt.shiftKey | evt.ctrlKey)) {
            if (_this.val().trim().length > 0) {
                formEnviar.submit();
            } else {
                if (isClipBoardImage == true) {
                    labelError.html('Digite um título para sua imagem').show().delay(3000).fadeOut();
                } else {
                    labelError.html('Digite alguma mensagem').show().delay(3000).fadeOut();
                }
                editor.focus();
            }
        }
    });

    $(this).keyup(function (ev) {

        if (ev.altKey && ev.keyCode == 73) {
            document.getElementById('anexarArquivos').click();
        }
    });

    formEnviar.ajaxForm({
        url: '../modelos/model.mensagens.php',

        beforeSend: function () {

            if (document.getElementById('upload_imagem')) {

                /*ENVIAR ARQUIVOS*/
//                var _t = $('.img-upload-imagem');
//
//                var _files = [];
//
//                $.each(_t, function (ev, item) {
//                    _files.push($(item).attr("src"));
//                });
//                
//                _files.forEach(function (image, i) {
//                    _formData.append('image_' + i, image);
//                });

            }
            btnEnviar.html('<i class="fa fa-spinner fa-spin  fa-2x"></i>').attr("disabled", true);
        },
        uploadProgress: function (event, position, total, percentComplete) {

        },
        success: function (data) {
            if (data == '1') {
                btnEnviar.html("<i class='fa fa-paper-plane fa-2x' aria-hidden='true'></i>").attr("disabled", false);
                editor.val('').focus();
                rolarDown();
                $('#pastedImage, #gerResultImagesUploaded').hide();
                btnClosePreviewImg.hide();
                $('#msg_tipo').val('text');
            } else if (data == '2') {
                alert('Não foi possível fazer a alteração.');
            } else {
                alert('Houve um erro. Tente novamente.' + "\nCódigo do erro:" + data);
                btnEnviar.html("<i class='fa fa-paper-plane fa-2x' aria-hidden='true'></i>").attr("disabled", false);
            }
        },
        complete: function (xhr) {

        }
    });

    $("#btnSair").click(function () {
        //if (confirm('Deseja realmente sair?')) {
        $.get('funcoes/funcao.sair.php', function () {
            window.location.href = "login";
        });
        //}
    });

    $("#btnAnexarArquivos").click(function () {

    });

    var names = [], ids = [], formUploaded = $("#formUploadFiles");

    $('#anexarArquivos').change(function () {

        $('#displayImagensAnexos').css({height: 'auto'}).show();

        var elem = document.getElementById("anexarArquivos");

        var novoFiles = "";

        for (var k = 0; k < elem.files.length; ++k) {

            names.push(elem.files[k].name);

            console.log(elem.files[k].size);

            console.log(elem.files[k].type);

            console.log(elem.files[k].name);

            ids.push('file_' + k);

            formUploaded.submit();

        }
        $("#mostrarArquivos").html(novoFiles);
    });


    $("#btnDefinirPropt").click(function () {
    });

    formUploaded.ajaxForm({
        beforeSend: function () {

        },
        uploadProgress: function (event, position, total, percentComplete) {

        },
        success: function (data) {
            $('#gerResultImagesUploaded').html(data);
        },
        complete: function (xhr) {

        }
    });
});
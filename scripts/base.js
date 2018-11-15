$(document).ready(function () {

    var btnEnviar = $('#btnEnviar'),
            labelError = $('#labelError'),
            formEnviar = $('#formEnviarMsg'), editor = $('#msg'),
            btnClosePreviewImg = $("#btnFecharImgPreview"), isClipBoardImage = false,
            url = new URL(window.location.href);

    var _discussao = parseInt(url.searchParams.get("discussao"));

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
    $.get("views/view.get_messages.php", {
        discussao_id: _discussao
    }, function (d) {
        getMensagens(d);
    });

    var cores = [
        '#99b433', '#00a300', '#1e7145', '#ff0097', '#7e3878', '#ee1111',
        '#1d1d1d', '#00aba9', '#2d89ef', '#2b5797', '#ffc40d', '#e3a21a', '#da532c'
    ];

    function getMensagens(_data) {

        var obj = JSON.parse(_data), str = "", k = 0;

        $.each(obj, function (index, value) {
            //console.log(value);
            var dt = new Date(value.men_data * 1000),
                    dtRest = dt.getHours() + ':' + dt.getMinutes(),
                    img = "", _rand = parseInt(Math.random() * (cores.length - 0) + 0);
            if (value.men_tipo == 'image') {
                img += "<a><img src='" + value.men_image + "' class='imagens img-responsive'  /></a>";
            }

            while (k < cores.length) {
                k++;
            }

            str += '<div class="row-fluid">' +
                    '<div class="mensagens">' +
                    '<p><img src="img/avatar.png" />' +
                    '<b style="color:' + cores[_rand] + ' ">&nbsp;<i>' + value.nome + '</i></b></p>' +
                    '<p><pre>' + value.men_mensagens + '</pre></p>' +
                    img +
                    '<label class="text-info data-msg" title="' +
                    dt.getDate() + "-" + (dt.getMonth() + 1) + '-' +
                    dt.getFullYear() + '">' + dtRest + '</label>' +
                    '</div>' +
                    '</div>';
        });
        $('#resultado').html(str);
        //console.clear();
    }

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
        url: "views/view.get_messages.php",
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
        if (evt.keyCode == 13 && !evt.shiftKey) {
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

    formEnviar.ajaxForm({
        url: 'modelos/model.mensagens.php',
        beforeSend: function () {
            btnEnviar.html("Enviando, aguarde, por favor.").attr("disabled", true);
        },
        uploadProgress: function (event, position, total, percentComplete) {

        },
        success: function (data) {
            if (data == '1') {
                btnEnviar.html("Enviar").attr("disabled", false);
                editor.val('').focus();
                rolarDown();
                $('#pastedImage').hide();
                btnClosePreviewImg.hide();
                $('#msg_tipo').val('text');
            } else if (data == '2') {
                alert('Não foi possível fazer a alteração.');
            } else {
                alert('Houve um erro. Tente novamente.' + "\nCódigo do erro:" + data);
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
});
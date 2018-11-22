<style>
    .img-display-block{
        float:left !important;
        max-width: 100px;
        margin:2px;
        height: 100px;
        position: relative !important;
        text-align: center !important;
        float:left !important;
    }
    .img-label-name{
        font-size:10px !important;
        background: rgba(0,0,0,0.5) !important;
        color:white !important;
        position: absolute !important;
        width:100% !important;
        height: 20px !important;
        bottom:0px !important;
        overflow: hidden !important;
        word-break: keep-all !important;
    }
    .img-upload-imagem{
        max-width: 90% !important;
        min-width: 90% !important;
        min-height: 90% !important;
        max-height: 90% !important;
        float:left !important;   
    }
    .upload-button-close{
        position: absolute;
        right:2px;
        top:2px;
        color:red;
        cursor:pointer;
    }
</style>
<?php
// Count # of uploaded files in array
$total = count($_FILES['files']['name']);

// Loop through each file
for ($i = 0; $i < $total; $i++) {

    $errors = array();

    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

    $file_name = $_FILES['files']['name'][$i];

    $file_size = $_FILES['files']['size'][$i];

    $file_tmp = $_FILES['files']['tmp_name'][$i];

    $file_ext = "";

    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);

    $data = file_get_contents($file_tmp);

    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>

    <div class="img-display-block" id="img_display_block<?php echo $i; ?>" data-path="<?php echo $file_tmp; ?>">
        <input type="hidden" value="<?php echo $base64; ?>" name="imagens[<?php echo $i; ?>]" />
        <i class="fas fa-times fa-2x upload-button-close" data-id="<?php echo $i; ?>"></i>
        <label class="img-label-name"><?php echo $file_name; ?></label>
        <input type="hidden" value="<?php echo $file_name; ?>" name="nomes_files[<?php echo $i; ?>]" />
        <img src="<?php echo $base64; ?>" class="img-upload-imagem img-polaroid" />
    </div>
    <?php
}
?>
<input type="hidden" id="upload_imagem" value="true" name="upload_imagem" />
<script>
    $(".upload-button-close").click(function () {
        var _self = $(this), _id = _self.attr("data-id");
        $("#img_display_block" + _id).slideUp().remove();
    });
    
    $("#msg_tipo").val("arquivos");
</script>
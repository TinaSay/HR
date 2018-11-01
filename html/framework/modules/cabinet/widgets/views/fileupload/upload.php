<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-upload fade">
        <div class="preview"></div>
        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
        </div>
        <div class="upload-info">
           <p class="name">{%=file.name%}</p> 
           <p class="size"><?= Yii::t('fileupload', 'Processing') ?>...</p>
        </div>
        <div class="error text-danger"></div>
        <div class="upload-btn">
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-prime start" disabled>
                    <span><?= Yii::t('fileupload', 'Start') ?></span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-prime cancel">
                    <span><?= Yii::t('fileupload', 'Cancel') ?></span>
                </button>
            {% } %}
        </div>     
    </div>
{% } %}
</script>
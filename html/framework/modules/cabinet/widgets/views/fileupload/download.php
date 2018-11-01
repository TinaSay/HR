<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-download fade">    
            <div class="download-info">
                {% if (file.error) { %}
                    <div class="download-massege massege-error"><?= Yii::t('fileupload', 'Error') ?> {%=file.error%}</div>
                {% } else { %}
                    <div class="download-massege massege-success">Ваше видео {%=file.name%} ({%=o.formatFileSize(file.size)%}) загружено</div>
                {% } %} 
            </div>
        <?php /*
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger"><?= Yii::t('fileupload', 'Error') ?></span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        */ ?>
        <?php /*
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span><?= Yii::t('fileupload', 'Delete') ?></span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span><?= Yii::t('fileupload', 'Cancel') ?></span>
                </button>
            {% } %}
        </td>
 */ ?>
    </div>
{% } %}

</script>

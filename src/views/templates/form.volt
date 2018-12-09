{{ content() }}
{% if params['box'] is defined and params['box'] is true %}
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ params['title'] }}</h3>
    </div>
{% endif %}
    {{ form(router.getRewriteUri(), 'class': 'form-horizontal') }}
        <div class="box-body">
            {% for formGroup in contents %}
                {{ formGroup }}
            {% endfor %}
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {% if router.getActionName() is 'update' %}
                {% set popoverContent = '<a href="' ~ url([router.getModuleName(), router.getControllerName(), 'delete', id]|join('/')) ~ '" class="btn btn-sm btn-danger">Yes</a> <a role="button" class="btn btn-sm btn-default">No</a>' %}
                <a tabindex="0" role="button" data-toggle="popover" title="Are you sure?" data-content="{{ popoverContent|e }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete Data</a>
            {% endif %}
            {{ submit_button('Save', 'class': 'pull-right btn btn-lg btn-success') }}
        </div>
        <!-- /.box-footer -->
    </form>
{% if params['box'] is defined and params['box'] is true %}    
</div>
{% endif %}

{% do assets.addInlineJs(view.getPartial(view.getLayoutsDir() ~ '/../templates/form.js')) %}
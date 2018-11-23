{{ content() }}
{{ flashSession.output() }}
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ router.getActionName()|capitalize }}</h3>
    </div>
    {{ form(router.getRewriteUri(), 'class': 'form-horizontal') }}
        <div class="box-body">
            <div class="form-group">
                <label for="user[username]" class="col-sm-2 control-label">Username</label>

                <div class="col-sm-10">
                    {{ text_field('profile[username]', 'class': 'form-control', 'placeholder': 'Username', 'autofocus': '') }}
                </div>
            </div>
            <div class="form-group">
                <label for="user[password]" class="col-sm-2 control-label">Password</label>

                <div class="col-sm-10">
                    {{ password_field('profile[password]', 'class': 'form-control', 'placeholder': 'Password') }}
                </div>
            </div>
        </div>
        <div class="box-footer">
            {% set popoverContent = '<a href="' ~ url(router.getModuleName() ~ '/users/deleteAccount') ~ '" class="btn btn-sm btn-danger">Yes</a> <a role="button" class="btn btn-sm btn-default">No</a>' %}
            <a tabindex="0" role="button" data-toggle="popover" title="Are you sure?" data-content="{{ popoverContent|e }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete Account</a>
            {{ submit_button('Save', 'class': 'btn btn-lg btn-success pull-right', 'data-loading-text': 'Loading...') }}
        </div>
    </form>
</div>
    
{% do assets.addInlineJs(view.getPartial('administrators/profile.js')) %}
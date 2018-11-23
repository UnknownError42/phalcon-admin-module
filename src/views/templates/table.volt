{{ flashSession.output() }}
{% if params['box'] is defined and params['box'] is true %}
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Listing data</h3>
        <div class="pull-right">
            {% if acl.isAllowed(identity.profile.name, router.getControllerName(), 'create') %}
                <a href="{{ url([router.getModuleName(), router.getControllerName(), 'create']|join('/')) }}" class="btn btn-default" title="Add New"><i class="fa fa-plus"></i></a>
            {% endif %}
        </div>
    </div>
    <div class="box-body">
{% endif %}
        <table id="datatable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    {% for column in contents %}
                        {{ column.render() }}
                    {% endfor %}
                </tr>
            </thead>
        </table>
{% if params['box'] is defined and params['box'] is true %}
    </div>
</div>
{% endif %}
<div class="form-group">
    <label for="{{ params[0] }}" class="col-sm-2 control-label">{{ params['label'] }}</label>

    <div class="col-sm-10">
        {% for field in contents %}
            {{ field }}
        {% endfor %}
    </div>
</div>
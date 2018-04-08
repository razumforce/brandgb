{% extends 'base.tmpl' %}

{% block content %}
{% include 'header-bc.tmpl' %}

<div class="container-w">

  {% if isAuth == false %}
    {% include 'register-main.tmpl' %}
  {% else %}
    <script>window.location = './profile'</script>
  {% endif %}

</div>

{% endblock %}


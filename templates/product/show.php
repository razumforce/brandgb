{% extends 'base.tmpl' %}

{% block content %}
{% include 'header-bc.tmpl' %}

{% include 'slider-single.tmpl' %}

<div class="container-w">

  {% include 'single-item.tmpl' %}

  {% include 'product-maylike.tmpl' %}

</div>

{% endblock %}

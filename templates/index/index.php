{% extends 'base.tmpl' %}

{% block content %}
{% include 'slider-big.tmpl' %}

<div class="container-w">

  {% include 'catalog-index.tmpl' %}

  {% include 'product-featured.tmpl' %}

  {% include 'special-ad.tmpl' %}

</div>

{% endblock %}


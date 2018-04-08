{% extends 'base.tmpl' %}

{% block content %}
{% include 'header-bc.tmpl' %}

<div class="container-w">
  <div class="product-main-wrapper">

    {% include 'product-left-nav.tmpl' %}

    <section class="product-choice">

      {% include 'product-choice-controls.tmpl' %}

      {% include 'product-main.tmpl' %}

    </section>

  </div>

  <div class="clearfix"></div>

  {% include 'special-product.tmpl' %}

</div>

{% endblock %}


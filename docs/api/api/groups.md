# Groups

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/groups/:year/:type\[/:id\]" %}
{% api-method-summary %}
Get groups
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get information about groups.  
If you need a list of available elections types, see Types.
{% endapi-method-description %}

{% api-method-spec %}
{% api-method-request %}
{% api-method-path-parameters %}
{% api-method-parameter name="year" type="integer" required=true %}
Year of the elections.
{% endapi-method-parameter %}

{% api-method-parameter name="type" type="string" required=true %}
Type of the elections \(see Types\).
{% endapi-method-parameter %}

{% api-method-parameter name="id" type="integer" %}
ID of the group.
{% endapi-method-parameter %}
{% endapi-method-path-parameters %}

{% api-method-query-parameters %}
{% api-method-parameter name="test" type="boolean" %}
Use **test** data instead of real data.
{% endapi-method-parameter %}
{% endapi-method-query-parameters %}
{% endapi-method-request %}

{% api-method-response %}
{% api-method-response-example httpCode=200 %}
{% api-method-response-example-description %}

{% endapi-method-response-example-description %}

```javascript

```
{% endapi-method-response-example %}
{% endapi-method-response %}
{% endapi-method-spec %}
{% endapi-method %}

{% page-ref page="../../more-information/types.md" %}


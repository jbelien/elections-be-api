# Lists

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/lists/:year/:type\[/:id\]" %}
{% api-method-summary %}
Get lists
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get information about lists.  
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
ID of the list.
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

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/lists/:year/:type/group/:group" %}
{% api-method-summary %}
Get lists by group
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get information about lists filtered by group.  
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

{% api-method-parameter name="group" type="integer" required=true %}
ID of the group.
{% endapi-method-parameter %}
{% endapi-method-path-parameters %}

{% api-method-query-parameters %}
{% api-method-parameter name="test" type="boolean" %}
Use **test** data instead of real data.
{% endapi-method-parameter %}

{% api-method-parameter name="final" type="boolean" %}
Use **final** test data instead of **intermediate** test data.
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

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/lists/:year/:type/entity/:entity" %}
{% api-method-summary %}
Get lists by entity
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get information about lists filtered by entity.  
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

{% api-method-parameter name="entity" type="integer" required=true %}
ID of the entity.
{% endapi-method-parameter %}
{% endapi-method-path-parameters %}

{% api-method-query-parameters %}
{% api-method-parameter name="test" type="boolean" %}
Use **test** data instead of real data.
{% endapi-method-parameter %}

{% api-method-parameter name="final" type="boolean" %}
Use **final** test data instead of **intermediate** test data.
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


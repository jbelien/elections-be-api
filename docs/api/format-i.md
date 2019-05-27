---
description: Initial data
---

# Format I

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/format-i/entities/:year/:type" %}
{% api-method-summary %}
Get entities
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get all the entities for specific elections.  
If you need the list of the available elections types, see Types.
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
{% endapi-method-path-parameters %}

{% api-method-query-parameters %}
{% api-method-parameter name="test" type="boolean" required=false %}
Use **test** data instead of real data.
{% endapi-method-parameter %}

{% api-method-parameter name="final" type="boolean" required=false %}
Use **final** test data instead of **intermediate** test data.
{% endapi-method-parameter %}
{% endapi-method-query-parameters %}
{% endapi-method-request %}

{% api-method-response %}
{% api-method-response-example httpCode=200 %}
{% api-method-response-example-description %}

{% endapi-method-response-example-description %}

```javascript
{
  "1101": {
    "id": 1101,
    "level": "K",
    "name_fr": "Votes Émis Dans le Canton de Rhode-Saint-Genèse",
    "name_nl": "Stemmen Uitgebracht In het Kanton Sint-Genesius-Rode",
    "name_de": "Stimmabgabe Im Kanton Sint-Genesius-Rode",
    "name_en": "Voted In The District of Rhode-Saint-Genèse/sint-Genesius-Rode",
    "nis": "1101",
    "parent": "21004",
    "electronic": true,
    "stations": 44,
    "max_official": 0,
    "max_substitues": 0,
    "registrations": {
      "BB": 44429,
      "E1_E2": 127,
      "E3_E4": 0,
      "E5": 0
    }
  },
  ...
}
```
{% endapi-method-response-example %}
{% endapi-method-response %}
{% endapi-method-spec %}
{% endapi-method %}

{% page-ref page="../types.md" %}

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/format-i/groups/:year/:type" %}
{% api-method-summary %}
Get groups
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get all the groups for specific elections.  
If you need the list of the available elections types, see Types.
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
{
  "307": {
    "id": 307,
    "name": "Piratenpartij",
    "color": "CCCCCC",
    "previous": {
      "name": "Piratenpartij",
      "id": 2000095
    }
  },
  ...
}
```
{% endapi-method-response-example %}
{% endapi-method-response %}
{% endapi-method-spec %}
{% endapi-method %}

{% page-ref page="../types.md" %}


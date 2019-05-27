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
If you need the list of available elections types, see Types.
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

{% page-ref page="../more-information/types.md" %}

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/format-i/groups/:year/:type" %}
{% api-method-summary %}
Get groups
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get all the groups for specific elections.  
If you need the list of available elections types, see Types.
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

{% page-ref page="../more-information/types.md" %}

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/format-i/list/:year/:type" %}
{% api-method-summary %}
Get lists
{% endapi-method-summary %}

{% api-method-description %}
This endpoint allows you to get all the lists for specific elections.  
If you need the list of available elections types, see Types.
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
  "1377": {
    "id": 1377,
    "name": "ECOLO",
    "lang": "FF",
    "nr": 2,
    "group": {
      "id": 326,
      "name": "ECOLO",
      "color": "C1E331",
      "previous": {
        "name": "Ecolo",
        "id": 2000046
      }
    },
    "entity": {
      "id": 2227,
      "level": "C",
      "name_fr": "Circonscription de Namur",
      "name_nl": "Kieskring Namen",
      "name_de": "Wahlkreis Namur",
      "name_en": "Constituency of Namur",
      "nis": "2227",
      "parent": null,
      "electronic": false,
      "stations": 20,
      "max_official": 6,
      "max_substitues": 6,
      "registrations": {
        "BB": 371574,
        "E1_E2": 1528,
        "E3_E4": 878,
        "E5": 5319
      }
    },
    "previous": {
      "name": "Ecolo",
      "id": 2000046
    }
  },
  ...
}
```
{% endapi-method-response-example %}
{% endapi-method-response %}
{% endapi-method-spec %}
{% endapi-method %}

{% page-ref page="../more-information/types.md" %}

{% api-method method="get" host="https://api.elections.openknowledge.be" path="/format-i/candidates/:year/:type" %}
{% api-method-summary %}
Get candidates
{% endapi-method-summary %}

{% api-method-description %}

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
  "29704": {
    "id": 29704,
    "level": "C",
    "nr": 1,
    "name": "DETOMBE Willy",
    "type": "S",
    "gender": "U",
    "birthdate": "00/00/0000",
    "list": {
      "id": 1473,
      "name": "DéFI",
      "lang": "FF",
      "nr": 11,
      "group": {
        "id": 304,
        "name": "DéFI",
        "color": "D70077",
        "previous": {
          "name": "FDF",
          "id": 2000074
        }
      },
      "entity": {
        "id": 2224,
        "level": "C",
        "name_fr": "Circonscription de Hainaut",
        "name_nl": "Kieskring Henegouwen",
        "name_de": "Wahlkreis Hennegau",
        "name_en": "Constituency of Hainaut",
        "nis": "2224",
        "parent": null,
        "electronic": false,
        "stations": 0,
        "max_official": 18,
        "max_substitues": 10,
        "registrations": {
          "BB": 923330,
          "E1_E2": 4332,
          "E3_E4": 1751,
          "E5": 13376
        }
      },
      "previous": {
        "name": "FDF",
        "id": 2000074
      }
    }
  },
  ...
}
```
{% endapi-method-response-example %}
{% endapi-method-response %}
{% endapi-method-spec %}
{% endapi-method %}

{% page-ref page="../more-information/types.md" %}


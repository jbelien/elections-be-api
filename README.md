# Belgian Elections API

**Work in progress**

## Usage

`type` can be one of the following :

- CK : Chambre / Kamer
- VL : Parlement flamand / Vlaams Parlement
- WL : Parlement régional wallon / Waals Parlement
- BR : Parlement de la Région de Bruxelles-Capitale / Brussels Hoofdstedelijk Parlement
- DE : Parlement de la Communauté germanophone / Parlement van de Duitstalige Gemeenschap
- EU : Parlement européen / Europese Parlement
- PR : Conseil provincial / Provincieraden
- CG : Conseil communal / Gemeenteraden
- CS : Conseil CPAS / OCMWraden
- DI : Conseil de district (Anvers) / Districtraden (in Antwerpen)

`level` can be one of the following (some combinations are not available though) :

- M : Bureau principal de commune / Gemeentehoofdbureau
- K : Bureau principal de canton / Kantonhoofdbureau
- D : Bureau principal de district / Stadsdistricthoofdbureau
- A : Bureau principal d’arrondissement / Arrondissementshoofdbureau
- C : Bureau principal de circonscription / Kieskringhoofdbureau
- G : Bureau principal de la circonscription germanophone / Hoofdbureau van de Duitstalige kieskring
- O : Bureau central de province / Centraal provinciaal bureau
- P : Bureau principal provincial / Provinciehoofdbureau
- L : Bureau principal de collège / Collegehoofdbureau
- R : Royaume / Koninkrijk

### Initial data (Format I)

GET `/format-i/entities/{year:[0-9]{4}}/{type:\w+}` will give you the list of entities.

Example: <https://api.elections.openknowledge.be/format-i/entities/2019/CK>

GET `/format-i/groups/{year:[0-9]{4}}/{type:\w+}` will give you the political groups.

Example: <https://api.elections.openknowledge.be/format-i/groups/2019/CK>

GET `/format-i/lists/{year:[0-9]{4}}/{type:\w+}` will give you the political lists.

Example: <https://api.elections.openknowledge.be/format-i/lists/2019/CK>

GET  `/format-i/candidates/{year:[0-9]{4}}/{type:\w+}` will give you the political candidates.

Example: <https://api.elections.openknowledge.be/format-i/candidates/2019/CK>

### Results data (Format R)

**Warning: those are obviously TEST data !**

GET `/format-r/evolution/{year:[0-9]{4}}/{type:\w+}` will give you the evolution of the results.

Example (temporary test results): <https://api.elections.openknowledge.be/format-r/evolution/2019/CK?test>  
Example (final test results): <https://api.elections.openknowledge.be/format-r/evolution/2019/CK?test>

GET `/format-r/results/{year:[0-9]{4}}/{type:\w+}` will give you the results.

Example (temporary test results): <https://api.elections.openknowledge.be/format-r/results/2019/CK?test>  
Example (final test results): <https://api.elections.openknowledge.be/format-r/results/2019/CK?test>

GET `/format-r/results/{year:[0-9]{4}}/{type:\w+}/{level:\w+}` will give you the detailed results.

Example (temporary test detailed results): <https://api.elections.openknowledge.be/format-r/results/2019/CK/C?test>  
Example (final test detailed results): <https://api.elections.openknowledge.be/format-r/results/2019/CK/C?test>

GET `/format-r/status/{year:[0-9]{4}}/{type:\w+}/{level:\w+}` will give you the status the count.

Example (temporary test status): <https://api.elections.openknowledge.be/format-r/status/2019/CK/C?test>  
Example (final test status): <https://api.elections.openknowledge.be/format-r/status/2019/CK/C?test>

---

## More information

- BB : Belgians, entitled to vote and living in the Kingdom of Belgium.
- E1 + E2 : Belgians, entitled to vote and living outside Belgium, who will vote in person or by proxy in a municipality of the Kingdom of Belgium.
- E3 + E4 : Belgians, entitled to vote and living outside Belgium, who will vote in person or by proxy in the Belgian diplomatic or consular - professional post where the person has chosen to subscribe himself.
- E5 : Belgians, entitled to vote and living outside Belgium, who will vote by letter.

> Source: <http://polling2014.belgium.be/en/cha/results/results_tab_CKR00000.html>
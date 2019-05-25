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

GET `/format-r/results/{year:[0-9]{4}}/{type:\w+}` will give you the results.

Example (temporary test results): <https://api.elections.openknowledge.be/format-r/results/2019/CK?test>  
Example (final test results): <https://api.elections.openknowledge.be/format-r/results/2019/CK?test>

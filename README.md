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

GET `/format-i/entities/{year:[0-9]{4}}/{type:\w+}`

will give you the list of entities.

GET `/format-i/groups/{year:[0-9]{4}}/{type:\w+}`

will give you the political groups.

GET `/format-i/lists/{year:[0-9]{4}}/{type:\w+}`

will give you the political lists.

GET  `/format-i/candidates/{year:[0-9]{4}}/{type:\w+}`

will give you the political candidates.


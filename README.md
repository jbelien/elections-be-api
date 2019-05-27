# Open Knowledge Belgium - Elections API

🚧 **Work in progress** 🚧

## Documentation

📝 Have a look at <https://docs.elections.openknowledge.be/> !

---

### Results data (Format R)

**Not yet documented on <https://docs.elections.openknowledge.be/>**

GET `/format-r/evolution/{year:[0-9]{4}}/{type:\w+}` will give you the evolution of the results.

Example: <https://api.elections.openknowledge.be/format-r/evolution/2019/CK>  

GET `/format-r/results/{year:[0-9]{4}}/{type:\w+}` will give you the results.

Example: <https://api.elections.openknowledge.be/format-r/results/2019/CK>  

GET `/format-r/results/{year:[0-9]{4}}/{type:\w+}/{level:\w+}` will give you the detailed results.

Example: <https://api.elections.openknowledge.be/format-r/results/2019/CK/C>  

GET `/format-r/status/{year:[0-9]{4}}/{type:\w+}/{level:\w+}` will give you the status the count.

Example: <https://api.elections.openknowledge.be/format-r/status/2019/CK/C>  

GET `/format-r/seats/{year:[0-9]{4}}/{type:\w+}` will give you the number of seats.

Example: <https://api.elections.openknowledge.be/format-r/seats/2019/CK>  

GET `/format-r/hit/{year:[0-9]{4}}/{type:\w+}/{level:\w+}` will give you the *hit-parade*.

Example: <https://api.elections.openknowledge.be/format-r/hit/2019/CK/R>  

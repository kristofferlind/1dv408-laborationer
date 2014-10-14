#Seminarie - Kodkvalitet

####Fick du igång din tilldelade källkod lokalt?
Ja

#####Följde det med någon sorts instruktioner?
Nej

####Gick den publika applikationen du fick tilldelad igenom testfallen?
Nej, men det var bara detaljer som var fel

#####Vad gjorde att den gick igenom testfallen?
Överlag bra kod som gick igenom alla tester bortsett detaljer

#####Vad gjorde att den inte gick igenom testfallen?
* Cookie togs inte bort vid felaktig inloggning via cookies
* w3c validering gav 3 fel

####Vad var tydligt respektive otydligt i källkoden? Tänk på att det alltid går att hitta något åt båda hållen.

#####Tydligt
* Bra namngivning av metoder och klasser
* Lätt att följa

#####Otydligt
* Brist på kommentarer

####Fanns det ett genomgående “tänk” i källkoden?
Koden följde mvc "arkitektur" och hade en tydlig uppdelning av klasser

#####Fanns det fördelar med detta tänk? Vilka?
MVC är ett bra mönster att följa 

#####Fanns det nackdelar med detta tänk? Vilka?
Det är dock ingen arkitektur i sig, jag gillar inte alls filstrukturen det blivit av att låta det stå i centrum, är som att sortera genom att kasta saker i 3 olika högar.

####Fanns det något du upplevde som “fulhack”i källkoden du fick tilldelad?
Jag upptäckte inga fulhack, kanske till viss del för att koden var lättarbetad och jag inte behövde rota speciellt mycket i existerande kod.


###Reflektioner

####Positivt
* Gillade användningen av associativa arrayer för transport av data mellan metoder.
* Databas var redan implementerat, gjorde att jag kunde bli klar med laborationen väldigt snabbt.
* Intressant lösning med check i consts.php, alternativa lösningar: chmod och kanske modrewrite, men det är nog inte tillgängligt på alla värdar
* Är överlag väldigt tacksam över koden jag fick att bearbeta, förmodligen många som inte hade lika mycket tur.

####Negativt
* Lösenord var i klartext vid inmatning, samt sparades i klartext i databas, dock sparades lösenord aldrig i cookie, vilket gör att det klarade sig sett till testfallen
* Beskrivning/export av databas saknades, steg 1 fick bli att dissikera kod och komma fram till hur denna skulle se ut för att få igång applikationen
* Parametrar användes inte för dal
* Mängden stavfel gjorde att man tappade flytet lite i genomgången
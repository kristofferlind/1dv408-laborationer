#PHPProjise
A very simple php version of (https://github.com/kristofferlind/projise).
Only project and story management, no realtime updates or collaboration.

##Documentation
Requirements and use cases can be found in docs folder. 

###Class diagram
I couldn't find a decent tool for generating class diagrams. Visual paradigm was supposed to have it, but not available in my version. Built one by putting together results from a bunch of generated diagrams (tool could only figure out parts) which i have then edited. It's kind of chaotic so I'm pretty confident I've missed something, but here it is: [Class diagram](http://yuml.me/b484550a)

##Demo
Executable demo available at: (http://krad.se/temp/1dv408/project/)
testdata: user: test, pass: testar
The project "Projise" has the most testdata.

##Installation
* Set environment variables in config/settings.php
* Create database with the name you set in settings
* Load up index.php?section=install (just import projise.sql if this step fails)
* Comment/remove install route

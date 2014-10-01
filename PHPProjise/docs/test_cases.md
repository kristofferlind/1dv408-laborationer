#Test cases
Tests done 2/10-14
##Authentication
 - [x] Login fails for wrong password (test/blubb)
 - [x] Login remembers name
 - [x] Login successful for correct credentials (test/testar)
 - [x] Login successful using correct cookie
 - [] Logout successful

##Register
####Validation - (name = min 3 max 50, password = min 6)
 - [x] Register fails for bad data
 - [x] Register fails for passwords not matching
 - [x] Register fails for name in use
 - [x] Register remembers name
 - [x] Register successful for correct data
 - [x] Login works for new account

##Project
####Validation - (name = max 50, description = max 250)
 - [] Create project fails on missing data
 - [] Create project fails on bad data 
 - [x] Create project successful for correct data
 - [] Edit project fails for missing data
 - [] Edit project fails for bad data
 - [x] Edit project successful for correct data
 - [x] Remove project successful
 - [x] View projects shows list of projects
 - [x] Activate project successful

##Story
####Validation - (name = max 50, description = max 250)
 - [] Create story fails for missing data
 - [] Create story fails for bad data 
 - [x] Create story successful on correct data
 - [] Edit story fails for missing data
 - [] Edit story fails for bad data
 - [x] Edit story successful on correct data
 - [x] Remove story successful
 - [x] View stories shows lists of stories (not done, in progress, finished)
 - [x] Work on story puts story in progress
 - [x] Cancel work on story puts story back in not done
 - [x] Finish story puts story in finished

##Routing
 - [x] User stays logged in when changing page
 - [x] Request story section fails on no active project
 - [x] Request any section sends user to login if not authed

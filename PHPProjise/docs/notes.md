felhantering mot basecontroller:
döpa om isValid till isCreated och efterföljande isCreated till isSaved


design
--
/
index->load stuff (?controller determines controller)
/account
	accountcontroller (action determines subcontroller)
	/login
	/register
/project
	projectcontroller (extends authcontroller,action determines subcontroller)
	/create
	/list (default)
	/edit
	/delete
/story
	storycontroller (extends authcontroller, action determines subcontroller )
	/create
	/list (default)
	/edit
	/delete

/components
	/base
		BaseController
	/auth
		authcontroller (check auth, redirect to login on fail)
	/notify (notifications)
	/response (handle output)
	/cookieservice (cookie management)
	/sessionservice
	/router (build this?`, {controller}/{action}) - probably unnecessarily complex



documents - (does mongodb work ok with php?) would require using mongolabs or similar, maybe openshift?

+easy to work with
+ability to share some sample data with real project
-cant deploy on binero
-unstable driver?

--
user
	userId
	username
	hashedPassword
	salt
	activeProject
	activeStory
	projects = []

project
	projectId
	name
	description
	users = []

story
	storyId
	projectId
	name
	description
	status


tables - (if mysql is used instead) can be run on binero
+can be deployed on binero
+stable drivers
-crappy to work with

user
	userId
	username
	hashedPassword
	salt
	activeProject
	activeStory

userProjects
	userId
	projectId

projects
	projectId
	name
	description

projectMembers
	projectId
	userId

story
	storyId
	projectId
	name
	description
	storyStatusId

storyStatus
	storyStatusId
	status









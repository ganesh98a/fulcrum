React Native Mobile App REST API Services (RNMARESTAPIS) With PHP Using Zend Framework Library
	
Note : We have using the Authorization Bearer token for validating purpose

	1. We have maintain this separately from web services.
	2. The library Folder has maintain in "engine/include/lib/common/Api/" Folder.
	3. In case of any changes on flow or functionality in web, we need to implement that same as mobile api bcz we (Refer 1 point).
	4. Files Name has maintain by unique key as "RN"
	5. This Services has return the response with json format.
	6. we need to include the /Auth/AuthAccess.php with token parameter for security purpose
	7. After login we need to pass the token in all services call
	8.



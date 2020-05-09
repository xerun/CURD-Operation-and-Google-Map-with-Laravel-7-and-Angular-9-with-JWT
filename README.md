# CURD-Operation-and-Google-Map-with-Laravel-7-and-Angular-9-with-JWT
CURD Operation and Google Map with Laravel 7 and Angular 9 with JWT

## Demostration of the application in action
![Alt Text](https://github.com/xerun/CURD-Operation-and-Google-Map-with-Laravel-7-and-Angular-9-with-JWT/blob/master/My%20Video.gif)


## Database Design
I designed the database in MySQL based on the concept that one Location can have multiple Labs. Therefore, one to many relationships between Location and Lab was created.
 
Depending on the above relation a Lab much have a Location, but a Location may have zero or many Labs.  

## Backend API (labapi)
The backend api was developed in Laravel Framework 7.10.3, I created two models Lab and Location and migrated it to the database. I created CRUD operation for both Lab and Location Controllers.
I used the command php artisan make:model Lab -m to create the model and also migration file using the -m option.  

Then I created two API resources to deal with single Lab and collection of Labs with the following commands.  
php artisan make:resource Lab  
php artisan make:resource LabCollection  

I created the controller with php artisan make:controller LabController and added CRUD operation in them with validation check for insert and update.  
 
Since the api has login feature I chose JSON Web Token (JWT) for authentication between the backend and the frontend.  
I added the JWT using the command composer require tymon/jwt-auth "1.0.*"  and added the jwt-auth config file using the command below then added the secret key  
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
Added the JWTSubject interface in User class  
 
## Route:
 
For every route the system first authenticates if the token is valid before it gives permission to access the data.  
URL: http://127.0.0.1:8000/api/login
Action: User login
Method: Post
Response: {
    "id": 1,
    "name": "Prithu",
    "email": "mail@prithu.me",
    "password": "",
    "access_token": "eyJ0eXAiOiJKV1QiL",
    "token_type": "bearer",
    "expires_in": 3600
}  
URL: http://127.0.0.1:8000/api/labs
Action: Get all labs
Method: Get
Response: {
    "data": [
        {
            "id": 4,
            "name": "Lab-1",
            "location_id": 1,
            "location_name": "Newnham Campus Seneca College",
            "created_at": "2020-05-08",
            "updated_at": "2020-05-08"
        }
    ]
}  
URL: http://127.0.0.1:8000/api/labs/1
Action: Get specific labs
Method: Get
Response: {
    "data": [
        {
            "id": 4,
            "name": "Lab-1",
            "location_id": 1,
            "location_name": "Newnham Campus Seneca College",
            "created_at": "2020-05-08",
            "updated_at": "2020-05-08"
        }
    ]
}  
URL: http://127.0.0.1:8000/api/labs
Action: Save Lab
Method: Post
Response: {
    "data": [
        {
            "id": 4,
            "name": "Lab-1",
            "location_id": 1,
            "location_name": "Newnham Campus Seneca College",
            "created_at": "2020-05-08",
            "updated_at": "2020-05-08"
        }
    ]
}  
URL: http://127.0.0.1:8000/api/labs/1
Action: Update Lab
Method: Put
Response: {
    "data": [
        {
            "id": 4,
            "name": "Lab-1",
            "location_id": 1,
            "location_name": "Newnham Campus Seneca College",
            "created_at": "2020-05-08",
            "updated_at": "2020-05-08"
        }
    ]
}  
URL: http://127.0.0.1:8000/api/labs/1
Action: Delete Lab
Method: Delete
Response: []  

## Frontend Application (lab-app)
I made the frontend application in Angular 9. It has the following folder structure.  
app  
•	_helper: this folder contains classes to enable app security  
•	_models: all the model classes are inside this folder  
•	_services: all the service classes to manipulate the models are here  
•	google-map: component to display the google map as a popup  
•	home: the home component to show the first page after login  
•	lab: the form to add or update lab  
•	lab-list: the table which shows the list of all the labs with delete feature and link to display google map  
•	location: the form to add or update location  
•	location-list: the table which displays all the locations from the database  
•	login: the login page which is shown at the start of the app  
I generated the services with the command ng g s _services/lab.  
 
I created the models using the command ng g cl _models/lab --type=model the option --type creates the file with .model.ts.  
 
For generating the components, I used the command ng g c lab --skipTests –s the option skipTests is used to skip making the spec file and --s is used to skip creating the css file.  
 
In the app-routing.module.ts I checked if the user has valid token before allowing access the pages.  
 
The AuthGuard in _helper/auth.guard.ts checks if the user is logged in to the system, otherwise it sends the user back to the login page.  
 
 
The JWT Interceptor in the _helpers/jwt.interceptor.js adds the token which has been fetched when the user logged in to the header of each request so that the Laravel API can validate and give access to fetching the data.  
 
## Design
 
I designed the CRUD operation in one page, on the left side is the form and on the right slide is the list of all labs. When a new record is entered the list auto refresh shows the newly added record in the list. To update a record the user can simply click on any row in the list and the form will be auto populated with the selected record. Then the user can update the record which will auto refresh the list again and show the updated record in the list. The delete button shows a confirmation to the user, when the user confirm then the record is deleted and the list refreshes.  
When the user clicks on the location in the list a popup window appears which shows the location of the lab with a pin.  

 
I decided to use bootstrap model for the popup, the location id is passed in the google map component which query from the API and fetches all the information of that current location. I integrated the google API and passed the latitude and longitude to show the location.

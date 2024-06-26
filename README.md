[![codecov](https://codecov.io/gh/sajeedkannoje/cae-roster/graph/badge.svg?token=4WUGZCDNRM)](https://codecov.io/gh/sajeedkannoje/cae-roster)
# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/11.x#creating-a-laravel-project)

Clone the repository

    git clone https://github.com/sajeedkannoje/cae-roster.git

Switch to the repo folder

    cd cae-roster

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/sajeedkannoje/cae-roster.git
    cd cae-roster
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate 
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).


# Testing API

Take a look at the API documentation to understand the available endpoints: [damco-cae-import.apidog.io](https://damco-cae-import.apidog.io/)
 
### To run unit tests for the import functionality, execute the following commands:

    php artisan test


## Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|

## Import File Structure by Platform
#### This provides links to sample files in XLSX/XLS and CSV formats for each platform:

| **Platform** 	      | **XLSX/XLS**              	                                                                                           | **CSV**            	 |
|---------------------|-----------------------------------------------------------------------------------------------------------------------|----------------------|
| RosterBuster      	 | [RosterBuster.xlsx](https://github.com/sajeedkannoje/cae-roster/blob/main/tests/dataProvider/RosterBuster-xlsx.xlsx)	 | [RosterBuster](https://github.com/sajeedkannoje/cae-roster/blob/main/tests/dataProvider/RosterBuster-csv.csv)	    |
 


## Books Api
A books information api using Laravel

## Installation --

1. Clone the repo
2. cd into the booksapi folder
3. run command: composer install
4. create an empty database and name it 'books_database' or change the .env file configuration base on your local database settings
5. run command: php artisan migrate
6. run command: php artisan serve

Requirement 1:
### get: http://localhost:8080/api/external-books/a game of thrones
shows external api books

Requirement 2:
### post http://localhost:8080/api/v1/books
note: with a form data - to create a book

Requirement 3:
### patch http://localhost:8080/api/v1/books/1
note: with a form data - to updated a book
note: 1 is a book id;

Requirement 4 - updating book alternative:
### post http://localhost:8080/api/v1/books/1/update
note: with a form data - to updated a book

Requirement 5:
### get http://localhost:8080/api/v1/books
to get list of books

Requirement 6:
### get http://localhost:8080/api/v1/books/1
To get get a single book 
note: 1 is a book id - in this case book with id 1

Requirement 7:
### delete http://localhost:8080/api/v1/books/1
To delete a book

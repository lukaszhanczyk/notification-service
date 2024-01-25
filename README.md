# Notification service

A microservice written in such a way that it sends notifications to the user via channels such as Twilio or/and AWS SES.
## Technology

- PHP 8.1
- Symfony 6
- PostgreSQL 14.1

## Instalation

1. Clone repository
2. Open project, move to build folder and run docker

   ```bash
   cd build
   docker-compose build
   docker-compose up
   ```
3. After the containers start correctly, open the php console in a new console

   ```bash
   cd build
   docker exec -it php-container bash
   ```

4. Run composer install in bash

   ```bash
   composer install
   ```

5. Update database schema

   ```bash
   php bin/console doctrine:schema:update --force
   ```

6. Set up cron job. Use `crontab -e` command and write this line in the file. After this save file.

   ```bash
   0 * * * * cd /var/www/html && php bin/console app:resend-notifications
   ```

The application is running on port 8082

   ```bash
   http://127.0.0.1:8082/
   ```

## Testing

To run all tests you need to run this in php bash

   ```bash
   php bin/phpunit
   ```

## Documentation

The entire application was created in the spirit of DDD, so the division of directories is important because it allowed the business layer to be separated from the application logic layer.

### Directory tree:

```bash
   ── NotificationPublisher
      ├── Application
      │    ├── Command 
      │    ├── Dto
      │    ├── Handler
      │    ├── Query
      │    └── Service
      ├── Domain
      │    ├── Entity 
      │    └── Repository
      └── Infrastucture
           ├── Client 
           ├── Command
           ├── Configurator
           ├── Http
           │    ├── Controller
           │    └── Request 
           └── Persistence
                ├── Entity
                └── Repository 
   ```

#### Application Layer

- **Command** - This directory contains classes that represent application commands. Commands typically encapsulate the intention to perform a specific action or operation within the application. Command classes hold the data necessary to execute the command.
- **Dto** - Dto stands for Data Transfer Object. This directory includes classes that are used for transferring data between layers of the application. Dtos often represent a subset of data with the sole purpose of moving data between different parts of the application.
- **Handler** - The Handler directory includes classes responsible for handling commands and queries. Handlers contain the business logic for processing commands and queries. Each command or query may have its corresponding handler.
- **Query** - Similar to the Command directory, this directory contains classes representing application queries. Queries are used to request data from the application without modifying the state. Query classes contain the necessary data to perform the query.
- **Service** - The Service directory includes application services. These services act as an interface between the application layer and the domain layer, encapsulating the application's business logic.

#### Domain Layer

- **Entity** - This directory contains classes representing domain entities. Entities are objects that have a distinct identity and are defined by their attributes and behavior. They encapsulate the business rules and logic within the domain.
- **Repository** - The Repository directory includes interfaces defining the contract for data access operations related to domain entities.

#### Infrastructure Layer

- **Client** - This directory includes classes responsible for interacting with external services or APIs. Clients encapsulate the communication logic with external systems and services.
- **Command** - Folder stores configured commands in the system.
- **Configurator** - The Configurator directory includes classes that handle the configuration of various components within the application.
- **Http** - This directory contains classes related to HTTP communication, such as controllers, request validators.
- **Persistence** - The Persistence directory includes classes related to data storage and retrieval like implementations of repositories and entities. 

### Endpoints

#### `GET` /history

- Endpoint for downloading the history of paginated notifications</br></br>
Sample request:
   ```bash
   /history?page=1&limit=20
   ```
        Params:
        - page - specifies the page number (min. 1)
        - limit - specifies the limit of notifications on the page (min. 1)
  
   Sample response:
   ```bash
   {
       "data": [
            ////
           {
               "id": 27,
               "userId": "QWERT2",
               "email": "test@test.com",
               "phone": "000000000",
               "sendingDate": "1706129506",
               "subject": "Subject",
               "content": "Content",
               "attempts": 1,
               "status": "success"
           },
            ////
       ],
       "pagination": {
           "page": "1",
           "limit": "20"
       }
   }
   ```

#### `POST` /send

- Endpoint for downloading the history of paginated notifications</br>* if we want the email to be sent correctly, the only supported email is (test.notification.service00@gmail.com) because it is listed as verified in AWS SES. The website operates in sandbox mode</br></br>
  Sample request body:
   ```bash
   {
       "subject": "test",
       "content": "test",
       "userId": "test",
       "email": "test.notification.service00@gmail.com",
       "phone": "000000000"
   }
   ```
  Sample response:
    ```bash
   {
        "status": "success",
        "message": "Notification sent correctly!"
    }
   ```

Each endopit has its own validation to avoid errors when sending requests

### Command

- `app:resend-notifications` </br></br>The program has a command to resend notifications. The attempt is repeated if one of the notifications has the 'error' status. In this situation, the number of 'attempts' in the database increases. The attempt will not be performed if the number of maximum attempts set in the configuration is too high. This value can be set in service.yaml, but more on that in the next section. In such a case, the notification status will be set to 'terminated' and will no longer be considered. </br></br> At the time of installation, we set the command to run in the background every specified time, in this case an hour.

### Configuration

services.yaml:
```bash
parameters:
    ...
    is_aws_ses_open: true
    is_twilio_open: true
    max_attempts: 3
```
It is possible to set a simple configuration:

- is_aws_ses_open - is responsible for enabling or disabling the AWS SES service
- is_twilio_open - is responsible for enabling or disabling the Twilio service
- max_attempts - specify the maximum number of attempts to resend the message
 

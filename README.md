
# RACKAKEY

USB reservation system for professors, managed by secretary.

## Set up development

### 1. Clone the repo
Clone the repository with

```bash
git clone https://github.com/CPNV-INFO/Rackakey.git
```

### 2. Install dependencies
Go to your project folder and run the installation of laravel dependencies.

```bash
cd /path/to/your/local/clone/of/rackakey

# install composer dependencies
composer install

# install the npm dependencies
cd public && npm i
```

### 3. Set up .env and database
When the dependencies are installed you must duplicate the ``.env.example`` file and rename it to ``.env``.

Then open your ``.env`` file and complete the informations:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rackakey
DB_USERNAME=USERNAME
DB_PASSWORD=SECRET
```

Create schema named ```rackakey```

### 4. Set up your application key

Finally, for laravel to work properly, you must generate the application key.

```bash
cd /path/to/your/local/clone/of/rackakey

php artisan key:generate
```

### 5. Seed and migrate the database

```bash
php artisan migrate:fresh --seed
```

### 6. Launch the web server

```bash
php artisan serve
```

### 7. Access the webpage

[Access localhost:8000](localhost:8000)

### 8. Use one account to connect

| Account mail | password | 
|--|--|
| professor@cpnv.ch  | secret |
| professor@cpnv.ch  | secret |
| professor3@cpnv.ch  | secret |
| secretary@cpnv.ch  | secret |
| admin@cpnv.ch  | secret |

### 9 Understand the total project
- #### 9.1 This project is only one part of the project
      The project is separated in 2 parts: 
      1.  Usb hub and software (certainly linux), 
      2.  Laravel backend logic and interface 
      The actual project is only focused on the 2nd point.
      
- #### 9.2 Communication between part 1 and part 2
      Actually only the laravel part is done (point 2). 
      The usb hub part with the software detects any key entering and exiting the hub is not done 
      but here it is how it has been thought:
  ![Communication between the 2](https://vpictu.re/uploads/08404d1d579e61093a0e62d07bec80cdeacc4f98.png)
      1. Every action in the hub is transmitted to the laravel backend (key inserted, key pulled)
      2. The informations transmitted from the hub part to laravel contains informations about the usb (name of the usb, uuid, capacity, rack and port number)
      3. Laravel receive those informations. If the key doesn't exist it is created in the database with initial state "Not initialized"
    
- #### 9.3 Features
      1. On the laravel webpage users (professors) can see they key and their state (Available, Present, Used, Absent, Not initialized)
      2. They can reserve a key

- #### 9.4 Project advancement
      1. Actually the project is not finished. Only basic things have been implemented
      2. What needs to be done is implementing an api that receives the informations when the usb hub send them (usb key entered, pulled, and the informations of them)
      3. Register those informations into the database
      4. And many others things...



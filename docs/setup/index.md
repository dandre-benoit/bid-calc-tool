# The Bid Calculation Tool

## Run locally

### Prerequises
- File .env created and configured (see .env.exemple file)
- Composer installed
- Node.js installed 
- NPM installed
- [See technologies](../technologies/index.md)

### Default Local URL
```
http://localhost:8000
````

### Project Setup

```bash
# install backend's dependencies
$ composer install
# generate the application key for encryption
$ php artisan key:generate
# install frontend's dependencies
$ npm install
# build the frontend's files
$ npm run build
```

### Run Production
```bash
# Run the serveur Laravel
$ php artisan serve
```

### Run Development
```bash
# run the serveur Laravel
$ php artisan serve
# then in a seperate process, run the development mode for hot reloading using vite
$ npm run dev
```

### Run Tests

#### Backend
```bash
# unit tests
$ php artisan test
```

#### Frontend

```bash
# unit tests
$ npm run test
```

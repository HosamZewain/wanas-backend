![wanas-readme.png](wanas-readme.png)

# Wanas App

A Mobile Application For Sharing Rides & Events

## Features

- Share Rides
- Share Events
- Share Driver Performance with reviews
- Share Passenger Performance with reviews
- chat with other users

## Demo

https://wanas.roqay.solutions

## Deployment

To deploy this project run

```bash
git clone
git checkout develop
git pull

set .env file
set database

composer install
php artisan migrate
php artisan db:seed
php artisan telescope:install
php artisan storage:link
    
    
    
```

## Authors

- [@khaledAlWakeel](https://www.github.com/khaledweka)

## API Reference

#### Get all items

```http
  GET /api/
```

| Parameter | Type     | Description                |
|:----------|:---------|:---------------------------|
| `api_key` | `string` | **Required**. Your API key |


## Appendix

 All Copy Rights Reserved To [@RoQay](https://www.roqay.com) Company


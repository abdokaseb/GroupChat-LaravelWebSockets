# APT Project, Group Chat with Laravel

This Project is built with the [Laravel WebSockets](https://github.com/beyondcode/laravel-websockets) package. [official documentation](https://docs.beyondco.de/laravel-websockets/).

## Usage

1. Clone this repository
2. `composer install`
3. `cp .env.example .env`
4. Make an empty database named "ChatDB"
5. `php artisan migrate`
6. `php artisan key:generate`
7. `php artisan websockets:serve`
8. `php artisan serve` from another terminal
    To run on LAN wirte "sudo php artisan serve --host 192.168.1.2 --port 8080"
    
If you want to change js or vue files, you should write
1. `npm install`
2. `npm run watch` and leave it running while develpment


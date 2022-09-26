# README #

Project description

### Installation ###

1) Clone repo
2) Change directory to project directory
3) Run composer:install
4) Run php bin/console doctrine:database:create
5) Run php bin/console doctrine:schema:create
6) Serve /web dir with any web-server like: php -S 0.0.0.0:8001
7) To run tests suite
7.1) Run php bin/console doctrine:database:create --env=test
7.2) Run php bin/console doctrine:schema:create --env=test
7.3) Run vendor/bin/simple-phpunit

### API ###

[POST] /ticket
Parameters:
    departureTime: string, // "01-01-2023 00:00:00"
    sourceAirport: string, // "Source Airport"
    destAirport: string, // "Destination Airport",
    seat: string, // "20"  
    passportId: string // "passportId2414"
[DELETE] /ticket
Parameters:
    ticketId: string, // "166"
[POST] /ticket/changeseat 
Parameters:
    ticketId: string, // "166"
    seat: string // "16"
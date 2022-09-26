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
<ul>
<li>Run php bin/console doctrine:database:create --env=test</li>
<li>Run php bin/console doctrine:schema:create --env=test</li>
<li>Run vendor/bin/simple-phpunit</li>
</ul>

### API ###

<div>[POST] /ticket</div>
<div>Parameters:</div>
    <ul>
    <li>departureTime: string, // "01-01-2023 00:00:00"</li>
    <li>sourceAirport: string, // "Source Airport"</li>
    <li>destAirport: string, // "Destination Airport",</li>
    <li>seat: string, // "20"</li>
    <li>passportId: string // "passportId2414"</li>
    </ul>
<div>[DELETE] /ticket</div>
<div>Parameters:</div>
    <ul>
    <li>ticketId: string, // "166"</li>
    </ul>
<div>[POST] /ticket/changeseat </div>
<div>Parameters:</div>
    <ul>
    <li>ticketId: string, // "166"</li>
    <li>seat: string // "16"</li>
    </ul>
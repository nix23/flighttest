<?php
namespace Tests\NtechClientBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ntech\CoreBundle\Entity\Ticket;

class TicketControllerTest extends WebTestCase
{
    private $container;
    private $em;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
    }

    public function testTicketCreated()
    {
        //echo "Test started!"; exit();
        $data = [
            "departureTime" => "01-01-2023 00:00:00",
            "sourceAirport" => "AirportA",
            "destAirport" => "AirportB",
            "seat" => "1",
            "passportId" => "pass123",
        ];

        $client = $this->createClient();
        $client->request(
            'POST',
            '/ticket',
            $data
        );
        
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(array_key_exists("ticketId", $data));
    }

    public function testTicketNotCreatedWithWrongData()
    {
        $data = [
            "departureTime" => "",
            "sourceAirport" => "",
            "destAirport" => "",
            "seat" => "",
            "passportId" => "",
        ];

        $client = $this->createClient();
        $client->request(
            'POST',
            '/ticket',
            $data
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(count($data) == 5);
    }

    public function testTicketCancelled()
    {
        $data = [
            "departureTime" => "01-01-2023 00:00:00",
            "sourceAirport" => "AirportA",
            "destAirport" => "AirportB",
            "seat" => "1",
            "passportId" => "pass123",
        ];

        $client = $this->createClient();
        $client->request(
            'POST',
            '/ticket',
            $data
        );

        $res = json_decode($client->getResponse()->getContent(), true);
        $ticketId = $res["ticketId"];
        $data = [
            "ticketId" => $ticketId,
        ];

        $client->request(
            'DELETE',
            '/ticket',
            $data
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // @todo -> query no item in db with ticketId
    }
    
    public function testTicketNotCancelledWithWrongTicketId()
    {
        $data = [
            "ticketId" => "-1",
        ];

        $client = $this->createClient();
        $client->request(
            'DELETE',
            '/ticket',
            $data
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testSeatChanged()
    {
        $data = [
            "departureTime" => "01-01-2023 00:00:00",
            "sourceAirport" => "AirportA",
            "destAirport" => "AirportB",
            "seat" => "1",
            "passportId" => "pass123",
        ];

        $client = $this->createClient();
        $client->request(
            'POST',
            '/ticket',
            $data
        );

        $res = json_decode($client->getResponse()->getContent(), true);
        $ticketId = $res["ticketId"];

        $data = [
            "ticketId" => $ticketId,
            "seat" => "16",
        ];

        $client = $this->createClient();
        $client->request(
            'POST',
            '/ticket/changeseat',
            $data
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // @todo -> query from db and test if seat num has changed
    }

    public function testSeatNotChangedWithWrongSeatNumber()
    {
        $data = [
            "ticketId" => "-1",
            "seat" => "18",
        ];

        $client = $this->createClient();
        $client->request(
            'POST',
            '/ticket/changeseat',
            $data
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
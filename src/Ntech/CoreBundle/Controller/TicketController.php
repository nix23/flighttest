<?php
namespace Ntech\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ntech\CoreBundle\Entity\Ticket;
use Ntech\CoreBundle\Helpers\Str;

class TicketController extends Controller
{
    public function createAction(Request $request)
    {
        $departureTime = $request->request->get("departureTime");
        $sourceAirport = $request->request->get("sourceAirport");
        $destAirport = $request->request->get("destAirport");
        $seat = (int)$request->request->get("seat");
        $passportId = $request->request->get("passportId");

        $errors = [];
        if(Str::isBlank($departureTime))
            $errors["departureTime"] = "Please provide departure time.";
        if(Str::isBlank($sourceAirport))
            $errors["sourceAirport"] = "Please enter source airport.";
        if(Str::isBlank($destAirport))
            $errors["destAirport"] = "Please enter destination airport.";
        if($seat < 1 || $seat > 32)
            $errors["seat"] = "Not existing seat number.";
        if(Str::isBlank($passportId))
            $errors["passportId"] = "Please enter passport id.";
        if(count($errors) > 0)
            return new JsonResponse($errors, 400);

        $ticket = new Ticket();
        $ticket->setDepartureTime(new \DateTime($departureTime));
        $ticket->setSourceAirport($sourceAirport);
        $ticket->setDestAirport($destAirport);
        $ticket->setSeat($seat);
        $ticket->setPassportId($passportId);

        $em = $this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();

        return new JsonResponse([
            "ticketId" => $ticket->getId(),
        ], 201);
    }

    public function cancelAction(Request $request)
    {
        $ticketId = $request->request->get("ticketId");
        
        $ticketRepository = $this->getDoctrine()->getRepository("NtechCoreBundle:Ticket");
        $ticket = $ticketRepository->find($ticketId);
        if(!$ticket)
            return new JsonResponse([
                "msg" => "Wrong ticket id.",
            ], 400);

        $em = $this->getDoctrine()->getManager();
        $em->remove($ticket);
        $em->flush();

        return new JsonResponse();
    }

    public function changeSeatAction(Request $request)
    {
        $ticketId = $request->request->get("ticketId");
        $newSeat = (int)$request->request->get("seat");
        if($newSeat < 1 || $newSeat > 32)
            return new JsonResponse([
                "msg" => "Not existing seat number.",
            ], 400);

        $ticketRepository = $this->getDoctrine()->getRepository("NtechCoreBundle:Ticket");
        $ticket = $ticketRepository->find($ticketId);
        if(!$ticket)
            return new JsonResponse([
                "msg" => "Wrong ticket id.",
            ], 400);

        $ticket->setSeat($newSeat);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();

        return new JsonResponse();
    }
}
 
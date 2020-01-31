<?php


namespace App\Controller;


use App\Entity\Fournisseur;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FournisseurController extends AbstractController
{
    /**
     * @Route("/fournisseurs", name="fournisseur_show")
     */
    public function index()
    {
        $fournisseurRep = $this->getDoctrine()->getManager()
            ->getRepository(Fournisseur::class);
        $fournisseur  = $fournisseurRep->findAll();

        $serializer = SerializerBuilder::create()->build();
        $JMSfournisseur=$serializer->serialize($fournisseur , 'json');

        $response = new Response($JMSfournisseur);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * @Route("/fournisseur/create", name="fournisseur_create",methods={"POST"})
     *
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $fournisseur = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Fournisseur', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($fournisseur);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

}
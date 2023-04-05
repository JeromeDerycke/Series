<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(SerieRepository $serieRepository): Response
    {
        $serie=$serieRepository->findBestSeries();

        return $this->render('serie/list.html.twig',[
            "series" => $serie
        ]);
    }

    /**
     * @Route("/series/details/{id}", name="serie_details")
     */
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        return $this->render('serie/details.html.twig', [
            "serie" =>$serie
        ]);
    }

    /**
     * @Route("/series/create", name="serie_create")
     */
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());

        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request);

        if ($serieForm->isSubmitted() && $serieForm->isValid()){
            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success', 'Serie added! Good job.');
            return $this->redirectToRoute('serie_details', ['id'=>$serie->getId()]);
        }

        return $this->render('serie/create.html.twig',[
            'serieForm' => $serieForm->createView()
        ]);
    }

    /**
     * @Route ("/series/demo", name="serie_em-demo")
     */
    public function demo(EntityManagerInterface $entityManager): Response
    {
        //Crée une instance de mon entité
        $serie=new Serie();

        //Hydrate toutes les propriétés
        $serie->setName('pif');
        $serie->setBackdrop('dafsd');
        $serie->setPoster('dafsdf');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime("-1 year"));
        $serie->setLastAirDate(new \DateTime("-6 month"));
        $serie->setGenres('Drama');
        $serie->setOverview('bla bl bla');
        $serie->setPopularity(123.45);
        $serie->setVote(8.2);
        $serie->setStatus('Canceled');
        $serie->setTmdbId(342568);

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->render('serie/create.html.twig');
    }

    /**
     * @Route ("/series/delete/{id}", name="/series_delete")
     */
    public function delete(Serie $serie, EntityManagerInterface $entityManager){
        $entityManager->remove($serie);
        $entityManager->flush();

        return$this->render(':main:home.html.twig');
    }
}

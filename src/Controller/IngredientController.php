<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ingredient")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/", name="ingredient_index", methods={"GET"})
     */
    public function index(IngredientRepository $ingredientRepository): Response
    {
        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ingredient_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();
            $this->addFlash('success', 'Votre ingrédient a bien été créé');

            return $this->redirectToRoute('ingredient_index');
        }

        return $this->render('ingredient/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ingredient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ingredient $ingredient): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre ingrédient a bien été modifié');

            return $this->redirectToRoute('ingredient_index');
        }

        return $this->render('ingredient/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ingredient_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ingredient $ingredient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingredient);
            $entityManager->flush();
            $this->addFlash('success', 'Supprimé avec succès');
        }

        return $this->redirectToRoute('ingredient_index');
    }
}

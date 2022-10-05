<?php

namespace App\Controller\Main;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('main/default/index.html.twig');
    }


//    /**
//     * @Route("/product-edit/{id}", methods="GET|POST", name="product_edit", requirements={"id"="\d+"})
//     * @Route("/product-add", methods="GET|POST", name="product_add")
//     */
//    public function editProduct(Request $request, int $id = 0): Response
//    {
//
//        $entityManager = $this->getDoctrine()->getManager();
//
//        if ($id) {
//            $product = $entityManager->getRepository(Product::class)->find($id);
//        } else {
//            $product = new Product();
//        }
//
//        $form = $this->createForm(EditProductFormType::class, $product);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($product);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
//        }
//
//        return $this->render('main/default/product_edit.html.twig', ['form' => $form->createView()]);
//    }
}

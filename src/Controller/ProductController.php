<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\Category;

class ProductController extends AbstractController
{

    public function index()
    {
        $product = $this->getDoctrine()->getManager()->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', ['products' => $product]);
    }


    public function show($id)
    {
        $product = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);
        $categoryName = $product->getCategory();
        $user = $product->getUser();

    	if(!$product){
            throw $this->createNotFoundException('No product found for '. $id);
    	}

    	return $this->render('product/show.html.twig', ['product' => $product, 'category'=> $categoryName, 'user'=> $user]);
    }


    public function product_new()
    {
        return $this->render('product/create.html.twig');
    }


    public function create(Request $request)
    {
        $category = new Category();
        $category->setName($request->get('category'));

        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName($request->get('title'));
        $product->setPrice($request->get('price'));
        $product->setDescription(strip_tags($request->get('description')));
        $product->setCategory($category);

        $entityManager->persist($user);
        $entityManager->persist($category);
        $entityManager->persist($product);
        $user->addProduct($product);
        $entityManager->flush();

        return $this->redirectToRoute('products');
    }


	public function edit(Request $request, $id)
	{
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
        	throw $this->createNotFoundException('No product found for id '. $id);
        }

        $product->setName($request->get('title'));
        $product->setPrice($request->get('price'));
        $product->setDescription(strip_tags($request->get('description')));

        $entityManager->flush();

        return $this->redirectToRoute('products');
	}


    public function delete(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('products');
    }

}

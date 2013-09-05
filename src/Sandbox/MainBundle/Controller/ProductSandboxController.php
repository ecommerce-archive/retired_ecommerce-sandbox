<?php

namespace Sandbox\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ODM\PHPCR\DocumentManager;

use Ecommerce\Bundle\CoreBundle\Product\Manager;

class ProductSandboxController extends Controller
{
    public function indexAction()
    {
        /** @var Manager $productManager */
        $productManager = $this->get('ecommerce_core.product.manager');

        $products = $productManager->findAll();

        return $this->render(
        	'SandboxMainBundle:ProductSandbox:index.html.twig',
        	array(
        		'name' => 'there',
        		'products' => $products,
    		)
    	);
    }

    public function newAction()
    {
        /** @var Manager $productManager */
        $productManager = $this->get('ecommerce_core.product.manager');

        $createdProduct = $productManager->createProduct();

    }

    public function createAction(Request $request)
    {
        /** @var Manager $productManager */
        $productManager = $this->get('ecommerce_core.product.manager');

        $id = $request->request->get('name');

        $product = $productManager->find($id);

        if ($product) {
            throw new \Exception('already exists');
            return $this->redirect($this->generateUrl('sandbox_main_productsandbox'));
        }

        $product = $productManager->createProduct($id);

        if (!$product) {
            throw new \Exception('Product wasn’t created');
            return $this->redirect($this->generateUrl('sandbox_main_productsandbox'));
        }

        $success = $productManager->save($product);

        if (!$success) {
            throw new \Exception('New product wasn’t saved');
            return $this->redirect($this->generateUrl('sandbox_main_productsandbox'));
        }

        $statusCode = 201;

        $response = new Response();
        $response->setStatusCode($statusCode);

        if (201 === $statusCode) {
            $response->headers->set('Location',
                $this->generateUrl(
                    'sandbox_main_productsandbox_view', array('id' => $product->getIdentifier()),
                    true
                )
            );
        }

        return $response;
    }

    public function updateAction($id, Request $request)
    {
        /** @var Manager $productManager */
        $productManager = $this->get('ecommerce_core.product.manager');

        $product = $productManager->find($id);

        if (!$product) {
            throw $this->createNotFoundException(sprintf('Product with ID %s was not found', $id));
        }

        $product->setName($request->request->get('name'));

        $success = $productManager->save($product);

        if (!$success) {
            throw new \Exception('Product wasn’t saved');
            return $this->redirect($this->generateUrl('sandbox_main_productsandbox'));
        }

        $response = new Response(
            '',
            200,
            array(
                'Content-Location' => $this->generateUrl(
                    'sandbox_main_productsandbox_view', array('id' => $product->getIdentifier()),
                    true
                )
            )
        );

//        $response->headers->set('Content-Location',
//            $this->generateUrl(
//                'ecommerce_product_view', array('id' => $product->getIdentifier()),
//                true
//            )
//        );

        return $response;
    }

    public function viewAction($id)
    {
        /** @var Manager $productManager */
        $productManager = $this->get('ecommerce_core.product.manager');

        $product = $productManager->find($id);

        if (!$product) {
            return $this->createNotFoundException(sprintf('Product with ID %s was not found', $id));
        }

        return new Response(var_export($product->getId(), true));
    }

    public function deleteAction($id)
    {
        /** @var Manager $productManager */
        $productManager = $this->get('ecommerce_core.product.manager');

        $product = $productManager->find($id);

        if (!$product) {
            return $this->createNotFoundException(sprintf('Product with ID %s was not found', $id));
        }

        $success = $productManager->delete($product);

        $response = new Response();
        $response->setStatusCode(204);
        return $response;


        return $this->redirect($this->generateUrl('sandbox_main_productsandbox'));
    }
}

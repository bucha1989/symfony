<?php

namespace App\Form\Handler;

use App\Entity\Product;
use App\Utils\File\FileSaver;
use App\Utils\Manager\ProductManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;

class ProductFormHandler
{

    /**
     * @var FileSaver
     */
    private $fileSaver;

    /**
     * @var ProductManager
     */
    private $productManager;

    /**
     * @param ProductManager $productManager
     * @param FileSaver $fileSaver
     */
    public function __construct(ProductManager $productManager, FileSaver $fileSaver)
    {
        $this->fileSaver = $fileSaver;
        $this->productManager = $productManager;
    }

    /**
     * @param Product $product
     * @param Form $form
     * @return Product
     */
    public function processEditForm(Product $product, Form $form)
    {
        // TODO:
        $this->productManager->save($product);

        $newImageFile = $form->get('newImage')->getData();
        $tempImageFilename = $newImageFile
            ? $this->fileSaver->saveUploadFileIntoTemp($newImageFile)
            : null;
        
        $this->productManager->updateProductImages($product, $tempImageFilename);
        $this->productManager->save($product);

        return $product;
    }
}
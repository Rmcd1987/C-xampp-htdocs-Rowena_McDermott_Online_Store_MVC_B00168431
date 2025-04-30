<?php
session_start();
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function showProducts()
    {
        return $this->productModel->getAll();
    }

    public function getProductById($id)
    {
        return $this->productModel->getById($id);
    }
}

<?php
require_once __DIR__ . '/../models/Product.php';

class CartController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    // ✅ Add to cart with quantity
    public function addToCart($productId, $quantity = 1)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If product already exists, increase quantity
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    // ✅ Update quantity directly
    public function updateQuantity($productId, $quantity)
    {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = max(1, $quantity); // Ensure quantity is at least 1
        }
    }

    // ✅ Remove a product from cart
    public function removeFromCart($productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    // ✅ Clear all cart items
    public function clearCart()
    {
        unset($_SESSION['cart']);
    }

    // ✅ Fetch cart items including quantity
    public function getCartItems()
    {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return [];
        }

        $items = [];
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = $this->productModel->getById($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                $items[] = $product;
            }
        }

        return $items;
    }
}
?>

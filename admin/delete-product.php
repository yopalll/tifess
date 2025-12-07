<?php
/**
 * Hapus Produk
 */

require_once "../function.php";
requireLogin();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $product = getProductById($id);
    
    if ($product && $product['image']) {
        $imagePath = '../' . $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    
    deleteProduct($id);
}

header("Location: products.php?success=Product deleted successfully");
exit;

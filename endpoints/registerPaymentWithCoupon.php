<?php




// Function to register a payment using a coupon
function registerPaymentWithCoupon($couponCode, $userId) {
    // Connect to the database
    $pdo = getDatabaseConnection();
    // Check the validity of the coupon
    $couponQuery = 'SELECT * FROM coupons WHERE code = :coupon_code AND is_used = 0';
    $couponStmt = $pdo->prepare($couponQuery);
    $couponStmt->bindParam(':coupon_code', $couponCode);
    $couponStmt->execute();
    $coupon = $couponStmt->fetch(PDO::FETCH_ASSOC);

    // If the coupon is valid
    if ($coupon) {
        // Register the payment
        $paymentQuery = 'INSERT INTO payments (user_id, coupon_id, amount) VALUES (:user_id, :coupon_id, :amount)';
        $paymentStmt = $pdo->prepare($paymentQuery);
        $paymentStmt->bindParam(':user_id', $userId);
        $paymentStmt->bindParam(':coupon_id', $coupon['id']);
        $paymentStmt->bindParam(':amount', $coupon['value']); // The value of the coupon

        // Execute the query
        if ($paymentStmt->execute()) {
            // Update the coupon status to used
            $updateCouponQuery = 'UPDATE coupons SET is_used = 1 WHERE id = :coupon_id';
            $updateCouponStmt = $pdo->prepare($updateCouponQuery);
            $updateCouponStmt->bindParam(':coupon_id', $coupon['id']);
            $updateCouponStmt->execute();

            echo json_encode(['message' => 'Payment registered successfully using the coupon.']);
        } else {
            echo json_encode(['error' => 'Error registering the payment. Please try again.']);
        }
    } else {
        echo json_encode(['error' => 'Invalid or already used coupon.']);
    }
}



?>

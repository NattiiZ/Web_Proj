<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantity Control</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
    flex-direction: column;
}

h1 {
    margin-bottom: 10px;
    color: #333;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 22px;
    margin-bottom: 20px;
    background: white;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.quantity-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 12px 18px;
    cursor: pointer;
    font-size: 22px;
    border-radius: 5px;
    transition: background 0.3s;
}

.quantity-btn:hover {
    background-color: #0056b3;
}

#total-price {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.pay-btn {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px 20px;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.pay-btn:hover {
    background-color: #218838;
}

    </style>
</head>
<body>
        
    <h1>ชำระเงิน</h1>
    <h1>รูปหน้า</h1>
    <h1>ชื่อหนัง</h1>
    <div class="quantity-control">
        <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
        <span id="quantity">1</span>
        <button class="quantity-btn" onclick="increaseQuantity()">+</button>
    </div>

    <p>Total Price: <span id="total-price">3000</span> THB</p>

    <form id="quantity-form" method="POST">
        <input type="hidden" id="hidden-quantity" name="quantity" value="1">
        <button type="submit" style="display:none;" id="submit-btn">Submit</button>
    </form>
    <button class="pay-btn" onclick="processPayment()">Pay</button>

    <script>
        let quantity = 1;
        let pricePerUnit = 3000; // ตั้งราคาต่อหน่วย ถ้าต้องการเปลี่ยน

        function updateTotalPrice() {
            let totalPrice = quantity * pricePerUnit;
            document.getElementById("total-price").innerText = totalPrice.toLocaleString();
            document.getElementById("quantity").innerText = quantity;
            document.getElementById("hidden-quantity").value = quantity;
        }

        function increaseQuantity() {
            quantity++;
            updateTotalPrice();
           
        }

        function decreaseQuantity() {
            if (quantity > 1) {
                quantity--;
                updateTotalPrice();
                
            }
        }

        function processPayment() {
            let totalPrice = quantity * pricePerUnit;
            alert("✅ ชำระเงินสำเร็จ! \n💰 ยอดชำระ: " + totalPrice.toLocaleString() + " THB");
        }
    </script>


</body>
</html>
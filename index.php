<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Items by Farmers</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Grocery Items by Farmers</h1>
    <table id="productsTable">
        <tr>
            <th>Product No.</th>
            <th>Product</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
            include 'db.php';
            $query = "SELECT * FROM products";
            $result = $conn->query($query);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "
                    <tr id='product-" . $row['id'] . "'>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" .$row['price'] . "</td>
                        <td>
                            <button class='add-btn'>Add</button>
                        </td>
                    </tr>";
                }
            }else{
                echo "<tr><td colspan='4'><h4>Error While fetching the data</h4></td></tr>";
            }
        ?>
    </table>

    <h2>Your List</h2>
    <table id="yourList">
        <tr>
            <th>Product No.</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
    </table>

    <script>
    
        const productsTable = document.getElementById('productsTable');
        const yourList = document.getElementById('yourList');

        // Object to track selected items
        const selectedItems = {};

        productsTable.addEventListener('click', (e) => {
                const row = e.target.closest('tr');
                const productId = row.id.split('-')[1];
                const productName = row.cells[1].textContent;
                const productPrice = row.cells[2].textContent;

                // Add to selectedItems
                if (!selectedItems[productId]) {
                    selectedItems[productId] = { name: productName, price: productPrice, quantity: 1 };

                    // Add to Your List
                    const newRow = document.createElement('tr');
                    newRow.id = `selected-${productId}`;
                    newRow.innerHTML = `
                        <td>${productId}</td>
                        <td>${productName}</td>
                        <td>${productPrice}</td>
                        <td>1</td>
                        <td>
                            <button class="reduce-item-btn">Reduce</button>
                            <button class="remove-item-btn">Remove</button>
                        </td>
                    `;
                    yourList.appendChild(newRow);
                } else {
                    // Increment quantity
                    selectedItems[productId].quantity++;
                    document.querySelector(`#selected-${productId} td:nth-child(4)`).textContent = selectedItems[productId].quantity;
                }
        });

        yourList.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            const productId = row.id.split('-')[1];

            if (e.target.classList.contains('remove-item-btn')) {
                // Remove from selectedItems
                delete selectedItems[productId];

                // Remove row from Your List
                row.remove();
            }

            if (e.target.classList.contains('reduce-item-btn')) {
                if (selectedItems[productId] && selectedItems[productId].quantity > 1) {
                    // Reduce quantity
                    selectedItems[productId].quantity--;
                    document.querySelector(`#selected-${productId} td:nth-child(4)`).textContent = selectedItems[productId].quantity;
                } else if (selectedItems[productId]) {
                    // If quantity is 1, remove the item
                    delete selectedItems[productId];
                    row.remove();
                }
            }
        });

    </script>
</body>
</html>

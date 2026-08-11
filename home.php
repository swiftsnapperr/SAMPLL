<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "Logistix";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$database`");
mysqli_select_db($conn, $database);

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS Inventory (
    Code INT UNSIGNED NOT NULL AUTO_INCREMENT,
    SKU VARCHAR(80) DEFAULT NULL,
    Name VARCHAR(150) NOT NULL,
    Brand VARCHAR(100) DEFAULT NULL,
    Manufacturer VARCHAR(120) DEFAULT NULL,
    Models VARCHAR(100) DEFAULT NULL,
    Types VARCHAR(80) NOT NULL,
    Categories VARCHAR(100) NOT NULL,
    Measures VARCHAR(50) NOT NULL,
    Barcode VARCHAR(100) DEFAULT NULL,
    ReorderLevel DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    OpeningQuantity DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    QuantityOnHand DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    Cost DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    Price DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    Location VARCHAR(120) DEFAULT NULL,
    Status VARCHAR(40) DEFAULT 'Active',
    Description TEXT,
    CreatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (Code)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS suppliers (
    TINumber VARCHAR(50) NOT NULL,
    Type VARCHAR(80) DEFAULT NULL,
    SUName VARCHAR(150) NOT NULL,
    ContactPerson VARCHAR(150) DEFAULT NULL,
    BName VARCHAR(120) NOT NULL,
    ACNumber VARCHAR(80) NOT NULL,
    Phone VARCHAR(40) DEFAULT NULL,
    Email VARCHAR(150) DEFAULT NULL,
    Address VARCHAR(180) DEFAULT NULL,
    City VARCHAR(100) DEFAULT NULL,
    Country VARCHAR(100) DEFAULT NULL,
    PaymentTerms VARCHAR(50) DEFAULT NULL,
    CreditLimit DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    Status VARCHAR(40) DEFAULT 'Active',
    Notes TEXT,
    CreatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (TINumber)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS customers (
    CustomerID VARCHAR(50) NOT NULL,
    Type VARCHAR(80) DEFAULT NULL,
    CName VARCHAR(150) NOT NULL,
    ContactPerson VARCHAR(150) DEFAULT NULL,
    BName VARCHAR(120) DEFAULT NULL,
    ACNumber VARCHAR(80) DEFAULT NULL,
    Phone VARCHAR(40) DEFAULT NULL,
    Email VARCHAR(150) DEFAULT NULL,
    Address VARCHAR(180) DEFAULT NULL,
    City VARCHAR(100) DEFAULT NULL,
    Country VARCHAR(100) DEFAULT NULL,
    PaymentTerms VARCHAR(50) DEFAULT NULL,
    CreditLimit DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    Status VARCHAR(40) DEFAULT 'Active',
    Notes TEXT,
    CreatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (CustomerID)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS purchase_orders (
    POID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    SupplierName VARCHAR(150) DEFAULT NULL,
    SupplierTIN VARCHAR(50) DEFAULT NULL,
    InvoiceNumber VARCHAR(80) DEFAULT NULL,
    InvoiceDate DATE DEFAULT NULL,
    PaymentOption VARCHAR(50) DEFAULT NULL,
    ItemCode INT UNSIGNED NOT NULL,
    ItemName VARCHAR(150) NOT NULL,
    Quantity DECIMAL(12, 2) NOT NULL DEFAULT 1.00,
    Cost DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    CreatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (POID),
    INDEX (ItemCode)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS sales_orders (
    SOID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    CustomerName VARCHAR(150) DEFAULT NULL,
    CustomerTIN VARCHAR(50) DEFAULT NULL,
    InvoiceNumber VARCHAR(80) DEFAULT NULL,
    InvoiceDate DATE DEFAULT NULL,
    PaymentOption VARCHAR(50) DEFAULT NULL,
    ItemCode INT UNSIGNED NOT NULL,
    ItemName VARCHAR(150) NOT NULL,
    Quantity DECIMAL(12, 2) NOT NULL DEFAULT 1.00,
    Price DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    CreatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (SOID),
    INDEX (ItemCode)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS stock_adjustments (
    AdjustmentID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ItemCode INT UNSIGNED NOT NULL,
    ItemName VARCHAR(150) NOT NULL,
    SystemQuantity DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    PhysicalQuantity DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    AdjustmentQuantity DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    CreatedBy VARCHAR(120) DEFAULT NULL,
    CreatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (AdjustmentID),
    INDEX (ItemCode)
)");

$itemNameColumn = mysqli_query($conn, "SHOW COLUMNS FROM purchase_orders LIKE 'ItemName'");
if ($itemNameColumn && mysqli_num_rows($itemNameColumn) === 0) {
    mysqli_query($conn, "ALTER TABLE purchase_orders ADD COLUMN ItemName VARCHAR(150) NOT NULL DEFAULT ''");
}

$costColumn = mysqli_query($conn, "SHOW COLUMNS FROM purchase_orders LIKE 'Cost'");
if ($costColumn && mysqli_num_rows($costColumn) === 0) {
    mysqli_query($conn, "ALTER TABLE purchase_orders ADD COLUMN Cost DECIMAL(12, 2) NOT NULL DEFAULT 0.00");
}

$purchaseExtraColumns = [
    'SupplierName' => "ALTER TABLE purchase_orders ADD COLUMN SupplierName VARCHAR(150) DEFAULT NULL AFTER POID",
    'SupplierTIN' => "ALTER TABLE purchase_orders ADD COLUMN SupplierTIN VARCHAR(50) DEFAULT NULL AFTER SupplierName",
    'InvoiceNumber' => "ALTER TABLE purchase_orders ADD COLUMN InvoiceNumber VARCHAR(80) DEFAULT NULL AFTER SupplierTIN",
    'InvoiceDate' => "ALTER TABLE purchase_orders ADD COLUMN InvoiceDate DATE DEFAULT NULL AFTER InvoiceNumber",
    'PaymentOption' => "ALTER TABLE purchase_orders ADD COLUMN PaymentOption VARCHAR(50) DEFAULT NULL AFTER InvoiceDate",
];

$salesExtraColumns = [
    'CustomerName' => "ALTER TABLE sales_orders ADD COLUMN CustomerName VARCHAR(150) DEFAULT NULL AFTER SOID",
    'CustomerTIN' => "ALTER TABLE sales_orders ADD COLUMN CustomerTIN VARCHAR(50) DEFAULT NULL AFTER CustomerName",
    'InvoiceNumber' => "ALTER TABLE sales_orders ADD COLUMN InvoiceNumber VARCHAR(80) DEFAULT NULL AFTER CustomerTIN",
    'InvoiceDate' => "ALTER TABLE sales_orders ADD COLUMN InvoiceDate DATE DEFAULT NULL AFTER InvoiceNumber",
    'PaymentOption' => "ALTER TABLE sales_orders ADD COLUMN PaymentOption VARCHAR(50) DEFAULT NULL AFTER InvoiceDate",
    'ItemName' => "ALTER TABLE sales_orders ADD COLUMN ItemName VARCHAR(150) NOT NULL DEFAULT '' AFTER ItemCode",
    'Price' => "ALTER TABLE sales_orders ADD COLUMN Price DECIMAL(12, 2) NOT NULL DEFAULT 0.00 AFTER Quantity",
];

function ensure_columns(mysqli $conn, string $table, array $columns): void
{
    foreach ($columns as $column => $alterSql) {
        $safeColumn = $conn->real_escape_string($column);
        $columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$safeColumn'");
        if ($columnCheck && mysqli_num_rows($columnCheck) === 0) {
            mysqli_query($conn, $alterSql);
        }
    }
}

foreach ($purchaseExtraColumns as $column => $alterSql) {
    $columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM purchase_orders LIKE '$column'");
    if ($columnCheck && mysqli_num_rows($columnCheck) === 0) {
        mysqli_query($conn, $alterSql);
    }
}

foreach ($salesExtraColumns as $column => $alterSql) {
    $columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM sales_orders LIKE '$column'");
    if ($columnCheck && mysqli_num_rows($columnCheck) === 0) {
        mysqli_query($conn, $alterSql);
    }
}

ensure_columns($conn, 'Inventory', [
    'SKU' => "ALTER TABLE Inventory ADD COLUMN SKU VARCHAR(80) DEFAULT NULL",
    'Brand' => "ALTER TABLE Inventory ADD COLUMN Brand VARCHAR(100) DEFAULT NULL",
    'Manufacturer' => "ALTER TABLE Inventory ADD COLUMN Manufacturer VARCHAR(120) DEFAULT NULL",
    'Barcode' => "ALTER TABLE Inventory ADD COLUMN Barcode VARCHAR(100) DEFAULT NULL",
    'ReorderLevel' => "ALTER TABLE Inventory ADD COLUMN ReorderLevel DECIMAL(12, 2) NOT NULL DEFAULT 0.00",
    'OpeningQuantity' => "ALTER TABLE Inventory ADD COLUMN OpeningQuantity DECIMAL(12, 2) NOT NULL DEFAULT 0.00",
    'QuantityOnHand' => "ALTER TABLE Inventory ADD COLUMN QuantityOnHand DECIMAL(12, 2) NOT NULL DEFAULT 0.00",
    'Status' => "ALTER TABLE Inventory ADD COLUMN Status VARCHAR(40) DEFAULT 'Active'",
    'Description' => "ALTER TABLE Inventory ADD COLUMN Description TEXT",
]);

mysqli_query($conn, "UPDATE Inventory SET QuantityOnHand = OpeningQuantity WHERE QuantityOnHand = 0 AND OpeningQuantity <> 0");

ensure_columns($conn, 'suppliers', [
    'TINumber' => "ALTER TABLE suppliers ADD COLUMN TINumber VARCHAR(50) DEFAULT NULL",
    'Type' => "ALTER TABLE suppliers ADD COLUMN Type VARCHAR(80) DEFAULT NULL",
    'SUName' => "ALTER TABLE suppliers ADD COLUMN SUName VARCHAR(150) NOT NULL DEFAULT ''",
    'BName' => "ALTER TABLE suppliers ADD COLUMN BName VARCHAR(120) NOT NULL DEFAULT ''",
    'ACNumber' => "ALTER TABLE suppliers ADD COLUMN ACNumber VARCHAR(80) NOT NULL DEFAULT ''",
    'Phone' => "ALTER TABLE suppliers ADD COLUMN Phone VARCHAR(40) DEFAULT NULL",
    'Email' => "ALTER TABLE suppliers ADD COLUMN Email VARCHAR(150) DEFAULT NULL",
    'ContactPerson' => "ALTER TABLE suppliers ADD COLUMN ContactPerson VARCHAR(150) DEFAULT NULL",
    'Address' => "ALTER TABLE suppliers ADD COLUMN Address VARCHAR(180) DEFAULT NULL",
    'City' => "ALTER TABLE suppliers ADD COLUMN City VARCHAR(100) DEFAULT NULL",
    'Country' => "ALTER TABLE suppliers ADD COLUMN Country VARCHAR(100) DEFAULT NULL",
    'PaymentTerms' => "ALTER TABLE suppliers ADD COLUMN PaymentTerms VARCHAR(50) DEFAULT NULL",
    'CreditLimit' => "ALTER TABLE suppliers ADD COLUMN CreditLimit DECIMAL(12, 2) NOT NULL DEFAULT 0.00",
    'Status' => "ALTER TABLE suppliers ADD COLUMN Status VARCHAR(40) DEFAULT 'Active'",
    'Notes' => "ALTER TABLE suppliers ADD COLUMN Notes TEXT",
]);

ensure_columns($conn, 'customers', [
    'CustomerID' => "ALTER TABLE customers ADD COLUMN CustomerID VARCHAR(50) DEFAULT NULL",
    'Type' => "ALTER TABLE customers ADD COLUMN Type VARCHAR(80) DEFAULT NULL",
    'CName' => "ALTER TABLE customers ADD COLUMN CName VARCHAR(150) NOT NULL DEFAULT ''",
    'BName' => "ALTER TABLE customers ADD COLUMN BName VARCHAR(120) DEFAULT NULL",
    'ACNumber' => "ALTER TABLE customers ADD COLUMN ACNumber VARCHAR(80) DEFAULT NULL",
    'Phone' => "ALTER TABLE customers ADD COLUMN Phone VARCHAR(40) DEFAULT NULL",
    'Email' => "ALTER TABLE customers ADD COLUMN Email VARCHAR(150) DEFAULT NULL",
    'ContactPerson' => "ALTER TABLE customers ADD COLUMN ContactPerson VARCHAR(150) DEFAULT NULL",
    'Address' => "ALTER TABLE customers ADD COLUMN Address VARCHAR(180) DEFAULT NULL",
    'City' => "ALTER TABLE customers ADD COLUMN City VARCHAR(100) DEFAULT NULL",
    'Country' => "ALTER TABLE customers ADD COLUMN Country VARCHAR(100) DEFAULT NULL",
    'PaymentTerms' => "ALTER TABLE customers ADD COLUMN PaymentTerms VARCHAR(50) DEFAULT NULL",
    'CreditLimit' => "ALTER TABLE customers ADD COLUMN CreditLimit DECIMAL(12, 2) NOT NULL DEFAULT 0.00",
    'Status' => "ALTER TABLE customers ADD COLUMN Status VARCHAR(40) DEFAULT 'Active'",
    'Notes' => "ALTER TABLE customers ADD COLUMN Notes TEXT",
]);

function esc($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function post_value(mysqli $conn, string $key): string
{
    return $conn->real_escape_string(trim($_POST[$key] ?? ''));
}

$row = [];
$editingId = isset($_POST['inventory_code']) ? (int) $_POST['inventory_code'] : (isset($_GET['id']) ? (int) $_GET['id'] : 0);
$supplierRow = [];
$supplierEditingTin = isset($_GET['tin']) ? $_GET['tin'] : '';
$customerRow = [];
$customerEditingId = isset($_GET['customer']) ? $_GET['customer'] : '';
$currentUserName = 'Theoneste';

if (isset($_POST['save_stock_count'])) {
    $itemCode = (int) ($_POST['item_code'] ?? 0);
    $physicalQuantity = (float) ($_POST['physical_quantity'] ?? 0);
    $isAjax = isset($_POST['ajax']);

    $stockResult = mysqli_query($conn, "SELECT Code, Name, QuantityOnHand FROM Inventory WHERE Code = $itemCode LIMIT 1");
    $stockRow = $stockResult ? mysqli_fetch_assoc($stockResult) : null;

    if ($stockRow) {
        $itemName = $conn->real_escape_string((string) $stockRow['Name']);
        $systemQuantity = (float) ($stockRow['QuantityOnHand'] ?? 0);
        $adjustmentQuantity = $physicalQuantity - $systemQuantity;
        $safeUserName = $conn->real_escape_string($currentUserName);

        $insertAdjustment = "INSERT INTO stock_adjustments(ItemCode, ItemName, SystemQuantity, PhysicalQuantity, AdjustmentQuantity, CreatedBy) VALUES ($itemCode,'$itemName',$systemQuantity,$physicalQuantity,$adjustmentQuantity,'$safeUserName')";
        $queryAdjustment = mysqli_query($conn, $insertAdjustment);
        $queryInventory = mysqli_query($conn, "UPDATE Inventory SET QuantityOnHand = $physicalQuantity WHERE Code = $itemCode");

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => (bool) ($queryAdjustment && $queryInventory),
                'itemCode' => (string) $itemCode,
                'itemName' => (string) $stockRow['Name'],
                'systemQuantity' => number_format($systemQuantity, 2, '.', ''),
                'physicalQuantity' => number_format($physicalQuantity, 2, '.', ''),
                'adjustmentQuantity' => number_format($adjustmentQuantity, 2, '.', ''),
                'createdBy' => $currentUserName,
                'createdAt' => date('Y-m-d H:i:s'),
            ]);
            exit;
        }

        header("Location: home.php?view=report");
        exit;
    }

    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Inventory item was not found.']);
        exit;
    }
}

if (isset($_POST['supp'])) {
    $tin = post_value($conn, 'tinn');
    $sty = post_value($conn, 'styp');
    $namm = post_value($conn, 'snammm');
    $contact = post_value($conn, 'supplier_contact');
    $bank = post_value($conn, 'bankk');
    $acc = post_value($conn, 'acc');
    $mob = post_value($conn, 'mob');
    $email = post_value($conn, 'email');
    $address = post_value($conn, 'supplier_address');
    $city = post_value($conn, 'supplier_city');
    $country = post_value($conn, 'supplier_country');
    $paymentTerms = post_value($conn, 'supplier_payment_terms');
    $creditLimit = (float) ($_POST['supplier_credit_limit'] ?? 0);
    $status = post_value($conn, 'supplier_status');
    $notes = post_value($conn, 'supplier_notes');

    if ($supplierEditingTin !== '') {
        $safeTin = $conn->real_escape_string($supplierEditingTin);
        $updatesup = "UPDATE suppliers SET Type='$sty', SUName='$namm', ContactPerson='$contact', BName='$bank', ACNumber='$acc', Phone='$mob', Email='$email', Address='$address', City='$city', Country='$country', PaymentTerms='$paymentTerms', CreditLimit=$creditLimit, Status='$status', Notes='$notes' WHERE TINumber='$safeTin'";
        $querysup = mysqli_query($conn, $updatesup);
    } else {
        $insertsup = "INSERT INTO suppliers(TINumber, Type, SUName, ContactPerson, BName, ACNumber, Phone, Email, Address, City, Country, PaymentTerms, CreditLimit, Status, Notes) VALUES ('$tin','$sty','$namm','$contact','$bank','$acc','$mob','$email','$address','$city','$country','$paymentTerms',$creditLimit,'$status','$notes')";
        $querysup = mysqli_query($conn, $insertsup);
    }

    if ($querysup) {
        header("Location: home.php?view=partners&type=supplier&tin=" . urlencode($supplierEditingTin !== '' ? $supplierEditingTin : $tin));
        exit;
    }
}

if (isset($_POST['cust'])) {
    $customerId = post_value($conn, 'customer_id');
    $customerType = post_value($conn, 'customer_type');
    $customerName = post_value($conn, 'customer_name');
    $contact = post_value($conn, 'customer_contact');
    $bank = post_value($conn, 'customer_bank');
    $acc = post_value($conn, 'customer_acc');
    $mob = post_value($conn, 'customer_phone');
    $email = post_value($conn, 'customer_email');
    $address = post_value($conn, 'customer_address');
    $city = post_value($conn, 'customer_city');
    $country = post_value($conn, 'customer_country');
    $paymentTerms = post_value($conn, 'customer_payment_terms');
    $creditLimit = (float) ($_POST['customer_credit_limit'] ?? 0);
    $status = post_value($conn, 'customer_status');
    $notes = post_value($conn, 'customer_notes');

    if ($customerEditingId !== '') {
        $safeCustomerId = $conn->real_escape_string($customerEditingId);
        $updateCustomer = "UPDATE customers SET Type='$customerType', CName='$customerName', ContactPerson='$contact', BName='$bank', ACNumber='$acc', Phone='$mob', Email='$email', Address='$address', City='$city', Country='$country', PaymentTerms='$paymentTerms', CreditLimit=$creditLimit, Status='$status', Notes='$notes' WHERE CustomerID='$safeCustomerId'";
        $queryCustomer = mysqli_query($conn, $updateCustomer);
    } else {
        $insertCustomer = "INSERT INTO customers(CustomerID, Type, CName, ContactPerson, BName, ACNumber, Phone, Email, Address, City, Country, PaymentTerms, CreditLimit, Status, Notes) VALUES ('$customerId','$customerType','$customerName','$contact','$bank','$acc','$mob','$email','$address','$city','$country','$paymentTerms',$creditLimit,'$status','$notes')";
        $queryCustomer = mysqli_query($conn, $insertCustomer);
    }

    if ($queryCustomer) {
        header("Location: home.php?view=partners&type=customer&customer=" . urlencode($customerEditingId !== '' ? $customerEditingId : $customerId));
        exit;
    }
}

if (isset($_POST['send'])) {
    $skuin = post_value($conn, 'sku');
    $namein = post_value($conn, 'nam');
    $brandin = post_value($conn, 'brand');
    $manufacturerin = post_value($conn, 'manufacturer');
    $modelin = post_value($conn, 'mod');
    $typein = post_value($conn, 'typ');
    $categoryin = post_value($conn, 'cat');
    $measurein = post_value($conn, 'uom');
    $barcodein = post_value($conn, 'barcode');
    $reorderin = (float) ($_POST['reorder'] ?? 0);
    $openingqtyin = (float) ($_POST['opening_qty'] ?? 0);
    $costin = (float) ($_POST['cos'] ?? 0);
    $pricein = (float) ($_POST['pric'] ?? 0);
    $locationin = post_value($conn, 'loc');
    $statusin = post_value($conn, 'status');
    $descriptionin = post_value($conn, 'description');

    if ($editingId > 0) {
        $update = "UPDATE Inventory SET SKU='$skuin', Name='$namein', Brand='$brandin', Manufacturer='$manufacturerin', Models='$modelin', Types='$typein', Categories='$categoryin', Measures='$measurein', Barcode='$barcodein', ReorderLevel=$reorderin, OpeningQuantity=$openingqtyin, Cost=$costin, Price=$pricein, Location='$locationin', Status='$statusin', Description='$descriptionin' WHERE Code=$editingId";
        $query = mysqli_query($conn, $update);
    } else {
        $insert = "INSERT INTO Inventory(SKU, Name, Brand, Manufacturer, Models, Types, Categories, Measures, Barcode, ReorderLevel, OpeningQuantity, QuantityOnHand, Cost, Price, Location, Status, Description) VALUES ('$skuin','$namein','$brandin','$manufacturerin','$modelin','$typein','$categoryin','$measurein','$barcodein',$reorderin,$openingqtyin,$openingqtyin,$costin,$pricein,'$locationin','$statusin','$descriptionin')";
        $query = mysqli_query($conn, $insert);
        $editingId = mysqli_insert_id($conn);
    }

    if ($query) {
        header("Location: home.php?id=" . (int) $editingId);
        exit;
    }

    echo "<script>alert('Save failed');</script>";
}

if (isset($_POST['save_purchase'])) {
    $purchaseSupplier = post_value($conn, 'purchase_supplier');
    $purchaseSupplierTin = post_value($conn, 'purchase_supplier_tin');
    $invoiceNumber = post_value($conn, 'purchase_invoice_number');
    $invoiceDate = post_value($conn, 'purchase_invoice_date');
    $paymentOption = post_value($conn, 'purchase_payment_option');
    $itemCodes = $_POST['purchase_item_code'] ?? [];
    $itemNames = $_POST['purchase_item_name'] ?? [];
    $quantities = $_POST['purchase_quantity'] ?? [];
    $costs = $_POST['purchase_cost'] ?? [];
    $purchaseItems = [];

    foreach ($itemCodes as $index => $codeValue) {
        $itemCode = (int) $codeValue;
        $itemName = $conn->real_escape_string(trim($itemNames[$index] ?? ''));
        $quantity = (float) ($quantities[$index] ?? 0);
        $cost = (float) ($costs[$index] ?? 0);

        if ($itemCode <= 0 || $itemName === '' || $quantity <= 0) {
            continue;
        }

        $purchaseItems[] = [
            'itemCode' => $itemCode,
            'itemName' => $itemName,
            'quantity' => $quantity,
            'cost' => $cost,
        ];
    }

    if (!empty($purchaseItems)) {
        $existingInvoiceCheck = mysqli_query($conn, "SELECT POID FROM purchase_orders WHERE InvoiceNumber = '$invoiceNumber' LIMIT 1");
        if ($existingInvoiceCheck && mysqli_num_rows($existingInvoiceCheck) > 0) {
            mysqli_query($conn, "DELETE FROM purchase_orders WHERE InvoiceNumber = '$invoiceNumber'");
        }

        $queryPurchase = false;
        foreach ($purchaseItems as $item) {
            $safeInvoiceDate = $invoiceDate !== '' ? "'$invoiceDate'" : "NULL";
            $insertPurchase = "INSERT INTO purchase_orders(SupplierName, SupplierTIN, InvoiceNumber, InvoiceDate, PaymentOption, ItemCode, ItemName, Quantity, Cost) VALUES ('$purchaseSupplier','$purchaseSupplierTin','$invoiceNumber',$safeInvoiceDate,'$paymentOption',{$item['itemCode']},'{$item['itemName']}',{$item['quantity']},{$item['cost']})";
            $queryPurchase = mysqli_query($conn, $insertPurchase);
            if ($queryPurchase) {
                mysqli_query($conn, "UPDATE Inventory SET QuantityOnHand = QuantityOnHand + {$item['quantity']} WHERE Code = {$item['itemCode']}");
            }
        }

        if ($queryPurchase) {
            header("Location: home.php?view=purchase");
            exit;
        }
    }

    echo "<script>alert('Purchase order save failed');</script>";
}

if (isset($_POST['save_sales'])) {
    $salesCustomer = post_value($conn, 'sales_customer');
    $salesCustomerTin = post_value($conn, 'sales_customer_tin');
    $invoiceNumber = post_value($conn, 'sales_invoice_number');
    $invoiceDate = post_value($conn, 'sales_invoice_date');
    $paymentOption = post_value($conn, 'sales_payment_option');
    $itemCodes = $_POST['sales_item_code'] ?? [];
    $itemNames = $_POST['sales_item_name'] ?? [];
    $quantities = $_POST['sales_quantity'] ?? [];
    $prices = $_POST['sales_price'] ?? [];
    $salesItems = [];
    $querySales = false;

    foreach ($itemCodes as $index => $codeValue) {
        $itemCode = (int) $codeValue;
        $itemName = $conn->real_escape_string(trim($itemNames[$index] ?? ''));
        $quantity = (float) ($quantities[$index] ?? 0);
        $price = (float) ($prices[$index] ?? 0);

        if ($itemCode <= 0 || $itemName === '' || $quantity <= 0) {
            continue;
        }

        $stockResult = mysqli_query($conn, "SELECT QuantityOnHand FROM Inventory WHERE Code = $itemCode LIMIT 1");
        $stockRow = $stockResult ? mysqli_fetch_assoc($stockResult) : null;
        $available = (float) ($stockRow['QuantityOnHand'] ?? 0);

        if ($available < $quantity) {
            echo "<script>alert('Sales order save failed: not enough stock for $itemName. Available balance is $available');</script>";
            continue;
        }

        $salesItems[] = [
            'itemCode' => $itemCode,
            'itemName' => $itemName,
            'quantity' => $quantity,
            'price' => $price,
        ];
    }

    if (!empty($salesItems)) {
        $existingInvoiceCheck = mysqli_query($conn, "SELECT SOID FROM sales_orders WHERE InvoiceNumber = '$invoiceNumber' LIMIT 1");
        if ($existingInvoiceCheck && mysqli_num_rows($existingInvoiceCheck) > 0) {
            mysqli_query($conn, "DELETE FROM sales_orders WHERE InvoiceNumber = '$invoiceNumber'");
        }

        $safeInvoiceDate = $invoiceDate !== '' ? "'$invoiceDate'" : "NULL";
        foreach ($salesItems as $item) {
            $insertSales = "INSERT INTO sales_orders(CustomerName, CustomerTIN, InvoiceNumber, InvoiceDate, PaymentOption, ItemCode, ItemName, Quantity, Price) VALUES ('$salesCustomer','$salesCustomerTin','$invoiceNumber',$safeInvoiceDate,'$paymentOption',{$item['itemCode']},'{$item['itemName']}',{$item['quantity']},{$item['price']})";
            $querySales = mysqli_query($conn, $insertSales);
            if ($querySales) {
                mysqli_query($conn, "UPDATE Inventory SET QuantityOnHand = QuantityOnHand - {$item['quantity']} WHERE Code = {$item['itemCode']}");
            }
        }

        if ($querySales) {
            header("Location: home.php?view=orders&type=sales");
            exit;
        }
    }
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $single = "SELECT * FROM Inventory WHERE Code = $id LIMIT 1";
    $singleResult = mysqli_query($conn, $single);

    if ($singleResult && mysqli_num_rows($singleResult) > 0) {
        $row = mysqli_fetch_assoc($singleResult);
    }
}

$sel = "SELECT * FROM Inventory ORDER BY Code ASC";
$output = mysqli_query($conn, $sel);
$inventoryRows = [];
$inventoryListHtml = "<table class='listing-table'><thead><tr><th>Code</th><th>Name</th><th>Model</th><th>Balance</th></tr></thead><tbody>";

if ($output && mysqli_num_rows($output) > 0) {
    while ($fetch = mysqli_fetch_assoc($output)) {
        $inventoryRows[] = $fetch;
        $code = esc($fetch['Code']);
        $name = esc($fetch['Name']);
        $model = esc($fetch['Models']);
        $location = esc($fetch['Location']);
        $quantityOnHand = esc(number_format((float) ($fetch['QuantityOnHand'] ?? 0), 2));

        $inventoryListHtml .= "<tr class='listing-row' onclick=\"selectInventory(this)\"
            data-id=\"$code\"
            data-sku=\"" . esc($fetch['SKU'] ?? '') . "\"
            data-name=\"$name\"
            data-brand=\"" . esc($fetch['Brand'] ?? '') . "\"
            data-manufacturer=\"" . esc($fetch['Manufacturer'] ?? '') . "\"
            data-cost=\"" . esc($fetch['Cost']) . "\"
            data-location=\"$location\"
            data-quantity=\"$quantityOnHand\"
            data-model=\"$model\"
            data-price=\"" . esc($fetch['Price']) . "\"
            data-type=\"" . esc($fetch['Types']) . "\"
            data-category=\"" . esc($fetch['Categories']) . "\"
            data-measure=\"" . esc($fetch['Measures']) . "\"
            data-barcode=\"" . esc($fetch['Barcode'] ?? '') . "\"
            data-reorder=\"" . esc($fetch['ReorderLevel'] ?? '') . "\"
            data-opening-qty=\"" . esc($fetch['OpeningQuantity'] ?? '') . "\"
            data-status=\"" . esc($fetch['Status'] ?? '') . "\"
            data-description=\"" . esc($fetch['Description'] ?? '') . "\">
            <td><strong class='sf-pro-ident'>STK3090$code</strong></td>
            <td>$name</td>
            <td>$model</td>
            <td>$quantityOnHand</td>
        </tr>";
    }
} else {
    $inventoryListHtml .= "<tr><td colspan='4'>No inventory items found.</td></tr>";
}
$inventoryListHtml .= "</tbody></table>";

$selectsup = "SELECT * FROM suppliers ORDER BY TINumber ASC";
$querysup = mysqli_query($conn, $selectsup);
$supplierListHtml = "<table class='listing-table'><thead><tr><th>TIN</th><th>Name</th><th>Type</th><th>Bank</th></tr></thead><tbody>";
if ($querysup && mysqli_num_rows($querysup) > 0) {
    while ($getsup = mysqli_fetch_assoc($querysup)) {
        $tin = esc($getsup['TINumber']);
        $type = esc($getsup['Type']);
        $name = esc($getsup['SUName']);
        $bank = esc($getsup['BName']);

        $supplierListHtml .= "<tr class='listing-row' onclick=\"window.location.href='?view=partners&type=supplier&tin=" . urlencode($getsup['TINumber']) . "'\">
            <td><strong class='sf-pro-ident'>$tin</strong></td>
            <td>$name</td>
            <td>$type</td>
            <td>$bank</td>
        </tr>";
    }
} else {
    $supplierListHtml .= "<tr><td colspan='4'>No suppliers found.</td></tr>";
}
$supplierListHtml .= "</tbody></table>";

$supplierOptionsForJs = [];
$supplierOptionsResult = mysqli_query($conn, "SELECT TINumber, SUName FROM suppliers ORDER BY SUName ASC");
if ($supplierOptionsResult && mysqli_num_rows($supplierOptionsResult) > 0) {
    while ($supplierOption = mysqli_fetch_assoc($supplierOptionsResult)) {
        $supplierOptionsForJs[] = [
            'tin' => (string) $supplierOption['TINumber'],
            'name' => (string) $supplierOption['SUName'],
        ];
    }
}

if ($supplierEditingTin !== '') {
    $safeTin = $conn->real_escape_string($supplierEditingTin);
    $singleSupplier = "SELECT * FROM suppliers WHERE TINumber = '$safeTin' LIMIT 1";
    $singleSupplierResult = mysqli_query($conn, $singleSupplier);

    if ($singleSupplierResult && mysqli_num_rows($singleSupplierResult) > 0) {
        $supplierRow = mysqli_fetch_assoc($singleSupplierResult);
    }
}
$supplierRowSafe = array_map('esc', $supplierRow);

$selectCustomers = "SELECT * FROM customers ORDER BY CustomerID ASC";
$queryCustomers = mysqli_query($conn, $selectCustomers);
$customerListHtml = "<table class='listing-table'><thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Phone</th></tr></thead><tbody>";
$customerOptionsForJs = [];
if ($queryCustomers && mysqli_num_rows($queryCustomers) > 0) {
    while ($customer = mysqli_fetch_assoc($queryCustomers)) {
        $customerOptionsForJs[] = [
            'id' => (string) $customer['CustomerID'],
            'name' => (string) $customer['CName'],
            'type' => (string) $customer['Type'],
        ];
        $customerId = esc($customer['CustomerID']);
        $type = esc($customer['Type']);
        $name = esc($customer['CName']);
        $phone = esc($customer['Phone']);

        $customerListHtml .= "<tr class='listing-row' onclick=\"window.location.href='?view=partners&type=customer&customer=" . urlencode($customer['CustomerID']) . "'\">
            <td><strong class='sf-pro-ident'>$customerId</strong></td>
            <td>$name</td>
            <td>$type</td>
            <td>$phone</td>
        </tr>";
    }
} else {
    $customerListHtml .= "<tr><td colspan='4'>No customers found.</td></tr>";
}
$customerListHtml .= "</tbody></table>";

if ($customerEditingId !== '') {
    $safeCustomerId = $conn->real_escape_string($customerEditingId);
    $singleCustomer = "SELECT * FROM customers WHERE CustomerID = '$safeCustomerId' LIMIT 1";
    $singleCustomerResult = mysqli_query($conn, $singleCustomer);

    if ($singleCustomerResult && mysqli_num_rows($singleCustomerResult) > 0) {
        $customerRow = mysqli_fetch_assoc($singleCustomerResult);
    }
}
$customerRowSafe = array_map('esc', $customerRow);

$purchaseResult = mysqli_query($conn, "SELECT * FROM purchase_orders ORDER BY POID ASC");
$purchaseListHtml = "<table class='listing-table'><thead><tr><th>PO</th><th>Invoice</th><th>Supplier</th><th>Qty</th><th>Cost</th></tr></thead><tbody>";
$purchaseRowsForJs = [];
if ($purchaseResult && mysqli_num_rows($purchaseResult) > 0) {
    $purchaseGroups = [];
    while ($purchase = mysqli_fetch_assoc($purchaseResult)) {
        $invoiceKey = trim((string) ($purchase['InvoiceNumber'] ?? ''));
        if ($invoiceKey === '') {
            $invoiceKey = 'PO' . (string) $purchase['POID'];
        }

        if (!isset($purchaseGroups[$invoiceKey])) {
            $purchaseGroups[$invoiceKey] = [
                'po' => $invoiceKey,
                'invoice' => (string) $purchase['InvoiceNumber'],
                'date' => (string) $purchase['InvoiceDate'],
                'payment' => (string) $purchase['PaymentOption'],
                'supplier' => (string) $purchase['SupplierName'],
                'tin' => (string) $purchase['SupplierTIN'],
                'latestLineId' => 0,
                'lines' => [],
            ];
        }

        $purchaseGroups[$invoiceKey]['latestLineId'] = max((int) $purchaseGroups[$invoiceKey]['latestLineId'], (int) $purchase['POID']);

        $purchaseGroups[$invoiceKey]['lines'][] = [
            'lineId' => (string) $purchase['POID'],
            'itemCode' => (string) $purchase['ItemCode'],
            'itemName' => (string) $purchase['ItemName'],
            'quantity' => (string) $purchase['Quantity'],
            'cost' => (string) $purchase['Cost'],
        ];
    }

    $purchaseRowsForJs = array_values($purchaseGroups);
    usort($purchaseRowsForJs, function ($first, $second) {
        return (int) ($second['latestLineId'] ?? 0) <=> (int) ($first['latestLineId'] ?? 0);
    });
    foreach ($purchaseRowsForJs as $group) {
        $totalQty = 0.0;
        $totalCost = 0.0;
        foreach ($group['lines'] as $line) {
            $quantity = (float) $line['quantity'];
            $cost = (float) $line['cost'];
            $totalQty += $quantity;
            $totalCost += $quantity * $cost;
        }

        $displayPo = $group['invoice'] !== '' ? $group['invoice'] : $group['po'];
        $purchaseClickValue = esc(json_encode($group['po']));
        $purchaseListHtml .= "<tr class='listing-row' onclick=\"selectPurchaseOrder(" . $purchaseClickValue . ")\">
            <td>PO" . esc($displayPo) . "</td>
            <td>" . esc($group['invoice']) . "</td>
            <td>" . esc($group['supplier']) . "</td>
            <td>" . esc(number_format($totalQty, 2)) . "</td>
            <td>" . esc(number_format($totalCost, 2)) . "</td>
        </tr>";
    }
} else {
    $purchaseListHtml .= "<tr><td colspan='5'>No purchase orders found.</td></tr>";
}
$purchaseListHtml .= "</tbody></table>";

$salesResult = mysqli_query($conn, "SELECT * FROM sales_orders ORDER BY SOID ASC");
$salesListHtml = "<table class='listing-table'><thead><tr><th>SO</th><th>Invoice</th><th>Customer</th><th>Qty</th><th>Price</th></tr></thead><tbody>";
$salesRowsForJs = [];
if ($salesResult && mysqli_num_rows($salesResult) > 0) {
    $salesGroups = [];
    while ($sales = mysqli_fetch_assoc($salesResult)) {
        $invoiceKey = trim((string) ($sales['InvoiceNumber'] ?? ''));
        if ($invoiceKey === '') {
            $invoiceKey = 'SO' . (string) $sales['SOID'];
        }

        if (!isset($salesGroups[$invoiceKey])) {
            $salesGroups[$invoiceKey] = [
                'so' => $invoiceKey,
                'invoice' => (string) $sales['InvoiceNumber'],
                'date' => (string) $sales['InvoiceDate'],
                'payment' => (string) $sales['PaymentOption'],
                'customer' => (string) $sales['CustomerName'],
                'tin' => (string) $sales['CustomerTIN'],
                'latestLineId' => 0,
                'lines' => [],
            ];
        }

        $salesGroups[$invoiceKey]['latestLineId'] = max((int) $salesGroups[$invoiceKey]['latestLineId'], (int) $sales['SOID']);

        $salesGroups[$invoiceKey]['lines'][] = [
            'lineId' => (string) $sales['SOID'],
            'itemCode' => (string) $sales['ItemCode'],
            'itemName' => (string) $sales['ItemName'],
            'quantity' => (string) $sales['Quantity'],
            'price' => (string) $sales['Price'],
        ];
    }

    $salesRowsForJs = array_values($salesGroups);
    usort($salesRowsForJs, function ($first, $second) {
        return (int) ($second['latestLineId'] ?? 0) <=> (int) ($first['latestLineId'] ?? 0);
    });
    foreach ($salesRowsForJs as $group) {
        $totalQty = 0.0;
        $totalPrice = 0.0;
        foreach ($group['lines'] as $line) {
            $quantity = (float) $line['quantity'];
            $price = (float) $line['price'];
            $totalQty += $quantity;
            $totalPrice += $quantity * $price;
        }

        $displaySo = $group['invoice'] !== '' ? $group['invoice'] : $group['so'];
        $salesClickValue = esc(json_encode($group['so']));
        $salesListHtml .= "<tr class='listing-row' onclick=\"selectSalesOrder(" . $salesClickValue . ")\">"
            . "<td>SO" . esc($displaySo) . "</td>"
            . "<td>" . esc($group['invoice']) . "</td>"
            . "<td>" . esc($group['customer']) . "</td>"
            . "<td>" . esc(number_format($totalQty, 2)) . "</td>"
            . "<td>" . esc(number_format($totalPrice, 2)) . "</td>"
            . "</tr>";
    }
} else {
    $salesListHtml .= "<tr><td colspan='5'>No sales orders found.</td></tr>";
}
$salesListHtml .= "</tbody></table>";

$inventoryItemsForJs = array_map(function ($item) {
    return [
        'code' => (string) $item['Code'],
        'name' => (string) $item['Name'],
        'cost' => (string) $item['Cost'],
        'price' => (string) $item['Price'],
        'quantity' => (string) ($item['QuantityOnHand'] ?? 0),
    ];
}, $inventoryRows);

$stockAdjustmentRowsForJs = [];
$stockAdjustmentResult = mysqli_query($conn, "SELECT * FROM stock_adjustments ORDER BY AdjustmentID DESC");
if ($stockAdjustmentResult && mysqli_num_rows($stockAdjustmentResult) > 0) {
    while ($adjustment = mysqli_fetch_assoc($stockAdjustmentResult)) {
        $stockAdjustmentRowsForJs[] = [
            'id' => (string) $adjustment['AdjustmentID'],
            'itemCode' => (string) $adjustment['ItemCode'],
            'itemName' => (string) $adjustment['ItemName'],
            'systemQuantity' => (string) $adjustment['SystemQuantity'],
            'physicalQuantity' => (string) $adjustment['PhysicalQuantity'],
            'adjustmentQuantity' => (string) $adjustment['AdjustmentQuantity'],
            'createdBy' => (string) $adjustment['CreatedBy'],
            'createdAt' => (string) $adjustment['CreatedAt'],
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistix Management Software</title>
    <link rel="stylesheet" href="index.css">
    <style>
        @media print {
            .main-nav,
            .displayer,
            .panel-settings,
            .searchbar,
            .listing-table.report-menu {
                display: none !important;
            }
            .register {
                width: 100%;
                margin: 0;
            }
        }
    </style>
</head>
<body>
<div class="page-overlay" id="pageOverlay" aria-hidden="true">
    <div class="loading-card">
        <div class="spinner"></div>
        <div class="loading-text">Saving data...</div>
    </div>
</div>

<div class="main-nav">
    <button onclick="showInventory()">Inventory</button>
    <button onclick="showOrders('purchase')">In/Outbound Logistics</button>
    <button onclick="showPartners('supplier')">Business Partners</button>
    <button onclick="showReport()">Financial Reporting</button>
    
    <button onclick="showSettings()" class="settings-button" style="display:none;" aria-hidden="true">Finance Management</button>
    <span class="current-user">
        <img src="1737793857402.jpg" alt="Storekeeper avatar">
        <span><strong><?php echo esc($currentUserName); ?></strong><small>Storekeeper</small></span>
    </span>
</div>

<div class="contents" id="registerblock">
    <div class="displayer">
        <p><input type="text" placeholder="Search Items" class="searchbar" oninput="filterTables(this)"></p>
        <?php echo $inventoryListHtml; ?>
    </div>

    <div class="register">
        <br>
        <p class="register-item">Stock Item Register</p>

        <div class="panel-settings">
            <button type="button" onclick="showInventoryNew()">New</button>
            <button type="button" onclick="saveInventory()">Save</button>
            <button>Copy</button>
            <button>Buy</button>
            <button>Sell</button>
            <button>Import</button>
            <button>Attachments</button>
            <button>Deactivate</button>
        </div>

        <div class="Data-Entry">
            <br>
            <p class="info">Basic Info</p>
            <br>

            <form method="POST">
                <input type="hidden" name="send" value="1">
                <input type="hidden" name="inventory_code" id="inventory_code" value="<?php echo $editingId > 0 ? $editingId : ''; ?>">
                <div class="form-grid logistics-grid">
                    <input type="text" name="sku" placeholder="SKU / Internal Code" value="<?php echo esc($row['SKU'] ?? ''); ?>">
                    <input type="text" name="nam" placeholder="Item Name" value="<?php echo esc($row['Name'] ?? ''); ?>" required>
                    <input type="text" name="brand" placeholder="Brand" value="<?php echo esc($row['Brand'] ?? ''); ?>">
                    <input type="text" name="manufacturer" placeholder="Manufacturer" value="<?php echo esc($row['Manufacturer'] ?? ''); ?>">
                    <input type="text" name="mod" placeholder="Item Model" value="<?php echo esc($row['Models'] ?? ''); ?>">
                    <input list="itemtype-list" name="typ" placeholder="Item Type" value="<?php echo esc($row['Types'] ?? ''); ?>" required>
                    <input list="category-list" name="cat" placeholder="Logistics Category" value="<?php echo esc($row['Categories'] ?? ''); ?>" required>
                    <input list="options" name="uom" placeholder="Standard Measurement Unit" value="<?php echo esc($row['Measures'] ?? ''); ?>" required>
                    <input type="text" name="barcode" placeholder="Barcode / Serial Reference" value="<?php echo esc($row['Barcode'] ?? ''); ?>">
                    <input type="number" step="0.01" name="opening_qty" placeholder="Opening Quantity" value="<?php echo esc($row['OpeningQuantity'] ?? ''); ?>">
                    <input type="number" step="0.01" name="reorder" placeholder="Reorder Level" value="<?php echo esc($row['ReorderLevel'] ?? ''); ?>">
                    <input type="text" name="loc" placeholder="Warehouse Location" value="<?php echo esc($row['Location'] ?? ''); ?>">
                    <input type="number" step="0.01" name="cos" placeholder="Unit Cost" value="<?php echo esc($row['Cost'] ?? ''); ?>" required>
                    <input type="number" step="0.01" name="pric" placeholder="Normal Selling Price" value="<?php echo esc($row['Price'] ?? ''); ?>" required>
                    <input list="inventory-status-list" name="status" placeholder="Status" value="<?php echo esc($row['Status'] ?? 'Active'); ?>">
                    <textarea class="Itemtextarea" name="description" placeholder="Item Description / Notes"><?php echo esc($row['Description'] ?? ''); ?></textarea>
                </div>
                <datalist id="itemtype-list">
                    <option value="Stocked">
                    <option value="Non-Registered">
                    <option value="Service">
                    <option value="Serial Numbered">
                    <option value="Consumable">
                    <option value="Fixed Asset">
                </datalist>
                <datalist id="category-list">
                    <option value="Engineering">
                    <option value="Mechanics">
                    <option value="Electricity">
                    <option value="Lubricants">
                    <option value="Oil and Fuel">
                    <option value="Woods/Carpenting">
                    <option value="Leather/Textiles">
                    <option value="Packaging">
                    <option value="Safety Equipment">
                    <option value="Office Supplies">
                </datalist>
                <datalist id="options">
                    <option value="Kgs">
                    <option value="Mtrs">
                    <option value="Rolls">
                    <option value="Pcs">
                    <option value="Ltrs">
                    <option value="Tins">
                    <option value="Pairs">
                    <option value="Boxes">
                    <option value="Cartons">
                    <option value="Sets">
                </datalist>
                <datalist id="inventory-status-list">
                    <option value="Active">
                    <option value="Inactive">
                    <option value="Discontinued">
                    <option value="Pending Approval">
                </datalist>
                <input type="submit" name="send" value="Request an Approval" class="submit-button">
            </form>
        </div>
    </div>
</div>

<script>
    const supplierListHtml = <?php echo json_encode($supplierListHtml); ?>;
    const customerListHtml = <?php echo json_encode($customerListHtml); ?>;
    const purchaseListHtml = <?php echo json_encode($purchaseListHtml); ?>;
    const salesListHtml = <?php echo json_encode($salesListHtml); ?>;
    const initialView = <?php echo json_encode($_GET['view'] ?? 'inventory'); ?>;
    const initialPartnerType = <?php echo json_encode($_GET['type'] ?? 'supplier'); ?>;
    const supplierRow = <?php echo json_encode($supplierRowSafe); ?>;
    const customerRow = <?php echo json_encode($customerRowSafe); ?>;
    const supplierOptions = <?php echo json_encode($supplierOptionsForJs); ?>;
    const customerOptions = <?php echo json_encode($customerOptionsForJs); ?>;
    let inventoryItems = <?php echo json_encode($inventoryItemsForJs); ?>;
    let stockAdjustmentRows = <?php echo json_encode($stockAdjustmentRowsForJs); ?>;
    const purchaseRows = <?php echo json_encode($purchaseRowsForJs); ?>;
    const salesRows = <?php echo json_encode($salesRowsForJs); ?>;
    const inventoryViewHtml = document.getElementById('registerblock').innerHTML;
    const pageOverlay = document.getElementById('pageOverlay');

    function showLoading() {
        if (pageOverlay) {
            pageOverlay.classList.add('active');
            pageOverlay.setAttribute('aria-hidden', 'false');
        }
    }

    function attachLoading(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form || form.dataset.loadingBound === '1') return;

        form.dataset.loadingBound = '1';
        form.addEventListener('submit', (event) => {
            showLoading();
        });
    }

    function rememberPanel(view, type = '') {
        const url = new URL(window.location.href);
        url.searchParams.set('view', view);

        if (type) {
            url.searchParams.set('type', type);
        } else {
            url.searchParams.delete('type');
        }

        url.searchParams.delete('tin');
        url.searchParams.delete('customer');
        url.searchParams.delete('id');
        window.history.replaceState({}, '', url);
    }

    function tableSearchHtml(placeholder) {
        return `<p><input type="text" placeholder="${placeholder}" class="searchbar" oninput="filterTables(this)"></p>`;
    }

    function filterTables(input) {
        const scope = input.closest('.displayer') || input.closest('.register') || document;
        const term = input.value.toLowerCase();

        scope.querySelectorAll('tbody tr').forEach((row) => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    }

    function rowsOrEmpty(rows, emptyMessage, colSpan) {
        return rows.length > 0 ? rows.join('') : `<tr><td colspan="${colSpan}">${emptyMessage}</td></tr>`;
    }

    function showInventoryNew() {
        const form = document.querySelector('.Data-Entry form');
        if (!form) return;

        form.querySelectorAll('input, textarea').forEach((field) => {
            if (field.type !== 'submit' && field.type !== 'hidden') field.value = '';
        });

        const codeField = document.getElementById('inventory_code');
        if (codeField) codeField.value = '';
    }

    function showInventory() {
        rememberPanel('inventory');
        document.getElementById('registerblock').innerHTML = inventoryViewHtml;
        attachLoading('.Data-Entry form');
    }

    function showSupplierNew() {
        window.location.href = 'home.php?view=partners&type=supplier';
    }

    function showCustomerNew() {
        window.location.href = 'home.php?view=partners&type=customer';
    }

    function saveInventory() {
        const form = document.querySelector('.Data-Entry form');
        if (form) form.requestSubmit();
    }

    function saveSupplier() {
        const form = document.querySelector('.supplier-form');
        if (form) form.requestSubmit();
    }

    function saveCustomer() {
        const form = document.querySelector('.customer-form');
        if (form) form.requestSubmit();
    }

    function savePurchase() {
        const form = document.querySelector('.purchase-form');
        if (form) form.requestSubmit();
    }

    function saveSales() {
        const form = document.querySelector('.sales-form');
        if (form) form.requestSubmit();
    }

    function selectInventory(row) {
        const setValue = (name, value) => {
            const field = document.querySelector(`[name="${name}"]`);
            if (field) field.value = value || '';
        };

        const codeField = document.getElementById('inventory_code');
        if (codeField) codeField.value = row.dataset.id || '';

        setValue('sku', row.dataset.sku);
        setValue('nam', row.dataset.name);
        setValue('brand', row.dataset.brand);
        setValue('manufacturer', row.dataset.manufacturer);
        setValue('cos', row.dataset.cost);
        setValue('loc', row.dataset.location);
        setValue('mod', row.dataset.model);
        setValue('pric', row.dataset.price);
        setValue('typ', row.dataset.type);
        setValue('cat', row.dataset.category);
        setValue('uom', row.dataset.measure);
        setValue('barcode', row.dataset.barcode);
        setValue('reorder', row.dataset.reorder);
        setValue('opening_qty', row.dataset.openingQty);
        setValue('status', row.dataset.status);
        setValue('description', row.dataset.description);
    }

    function fillPurchaseItem(codeField) {
        const row = codeField.closest('.purchase-line');
        const nameField = row ? row.querySelector('.purchase-item-name') : null;
        const costField = row ? row.querySelector('.purchase-cost') : null;
        if (!codeField || !nameField) return;

        const selected = inventoryItems.find((item) => item.code === codeField.value);
        if (selected) {
            nameField.value = selected.name;
            if (costField && !costField.value) costField.value = selected.cost;
        } else {
            nameField.value = '';
        }

        updatePurchaseTotal(row);
    }

    function updatePurchaseTotal(row) {
        if (!row) return;

        const quantity = parseFloat(row.querySelector('.purchase-quantity')?.value || '0');
        const cost = parseFloat(row.querySelector('.purchase-cost')?.value || '0');
        const totalField = row.querySelector('.purchase-total');

        if (totalField) {
            totalField.value = (quantity * cost).toFixed(2);
        }

        updateOrderTotals(row.closest('form'));
    }

    function updateOrderTotals(form) {
        if (!form) return;

        let grandTotal = 0;
        form.querySelectorAll('.purchase-line').forEach((line) => {
            const amount = parseFloat(line.querySelector('.purchase-total')?.value || '0');
            grandTotal += Number.isNaN(amount) ? 0 : amount;
        });

        const totalDisplay = form.querySelector('.order-total-value');
        if (totalDisplay) {
            totalDisplay.textContent = grandTotal.toFixed(2);
        }
    }

    function selectPurchaseOrder(poId) {
        const selected = purchaseRows.find((row) => row.po === String(poId));
        if (!selected) return;

        const setValue = (name, value) => {
            const field = document.querySelector(`[name="${name}"]`);
            if (field) field.value = value || '';
        };

        setValue('purchase_supplier', selected.supplier);
        setValue('purchase_invoice_number', selected.invoice);
        setValue('purchase_invoice_date', selected.date);
        setValue('purchase_supplier_tin', selected.tin);
        setValue('purchase_payment_option', selected.payment);

        const rows = document.getElementById('purchase-lines');
        if (!rows) return;

        const orderLines = (selected.lines || [])
            .slice()
            .sort((first, second) => parseInt(first.lineId || '0', 10) - parseInt(second.lineId || '0', 10));

        const lineCount = Math.max(6, orderLines.length + 1);
        rows.innerHTML = purchaseLineHtml(lineCount);
        const lineElements = rows.querySelectorAll('.purchase-line');

        lineElements.forEach((line, index) => {
            const lineData = orderLines[index] || {};
            line.querySelector('.purchase-item-code').value = lineData.itemCode || '';
            line.querySelector('.purchase-item-name').value = lineData.itemName || '';
            line.querySelector('.purchase-quantity').value = lineData.quantity || '';
            line.querySelector('.purchase-cost').value = lineData.cost || '';
            updatePurchaseTotal(line);
        });
    }

    function selectSalesOrder(soId) {
        const selected = salesRows.find((row) => row.so === String(soId));
        if (!selected) return;

        const setValue = (name, value) => {
            const field = document.querySelector(`[name="${name}"]`);
            if (field) field.value = value || '';
        };

        setValue('sales_customer', selected.customer);
        setValue('sales_invoice_number', selected.invoice);
        setValue('sales_invoice_date', selected.date);
        setValue('sales_customer_tin', selected.tin);
        setValue('sales_payment_option', selected.payment);

        const rows = document.getElementById('sales-lines');
        if (!rows) return;

        const orderLines = (selected.lines || [])
            .slice()
            .sort((first, second) => parseInt(first.lineId || '0', 10) - parseInt(second.lineId || '0', 10));

        const lineCount = Math.max(6, orderLines.length + 1);
        rows.innerHTML = salesLineHtml(lineCount);
        const lineElements = rows.querySelectorAll('.purchase-line');

        lineElements.forEach((line, index) => {
            const lineData = orderLines[index] || {};
            line.querySelector('.purchase-item-code').value = lineData.itemCode || '';
            line.querySelector('.purchase-item-name').value = lineData.itemName || '';
            line.querySelector('.purchase-quantity').value = lineData.quantity || '';
            line.querySelector('.purchase-cost').value = lineData.price || '';
            updatePurchaseTotal(line);
        });
    }

    function fillSupplierTin(supplierField) {
        const tinField = document.querySelector('[name="purchase_supplier_tin"]');
        if (!tinField) return;

        const selected = supplierOptions.find((supplier) => supplier.name === supplierField.value);
        tinField.value = selected ? selected.tin : '';
    }

    function purchaseSingleRowHtml(index = 0) {
        return `
            <div class="purchase-line" data-row="${index}">
                <label>
                    <input list="purchase-code-list" class="purchase-item-code" name="purchase_item_code[]" placeholder="Click or type code" oninput="fillPurchaseItem(this)" required>
                </label>
                <label>
                    <input type="text" class="purchase-item-name" name="purchase_item_name[]" placeholder="Generated item name" readonly required>
                </label>
                <label>
                    <input type="number" step="0.01" min="0" class="purchase-quantity" name="purchase_quantity[]" placeholder="Qty" oninput="updatePurchaseTotal(this.closest('.purchase-line'))" required>
                </label>
                <label>
                    <input type="number" step="0.01" min="0" class="purchase-cost" name="purchase_cost[]" placeholder="Cost" oninput="updatePurchaseTotal(this.closest('.purchase-line'))" required>
                </label>
                <label>
                    <input type="text" class="purchase-total" placeholder="0.00" readonly>
                </label>
                <button type="button" class="add-row-button" onclick="addPurchaseRow()" title="Add new row">+</button>
            </div>`;
    }

    function purchaseLineHtml(count = 6) {
        return Array.from({ length: count }, (_, index) => purchaseSingleRowHtml(index)).join('');
    }

    function salesSingleRowHtml(index = 0) {
        return `
            <div class="purchase-line" data-row="${index}">
                <label>
                    <input list="purchase-code-list" class="purchase-item-code" name="sales_item_code[]" placeholder="Click or type code" oninput="fillPurchaseItem(this)">
                </label>
                <label>
                    <input type="text" class="purchase-item-name" name="sales_item_name[]" placeholder="Generated item name" readonly>
                </label>
                <label>
                    <input type="number" step="0.01" min="0" class="purchase-quantity" name="sales_quantity[]" placeholder="Qty" oninput="updatePurchaseTotal(this.closest('.purchase-line'))">
                </label>
                <label>
                    <input type="number" step="0.01" min="0" class="purchase-cost" name="sales_price[]" placeholder="Price" oninput="updatePurchaseTotal(this.closest('.purchase-line'))">
                </label>
                <label>
                    <input type="text" class="purchase-total" placeholder="0.00" readonly>
                </label>
                <button type="button" class="add-row-button" onclick="addSalesRow()" title="Add new row">+</button>
            </div>`;
    }

    function salesLineHtml(count = 6) {
        return Array.from({ length: count }, (_, index) => salesSingleRowHtml(index)).join('');
    }

    function addPurchaseRow() {
        const rows = document.getElementById('purchase-lines');
        if (!rows) return;
        rows.insertAdjacentHTML('beforeend', purchaseSingleRowHtml(rows.children.length));
    }

    function addSalesRow() {
        const rows = document.getElementById('sales-lines');
        if (!rows) return;
        rows.insertAdjacentHTML('beforeend', salesSingleRowHtml(rows.children.length));
    }

    function orderSwitchButtons(activeType) {
        const purchaseActive = activeType === 'purchase' ? 'active' : '';
        const salesActive = activeType === 'sales' ? 'active' : '';

        return `
            <button type="button" class="switch-button ${purchaseActive}" onclick="showOrders('purchase')">Purchase Order</button>
            <button type="button" class="switch-button ${salesActive}" onclick="showOrders('sales')">Sales Order</button>`;
    }

    function showOrders(type = 'purchase') {
        if (type === 'sales') {
            showSalesPanel();
            return;
        }

        rememberPanel('orders', 'purchase');
        document.getElementById("registerblock").innerHTML = `
        <div class="displayer">
            <center><p class="list">Recent Purchase Orders</p></center>
            ${tableSearchHtml('Search Purchase Orders')}
            ${purchaseListHtml}
        </div>
        <div class="register">
            <br>
            <p class="register-item">New Purchase Order</p>
            <div class="panel-settings">
                ${orderSwitchButtons('purchase')}
                <button type="button" onclick="showOrders('purchase')">New</button>
                <button type="button" onclick="savePurchase()">Save</button>
                <button>Copy</button>
                <button>Buy</button>
                <button>Import</button>
                <button>Attachments</button>
                <button>Deactivate</button>
            </div>
            <div class="Data-Entry">
                <br>
                <p class="info">Purchase Item Info</p>
                <br>
                <form method="POST" class="purchase-form">
                    <input type="hidden" name="save_purchase" value="1">
                    <div class="purchase-meta">
                        <label>
                            <span>Supplier</span>
                            <input list="purchase-supplier-list" name="purchase_supplier" placeholder="Supplier name" oninput="fillSupplierTin(this)" required>
                        </label>
                        <label>
                            <span>Invoice Number</span>
                            <input type="text" name="purchase_invoice_number" placeholder="Invoice number" required>
                        </label>
                        <label>
                            <span>Date</span>
                            <input type="date" name="purchase_invoice_date" required>
                        </label>
                        <label>
                            <span>Supplier TIN</span>
                            <input type="text" name="purchase_supplier_tin" placeholder="Supplier TIN" required>
                        </label>
                        <label>
                            <span>Payment Option</span>
                            <input list="payment-option-list" name="purchase_payment_option" placeholder="Net 30" required>
                        </label>
                    </div>
                    <datalist id="purchase-supplier-list">
                        ${supplierOptions.map((supplier) => `<option value="${supplier.name}">${supplier.tin}</option>`).join('')}
                    </datalist>
                    <datalist id="payment-option-list">
                        <option value="Cash">
                        <option value="Net 7">
                        <option value="Net 15">
                        <option value="Net 30">
                        <option value="Net 60">
                        <option value="Bank Transfer">
                    </datalist>
                    <div class="purchase-header">
                        <span>Item Code</span>
                        <span>Item Name</span>
                        <span>Quantity</span>
                        <span>Cost</span>
                        <span>Total</span>
                    </div>
                    <div id="purchase-lines">
                        ${purchaseLineHtml(6)}
                    </div>
                    <div class="order-action-row">
                        <div class="order-total-box">
                            <span>Order Total</span>
                            <strong class="order-total-value">0.00</strong>
                        </div>
                        <input type="submit" name="save_purchase" value="Save Purchase Order" class="submit-button purchase-save">
                    </div>
                    <datalist id="purchase-code-list">
                        ${inventoryItems.map((item) => `<option value="${item.code}">STK30090452${item.code} - ${item.name}</option>`).join('')}
                    </datalist>
                </form>
            </div>
        </div>`;
        attachLoading('.purchase-form');
    }

    function showPurchase() {
        showOrders('purchase');
    }

    function showSalesPanel() {
        rememberPanel('orders', 'sales');
        document.getElementById("registerblock").innerHTML = `
        <div class="displayer">
            <center><p class="list">Recent Sales Orders</p></center>
            ${tableSearchHtml('Search Sales Orders')}
            ${salesListHtml}
        </div>
        <div class="register">
            <br>
            <p class="register-item">New Sales Order</p>
            <div class="panel-settings">
                ${orderSwitchButtons('sales')}
                <button type="button" onclick="showOrders('sales')">New</button>
                <button type="button" onclick="saveSales()">Save</button>
                <button>Copy</button>
                <button>Sell</button>
                <button>Import</button>
                <button>Attachments</button>
                <button>Deactivate</button>
            </div>
            <div class="Data-Entry">
                <br>
                <p class="info">Sales Item Info</p>
                <br>
                <form method="POST" class="sales-form">
                    <div class="purchase-meta">
                        <label>
                            <span>Customer</span>
                            <input type="text" name="sales_customer" placeholder="Customer name">
                        </label>
                        <label>
                            <span>Invoice Number</span>
                            <input type="text" name="sales_invoice_number" placeholder="Invoice number">
                        </label>
                        <label>
                            <span>Date</span>
                            <input type="date" name="sales_invoice_date">
                        </label>
                        <label>
                            <span>Customer TIN</span>
                            <input type="text" name="sales_customer_tin" placeholder="Customer TIN">
                        </label>
                        <label>
                            <span>Payment Option</span>
                            <input list="sales-payment-option-list" name="sales_payment_option" placeholder="Net 30">
                        </label>
                    </div>
                    <datalist id="sales-payment-option-list">
                        <option value="Cash">
                        <option value="Net 7">
                        <option value="Net 15">
                        <option value="Net 30">
                        <option value="Net 60">
                        <option value="Bank Transfer">
                    </datalist>
                    <div class="purchase-header">
                        <span>Item Code</span>
                        <span>Item Name</span>
                        <span>Quantity</span>
                        <span>Price</span>
                        <span>Total</span>
                    </div>
                    <div id="sales-lines">
                        ${salesLineHtml(6)}
                    </div>
                    <div class="order-action-row">
                        <div class="order-total-box">
                            <span>Order Total</span>
                            <strong class="order-total-value">0.00</strong>
                        </div>
                        <input type="hidden" name="save_sales" value="1">
                        <input type="submit" name="save_sales" value="Save Sales Order" class="submit-button purchase-save">
                    </div>
                    <datalist id="purchase-code-list">
                        ${inventoryItems.map((item) => `<option value="${item.code}">STK30090452${item.code} - ${item.name}</option>`).join('')}
                    </datalist>
                </form>
            </div>
        </div>`;
    }

    function showSales() {
        showOrders('sales');
    }

    function partnerSwitchHtml(activeType) {
        const supplierActive = activeType === 'supplier' ? 'active' : '';
        const customerActive = activeType === 'customer' ? 'active' : '';

        return `
            <button type="button" class="switch-button ${supplierActive}" onclick="showPartners('supplier')" aria-selected="${activeType === 'supplier'}">Suppliers</button>
            <button type="button" class="switch-button ${customerActive}" onclick="showPartners('customer')" aria-selected="${activeType === 'customer'}">Customers</button>`;
    }

    function showPartners(type = 'supplier') {
        if (type === 'customer') {
            showCustomerPanel();
            return;
        }

        rememberPanel('partners', 'supplier');
        document.getElementById("registerblock").innerHTML = `
        <div class="displayer">
            <center><p class="list">Registered Suppliers</p></center>
            ${tableSearchHtml('Search Suppliers')}
            ${supplierListHtml}
        </div>
        <div class="register">
            <br>
            <p class="register-item">New Supplier Registration</p>
            <div class="panel-settings">
                ${partnerSwitchHtml('supplier')}
                <button type="button" onclick="showSupplierNew()">New</button>
                <button type="button" onclick="saveSupplier()">Save</button>
                <button>Copy</button>
                <button>Buy</button>
                <button>Sell</button>
                <button>Import</button>
                <button>Attachments</button>
                <button>Deactivate</button>
            </div>
            <p>Basic Supplier Info</p>
            <form action="" method="POST" class="supplier-form Data-Entry">
                <input type="hidden" name="supp" value="1">
                <div class="form-grid partner-grid">
                    <input type="text" placeholder="Tax Identification Number" name="tinn" value="${supplierRow.TINumber || ''}" ${supplierRow.TINumber ? 'readonly' : ''} required>
                    <input list="suppliestype" placeholder="Supplier Type" name="styp" value="${supplierRow.Type || ''}">
                    <input type="text" placeholder="Supplier Name" name="snammm" value="${supplierRow.SUName || ''}" required>
                    <input type="text" placeholder="Contact Person" name="supplier_contact" value="${supplierRow.ContactPerson || ''}">
                    <input type="text" placeholder="Mobile Number" name="mob" value="${supplierRow.Phone || ''}">
                    <input type="email" placeholder="E-mail" name="email" value="${supplierRow.Email || ''}">
                    <input type="text" placeholder="Address" name="supplier_address" value="${supplierRow.Address || ''}">
                    <input type="text" placeholder="City" name="supplier_city" value="${supplierRow.City || ''}">
                    <input type="text" placeholder="Country" name="supplier_country" value="${supplierRow.Country || ''}">
                    <input list="payment-terms-list" placeholder="Payment Terms" name="supplier_payment_terms" value="${supplierRow.PaymentTerms || ''}">
                    <input type="number" step="0.01" placeholder="Credit Limit" name="supplier_credit_limit" value="${supplierRow.CreditLimit || ''}">
                    <input list="partner-status-list" placeholder="Status" name="supplier_status" value="${supplierRow.Status || 'Active'}">
                    <input list="banking" placeholder="Bank Account Name" name="bankk" value="${supplierRow.BName || ''}" required>
                    <input type="text" placeholder="Account Number" name="acc" value="${supplierRow.ACNumber || ''}" required>
                    <textarea class="Itemtextarea" name="supplier_notes" placeholder="Supplier Notes">${supplierRow.Notes || ''}</textarea>
                </div>
                <datalist id="suppliestype">
                    <option value="Foreign">
                    <option value="Local/LP">
                    <option value="SP/Service provider">
                    <option value="Manufacturer">
                    <option value="Distributor">
                    <option value="Subcontractor">
                </datalist>
                <datalist id="banking">
                    <option value="Bank Of Kigali">
                    <option value="Equity Bank">
                    <option value="Banque Populaire Rwanda">
                    <option value="Access Bank Rwanda">
                    <option value="MTN Mobile Money">
                </datalist>
                <datalist id="payment-terms-list">
                    <option value="Cash">
                    <option value="Net 7">
                    <option value="Net 15">
                    <option value="Net 30">
                    <option value="Net 60">
                    <option value="Bank Transfer">
                </datalist>
                <datalist id="partner-status-list">
                    <option value="Active">
                    <option value="Inactive">
                    <option value="On Hold">
                    <option value="Pending Approval">
                </datalist>
                <input type="submit" value="Request an Approval" name="supp" class="submit-button">
            </form>
        </div>`;
        attachLoading('.supplier-form');
    }

    function showCustomerPanel() {
        rememberPanel('partners', 'customer');
        document.getElementById("registerblock").innerHTML = `
        <div class="displayer">
            <center><p class="list">Registered Customers</p></center>
            ${tableSearchHtml('Search Customers')}
            ${customerListHtml}
        </div>
        <div class="register">
            <br>
            <p class="register-item">New Customer Registration</p>
            <div class="panel-settings">
                ${partnerSwitchHtml('customer')}
                <button type="button" onclick="showCustomerNew()">New</button>
                <button type="button" onclick="saveCustomer()">Save</button>
                <button>Copy</button>
                <button>Buy</button>
                <button>Sell</button>
                <button>Import</button>
                <button>Attachments</button>
                <button>Deactivate</button>
            </div>
            <p>Basic Customer Info</p>
            <form action="" method="POST" class="customer-form Data-Entry">
                <input type="hidden" name="cust" value="1">
                <div class="form-grid partner-grid">
                    <input type="text" placeholder="Customer ID / TIN" name="customer_id" value="${customerRow.CustomerID || ''}" ${customerRow.CustomerID ? 'readonly' : ''} required>
                    <input list="customertype" placeholder="Customer Type" name="customer_type" value="${customerRow.Type || ''}">
                    <input type="text" placeholder="Customer Name" name="customer_name" value="${customerRow.CName || ''}" required>
                    <input type="text" placeholder="Contact Person" name="customer_contact" value="${customerRow.ContactPerson || ''}">
                    <input type="text" placeholder="Mobile Number" name="customer_phone" value="${customerRow.Phone || ''}">
                    <input type="email" placeholder="E-mail" name="customer_email" value="${customerRow.Email || ''}">
                    <input type="text" placeholder="Address" name="customer_address" value="${customerRow.Address || ''}">
                    <input type="text" placeholder="City" name="customer_city" value="${customerRow.City || ''}">
                    <input type="text" placeholder="Country" name="customer_country" value="${customerRow.Country || ''}">
                    <input list="customer-payment-terms-list" placeholder="Payment Terms" name="customer_payment_terms" value="${customerRow.PaymentTerms || ''}">
                    <input type="number" step="0.01" placeholder="Credit Limit" name="customer_credit_limit" value="${customerRow.CreditLimit || ''}">
                    <input list="customer-status-list" placeholder="Status" name="customer_status" value="${customerRow.Status || 'Active'}">
                    <input list="customerbanking" placeholder="Bank Account Name" name="customer_bank" value="${customerRow.BName || ''}">
                    <input type="text" placeholder="Account Number" name="customer_acc" value="${customerRow.ACNumber || ''}">
                    <textarea class="Itemtextarea" name="customer_notes" placeholder="Customer Notes">${customerRow.Notes || ''}</textarea>
                </div>
                <datalist id="customertype">
                    <option value="Retail">
                    <option value="Wholesale">
                    <option value="Contractor">
                    <option value="Corporate">
                    <option value="Government">
                    <option value="NGO">
                </datalist>
                <datalist id="customerbanking">
                    <option value="Bank Of Kigali">
                    <option value="Equity Bank">
                    <option value="Banque Populaire Rwanda">
                    <option value="Access Bank Rwanda">
                    <option value="MTN Mobile Money">
                </datalist>
                <datalist id="customer-payment-terms-list">
                    <option value="Cash">
                    <option value="Net 7">
                    <option value="Net 15">
                    <option value="Net 30">
                    <option value="Net 60">
                    <option value="Bank Transfer">
                </datalist>
                <datalist id="customer-status-list">
                    <option value="Active">
                    <option value="Inactive">
                    <option value="On Hold">
                    <option value="Pending Approval">
                </datalist>
                <input type="submit" value="Request an Approval" name="cust" class="submit-button">
            </form>
        </div>`;
        attachLoading('.customer-form');
    }

    function showSuppliers() {
        showPartners('supplier');
    }

    function showCustomers() {
        showPartners('customer');
    }

    function reportLinksHtml() {
        return `
            ${tableSearchHtml('Search Reports')}
            <table class="listing-table report-menu">
                <thead><tr><th>Report</th><th>Type</th></tr></thead>
                <tbody>
                    <tr class="listing-row" onclick="showReportTable('stock')"><td>Physical Stock Count</td><td>Logistics</td></tr>
                    <tr class="listing-row" onclick="showReportTable('sales_customer')"><td>Sales by Customer</td><td>Sales</td></tr>
                    <tr class="listing-row" onclick="showReportTable('sales_items')"><td>Sales by Items</td><td>Sales</td></tr>
                    <tr class="listing-row" onclick="showReportTable('purchases_supplier')"><td>Purchases by Supplier</td><td>Purchases</td></tr>
                    <tr class="listing-row" onclick="showReportTable('inventory_value')"><td>Inventory Value</td><td>Finance</td></tr>
                    <tr class="listing-row" onclick="showReportTable('partners')"><td>Business Partners</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('stock_location')"><td>Stock count by Location</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('location_service')"><td>Location Service Analysis</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('customer_summary')"><td>Sales by customer summary</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('procurement_summary')"><td>Procurement Summary</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('purchase_location')"><td>Purchase Order by Location</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('inventory_supplier')"><td>Inventory Item by Supplier</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('inventory_adjustments')"><td>Invetory Adjustments</td><td>Directory</td></tr>
                    <tr class="listing-row" onclick="showReportTable('partner_tax')"><td>Business Partners by Tax Identity</td><td>Directory</td></tr>
                </tbody>
            </table>`;
    }

    function reportTableHtml(title, headers, rows, emptyMessage, showButtons = false) {
        return `
            <br>
            <p class="register-item">${title}</p>
            ${tableSearchHtml('Search ' + title)}
            ${showButtons ? reportActionButtonsHtml() : ''}
            <table class="listing-table">
                <thead><tr>${headers.map((header) => `<th>${header}</th>`).join('')}</tr></thead>
                <tbody>${rowsOrEmpty(rows, emptyMessage, headers.length)}</tbody>
            </table>`;
    }

    function reportActionButtonsHtml() {
        return `
            <div class="panel-settings report-actions" style="margin-bottom: 1rem;">
                <button type="button" onclick="exportReportToExcel()">Export to Excel</button>
                <button type="button" onclick="printReport()">Print PDF</button>
            </div>`;
    }

    function exportReportToExcel() {
        const output = document.getElementById('report-output');
        if (!output) return;

        const table = output.querySelector('table');
        if (!table) {
            alert('No report data found to export.');
            return;
        }

        const title = (output.querySelector('.register-item')?.textContent || 'report').trim().replace(/\s+/g, '_');
        const html = `<!DOCTYPE html>
<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
<meta charset="UTF-8">
<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>${title}</x:Name><x:WorksheetOptions><x:Print><x:ValidPrinterInfo/></x:Print></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
<style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #666; padding: 5px; }
    th { background-color: #f4f4f4; }
    .report-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
</style>
</head>
<body>
<div class="report-title">${output.querySelector('.register-item')?.textContent || title}</div>
${table.outerHTML}
</body>
</html>`;

        const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `${title}.xls`;
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);
    }

    function printReport() {
        window.print();
    }

    function formatQuantity(value) {
        const numberValue = parseFloat(value || '0');
        return Number.isNaN(numberValue) ? '0.00' : numberValue.toFixed(2);
    }

    function stockCountRowsHtml() {
        return inventoryItems.map((item) => `
            <tr data-stock-code="${item.code}">
                <td>STK30090452${item.code}</td>
                <td>${item.name}</td>
                <td class="stock-system-qty">${formatQuantity(item.quantity)}</td>
                <td>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        class="stock-count-input"
                        data-code="${item.code}"
                        placeholder="${formatQuantity(item.quantity)}"
                        onchange="saveStockCount(this)"
                        onkeydown="if (event.key === 'Enter') { event.preventDefault(); this.blur(); }">
                </td>
            </tr>`);
    }

    function stockAdjustmentRowsHtml() {
        return stockAdjustmentRows.map((row) => {
            const adjustment = parseFloat(row.adjustmentQuantity || '0');
            const status = adjustment > 0 ? `Increase ${formatQuantity(adjustment)}` : adjustment < 0 ? `Decrease ${formatQuantity(Math.abs(adjustment))}` : 'Balanced';

            return `
                <tr>
                    <td>${row.createdAt || ''}</td>
                    <td>STK30090452${row.itemCode}</td>
                    <td>${row.itemName || ''}</td>
                    <td>${formatQuantity(row.systemQuantity)}</td>
                    <td>${formatQuantity(row.physicalQuantity)}</td>
                    <td>${status}</td>
                    <td>${row.createdBy || ''}</td>
                </tr>`;
        });
    }

    function saveStockCount(input) {
        const itemCode = input.dataset.code;
        const physicalQuantity = input.value;
        const item = inventoryItems.find((entry) => entry.code === itemCode);

        if (!itemCode || physicalQuantity === '' || !item) return;

        input.disabled = true;

        const formData = new FormData();
        formData.append('save_stock_count', '1');
        formData.append('ajax', '1');
        formData.append('item_code', itemCode);
        formData.append('physical_quantity', physicalQuantity);

        fetch('home.php', {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.json())
            .then((result) => {
                if (!result.success) {
                    alert(result.message || 'Stock count save failed.');
                    return;
                }

                item.quantity = result.physicalQuantity;
                input.placeholder = result.physicalQuantity;
                input.value = '';

                const row = input.closest('tr');
                const systemQty = row ? row.querySelector('.stock-system-qty') : null;
                if (systemQty) {
                    systemQty.textContent = formatQuantity(result.physicalQuantity);
                }

                stockAdjustmentRows.unshift({
                    id: String(Date.now()),
                    itemCode: result.itemCode,
                    itemName: result.itemName,
                    systemQuantity: result.systemQuantity,
                    physicalQuantity: result.physicalQuantity,
                    adjustmentQuantity: result.adjustmentQuantity,
                    createdBy: result.createdBy,
                    createdAt: result.createdAt,
                });
            })
            .catch(() => {
                alert('Stock count save failed.');
            })
            .finally(() => {
                input.disabled = false;
            });
    }

    function showReportTable(type) {
        const output = document.getElementById('report-output');
        if (!output) return;

        if (type === 'stock') {
            const rows = stockCountRowsHtml();
            output.innerHTML = reportTableHtml('Physical Stock Count', ['Code', 'Item', 'System Qty', 'Physical Qty'], rows, 'No logistics items found.', rows.length > 0);
            return;
        }

        if (type === 'sales_customer') {
            const totals = {};
            salesRows.forEach((row) => {
                const key = row.customer || 'Unknown Customer';
                if (!totals[key]) totals[key] = { orders: 0, total: 0 };
                totals[key].orders += 1;
                totals[key].total += parseFloat(row.price || '0') * parseFloat(row.quantity || '0');
            });
            const rows = Object.keys(totals).map((customer) => `
                <tr>
                    <td>${customer}</td>
                    <td>${totals[customer].orders}</td>
                    <td>${totals[customer].total.toFixed(2)}</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Sales by Customer', ['Customer', 'Orders', 'Total Sales'], rows, 'No sales by customer data found.', rows.length > 0);
            return;
        }

        if (type === 'sales_items') {
            const totals = {};
            salesRows.forEach((row) => {
                const key = row.itemCode || 'Unknown';
                if (!totals[key]) totals[key] = { item: row.itemName || 'Unknown Item', quantity: 0, total: 0 };
                totals[key].quantity += parseFloat(row.quantity || '0');
                totals[key].total += parseFloat(row.price || '0') * parseFloat(row.quantity || '0');
            });
            const rows = Object.keys(totals).map((itemCode) => `
                <tr>
                    <td>${itemCode}</td>
                    <td>${totals[itemCode].item}</td>
                    <td>${totals[itemCode].quantity.toFixed(2)}</td>
                    <td>${totals[itemCode].total.toFixed(2)}</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Sales by Items', ['Item Code', 'Item', 'Quantity', 'Total Sales'], rows, 'No sales by item data found.', rows.length > 0);
            return;
        }

        if (type === 'purchases_supplier') {
            const totals = {};
            purchaseRows.forEach((row) => {
                const key = row.supplier || 'Unknown Supplier';
                if (!totals[key]) totals[key] = { orders: 0, quantity: 0, total: 0 };
                totals[key].orders += 1;
                totals[key].quantity += parseFloat(row.quantity || '0');
                totals[key].total += parseFloat(row.cost || '0') * parseFloat(row.quantity || '0');
            });
            const rows = Object.keys(totals).map((supplier) => `
                <tr>
                    <td>${supplier}</td>
                    <td>${totals[supplier].orders}</td>
                    <td>${totals[supplier].quantity.toFixed(2)}</td>
                    <td>${totals[supplier].total.toFixed(2)}</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Purchases by Supplier', ['Supplier', 'Orders', 'Quantity', 'Total Cost'], rows, 'No purchase data found.', rows.length > 0);
            return;
        }

        if (type === 'inventory_value') {
            const rows = inventoryItems.map((item) => {
                const stockValue = parseFloat(item.cost || '0') * parseFloat(item.quantity || item.quantityOnHand || item.openingQty || '0');
                return `
                <tr>
                    <td>STK30090452${item.code}</td>
                    <td>${item.name}</td>
                    <td>${parseFloat(item.cost || '0').toFixed(2)}</td>
                    <td>${stockValue.toFixed(2)}</td>
                </tr>`;
            });
            output.innerHTML = reportTableHtml('Inventory Value', ['Code', 'Item', 'Unit Cost', 'Stock Value'], rows, 'No logistics value data found.', rows.length > 0);
            return;
        }

        if (type === 'stock_location') {
            const rows = inventoryItems.map((item) => `
                <tr>
                    <td>STK30090452${item.code}</td>
                    <td>${item.name}</td>
                    <td>${item.quantity || '0'}</td>
                    <td>Default Location</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Stock count by Location', ['Code', 'Item', 'Quantity', 'Location'], rows, 'No stock location data found.', rows.length > 0);
            return;
        }

        if (type === 'location_service') {
            const rows = inventoryItems.map((item) => `
                <tr>
                    <td>STK30090452${item.code}</td>
                    <td>${item.name}</td>
                    <td>${item.quantity || '0'}</td>
                    <td>Active</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Location Service Analysis', ['Code', 'Item', 'Stock', 'Service Status'], rows, 'No location service data found.', rows.length > 0);
            return;
        }

        if (type === 'customer_summary') {
            const rows = salesRows.map((row) => `
                <tr>
                    <td>${row.customer || 'Unknown Customer'}</td>
                    <td>${row.invoice || ''}</td>
                    <td>${parseFloat(row.quantity || '0').toFixed(2)}</td>
                    <td>${(parseFloat(row.price || '0') * parseFloat(row.quantity || '0')).toFixed(2)}</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Sales by customer summary', ['Customer', 'Invoice', 'Quantity', 'Total'], rows, 'No customer summary data found.', rows.length > 0);
            return;
        }

        if (type === 'procurement_summary') {
            const rows = purchaseRows.map((row) => `
                <tr>
                    <td>${row.supplier || 'Unknown Supplier'}</td>
                    <td>${row.invoice || ''}</td>
                    <td>${parseFloat(row.quantity || '0').toFixed(2)}</td>
                    <td>${(parseFloat(row.cost || '0') * parseFloat(row.quantity || '0')).toFixed(2)}</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Procurement Summary', ['Supplier', 'Invoice', 'Quantity', 'Total Cost'], rows, 'No procurement summary data found.', rows.length > 0);
            return;
        }

        if (type === 'purchase_location') {
            const rows = purchaseRows.map((row) => `
                <tr>
                    <td>${row.invoice || ''}</td>
                    <td>${row.supplier || 'Unknown Supplier'}</td>
                    <td>${row.itemName || ''}</td>
                    <td>Default Location</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Purchase Order by Location', ['Invoice', 'Supplier', 'Item', 'Location'], rows, 'No purchase location data found.', rows.length > 0);
            return;
        }

        if (type === 'inventory_supplier') {
            const rows = inventoryItems.map((item) => `
                <tr>
                    <td>STK30090452${item.code}</td>
                    <td>${item.name}</td>
                    <td>${supplierOptions[0]?.name || 'No Supplier'}</td>
                    <td>${item.quantity || '0'}</td>
                </tr>`);
            output.innerHTML = reportTableHtml('Inventory Item by Supplier', ['Code', 'Item', 'Supplier', 'Stock'], rows, 'No inventory supplier data found.', rows.length > 0);
            return;
        }

        if (type === 'inventory_adjustments') {
            const rows = stockAdjustmentRowsHtml();
            output.innerHTML = reportTableHtml('Inventory Adjustments', ['Date', 'Code', 'Item', 'System Qty', 'Physical Qty', 'Adjustment', 'Counted By'], rows, 'No inventory adjustments found.', rows.length > 0);
            return;
        }

        if (type === 'partner_tax') {
            const rows = [
                ...supplierOptions.map((supplier) => `
                <tr>
                    <td>${supplier.name}</td>
                    <td>${supplier.tin}</td>
                    <td>Supplier</td>
                </tr>`),
                ...customerOptions.map((customer) => `
                <tr>
                    <td>${customer.name}</td>
                    <td>${customer.id}</td>
                    <td>${customer.type || 'Customer'}</td>
                </tr>`),
            ];
            output.innerHTML = reportTableHtml('Business Partners by Tax Identity', ['Partner', 'Tax ID', 'Type'], rows, 'No tax identity data found.', rows.length > 0);
            return;
        }

        const partnerRows = [
            ...supplierOptions.map((supplier) => `
            <tr>
                <td>${supplier.name}</td>
                <td>${supplier.tin}</td>
                <td>Supplier</td>
            </tr>`),
            ...customerOptions.map((customer) => `
            <tr>
                <td>${customer.name}</td>
                <td>${customer.id}</td>
                <td>${customer.type || 'Customer'}</td>
            </tr>`),
        ];
        output.innerHTML = reportTableHtml('Business Partners', ['Partner', 'TIN', 'Type'], partnerRows, 'No business partners found.', partnerRows.length > 0);
    }

    function showReport() {
        rememberPanel('report');
        document.getElementById("registerblock").innerHTML = `
        <div class="displayer">
            <center><p class="list">Choose The Report Type</p></center>
            ${reportLinksHtml()}
        </div>
        <div class="register" id="report-output">
            ${reportTableHtml('Physical Stock Count', ['Code', 'Item', 'System Qty', 'Physical Qty'], stockCountRowsHtml(), 'No logistics items found.', inventoryItems.length > 0)}
        </div>`;
    }

    function showSettings() {
        rememberPanel('settings');
        document.getElementById("registerblock").innerHTML = `
        <div class="displayer hidden-finance" style="display:none;">
        <center>
        <p class="list">Admin Control Panel</p>
        </center>
        </div>
        <div class="register hidden-finance" style="display:none;">
        <p class="register-item" style="color: blue;">Financial management</p>
        <div class="panel-settings">
        <button type="button">Receivables</button>
        <button type="button">Tax</button>
        <button>Budgetting</button>
        <button>Payroll</button>
        <button>Expense</button>
        <button>Banking</button>
        <button>Petty Cash</button>
        <button>Payables</button></div></div>`;
    }

    if (initialView === "suppliers") {
        showSuppliers();
    } else if (initialView === "customers") {
        showCustomers();
    } else if (initialView === "partners") {
        showPartners(initialPartnerType === 'customer' ? 'customer' : 'supplier');
    } else if (initialView === "purchase") {
        showOrders('purchase');
    } else if (initialView === "sales") {
        showOrders('sales');
    } else if (initialView === "orders") {
        showOrders(initialPartnerType === 'sales' ? 'sales' : 'purchase');
    } else if (initialView === "report") {
        showReport();
    }

    attachLoading('.Data-Entry form');
</script>
</body>
</html>

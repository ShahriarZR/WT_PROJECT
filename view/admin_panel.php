<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <script src="../js/myjs.js"></script>
</head>

<body>
    <h1>Admin</h1>
    <ul style="list-style-type:none;">
        <li><button onclick="dashboard()">Dashboard</button>
            <ul id="adminDashboard" style="list-style-type:none; display:none;">
                <li><button onclick="manageAdmin()">Manage Admin</button></li>
                <li><button onclick="manageCustomer()">Manage Customer</button></li>
                <li><button onclick="manageEmployee()">Manage Employee</button></li>
                <li><button onclick="manageSeller()">Manage Seller</button></li>
            </ul>
        </li>
        <li>Products</li>
        <li>Packages</li>
    </ul>
    <div id="adminSearch" style="display:none;">
        <input type="text" id="searchEmail" placeholder="Enter email to search" />
        <button onclick="searchAdminEmail()">Search</button>
    </div>
    <div id="customerSearch" style="display:none;">
        <input type="text" id="searchCustomerEmail" placeholder="Enter email to search" />
        <button onclick="searchUserByEmail()">Search</button>
    </div>
    <div id="employeeSearch" style="display:none;">
        <input type="text" id="searchEmployeeEmail" placeholder="Enter email to search" />
        <button onclick="searchUserByEmail()">Search</button>
    </div>
    <div id="sellerSearch" style="display:none;">
        <input type="text" id="searchSellerEmail" placeholder="Enter email to search" />
        <button onclick="searchUserByEmail()">Search</button>
    </div>
    <div id="output"></div>
</body>

</html>
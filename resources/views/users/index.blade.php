<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { font-family: Arial; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background: #f4f4f4; }
        button { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>

<h2>User Management</h2>

<!-- CREATE USER -->
<h3>Create User</h3>

<form id="userForm">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone_number" placeholder="Phone" required>
    <input type="password" name="password" placeholder="Password" required>

    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>

    <button type="submit">Create</button>
</form>

<p id="errorBox" style="color:red;"></p>

<!-- FILTER -->
<h3>Filter</h3>

<select id="filterStatus">
    <option value="">All</option>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
</select>

<button onclick="loadUsers()">Apply</button>

<!-- TABLE -->
<h3>Users</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="userTable"></tbody>
</table>

<script>

const API_URL = "/api/users";

// =========================
// LOAD USERS
// =========================
async function loadUsers() {

    try {
        let status = document.getElementById("filterStatus").value;
        let url = API_URL + (status ? "?status=" + status : "");

        let res = await fetch(url, {
            headers: { "Accept": "application/json" }
        });

        let data = await res.json();

        // 🔥 FIX: handle multiple response formats safely
        let users = data.data?.data ?? data.data ?? data;

        if (!Array.isArray(users)) {
            users = [];
        }

        let rows = "";

        users.forEach(user => {
            rows += `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone_number ?? ''}</td>
                    <td>${user.status ?? ''}</td>
                    <td>
                        <button onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                </tr>
            `;
        });

        document.getElementById("userTable").innerHTML = rows;

    } catch (err) {
        console.error(err);
        document.getElementById("errorBox").innerText = "Failed to load users";
    }
}


// =========================
// CREATE USER
// =========================
document.getElementById("userForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    document.getElementById("errorBox").innerText = "";

    let formData = new FormData(this);

    try {
        let res = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        let data = await res.json();

        if (!res.ok) {
            document.getElementById("errorBox").innerText =
                data.message || "Create failed";
            return;
        }

        this.reset();
        loadUsers();

    } catch (err) {
        console.error(err);
        document.getElementById("errorBox").innerText = "Server error";
    }
});


// =========================
// DELETE USER
// =========================
async function deleteUser(id) {

    await fetch(API_URL + "/" + id, {
        method: "DELETE",
        headers: {
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    });

    loadUsers();
}


// INIT
loadUsers();

</script>

</body>
</html>
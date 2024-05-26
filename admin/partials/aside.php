<?php require './partials/head.php'; ?>
<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: white !important;
        background-color: #ff70a6;
    }
</style>

<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px; height: 100vh;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4">Garden Brew (Admin)</span>
    </a>
    <hr>
    <ul id="nav-list" class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="http://localhost/garden-brew/admin/" class="nav-link link-body-emphasis active" data-page="dashboard">
                Dashboard
            </a>
        </li>
        <li>
            <a href="http://localhost/garden-brew/admin/orders.php" class="nav-link link-body-emphasis" data-page="orders">
                Orders
            </a>
        </li>
        <li>
            <a href="http://localhost/garden-brew/admin/products.php" class="nav-link link-body-emphasis" data-page="products">
                Products
            </a>
        </li>

        <li>
            <a href="http://localhost/garden-brew/admin/customers.php" class="nav-link link-body-emphasis" data-page="customers">
                Customer Info
            </a>
        </li>
        <li>
            <a href="http://localhost/garden-brew/admin/reports.php" class="nav-link link-body-emphasis" data-page="reports">
                Reports
            </a>
        </li>
        <li>
            <a href="http://localhost/garden-brew/admin/cash-payment.php" class="nav-link link-body-emphasis" data-page="cash_payment">
                Cash Payment
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <strong>Admin</strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navLinks = document.querySelectorAll("#nav-list .nav-link");

        // Set the active link based on the stored value in localStorage
        const activePage = localStorage.getItem('activePage');
        if (activePage) {
            navLinks.forEach(link => {
                if (link.getAttribute('data-page') === activePage) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });
        }

        navLinks.forEach(link => {
            link.addEventListener("click", function() {
                navLinks.forEach(nav => nav.classList.remove("active"));
                this.classList.add("active");
                localStorage.setItem('activePage', this.getAttribute('data-page'));
            });
        });

        // Set the active link based on the current page URL or other logic
        const currentPage = window.location.pathname.split('/').pop();
        navLinks.forEach(link => {
            if (link.getAttribute('data-page') === currentPage) {
                link.classList.add("active");
            }
        });
    });
</script>
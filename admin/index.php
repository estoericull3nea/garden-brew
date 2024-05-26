<?php
session_start();
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)) {
    header("Location: http://localhost/garden-brew/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <?php require './partials/head.php'; ?>
    <style>
        .box {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>

<body>

    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <div class="d-flex gap-3  mt-2 ms-1 w-100">
            <div class="col">
                <div class="box border p-2" style="width: 200px; height: auto;">
                    <h6>Pending Orders</h6>
                    <h1 class="text-center" id="count_pending_orders"></h1>
                    <div class="text-end">
                        <a href="#" class="text-end text-black fw-medium">See More</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="box border p-2" style="width: 200px; height: auto;">
                    <h6>Canceled Orders</h6>
                    <h1 class="text-center" id="count_canceled_orders"></h1>
                    <div class="text-end">
                        <a href="#" class="text-end text-black fw-medium">See More</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="box border p-2" style="width: 200px; height: auto;">
                    <h6>Approved Orders</h6>
                    <h1 class="text-center" id="count_approved_orders"></h1>
                    <div class="text-end">
                        <a href="#" class="text-end text-black fw-medium">See More</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="box border p-2" style="width: 200px; height: auto;">
                    <h6>Delivered Orders</h6>
                    <h1 class="text-center" id="count_delivered_orders"></h1>
                    <div class="text-end">
                        <a href="#" class="text-end text-black fw-medium">See More</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="box border p-2" style="width: 200px; height: auto;">
                    <h6>Ongoing Orders</h6>
                    <h1 class="text-center" id="count_ongoing_orders"></h1>
                    <div class="text-end">
                        <a href="#" class="text-end text-black fw-medium">See More</a>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script>
        function count_pending_orders() {
            const xhr = new XMLHttpRequest()
            xhr.open('POST', './ajax/count/count_pending_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_pending_orders').textContent = xhr.responseText
            }
            xhr.send()
        }

        function count_canceled_orders() {
            const xhr = new XMLHttpRequest()
            xhr.open('POST', './ajax/count/count_canceled_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_canceled_orders').textContent = xhr.responseText
            }
            xhr.send()
        }

        function count_approved_orders() {
            const xhr = new XMLHttpRequest()
            xhr.open('POST', './ajax/count/count_approved_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_approved_orders').textContent = xhr.responseText
            }
            xhr.send()
        }

        function count_delivered_orders() {
            const xhr = new XMLHttpRequest()
            xhr.open('POST', './ajax/count/count_delivered_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_delivered_orders').textContent = xhr.responseText
            }
            xhr.send()
        }

        function count_ongoing_orders() {
            const xhr = new XMLHttpRequest()
            xhr.open('POST', './ajax/count/count_ongoing_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_ongoing_orders').textContent = xhr.responseText
            }
            xhr.send()
        }


        document.addEventListener("DOMContentLoaded", () => {
            count_pending_orders()
            count_canceled_orders()
            count_approved_orders()
            count_delivered_orders()
            count_ongoing_orders()
        });
    </script>
</body>

</html>
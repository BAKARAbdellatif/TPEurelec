<?php
include_once "helper.php";
?>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="./jquery-3.7.1.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid p-4">
        <h2>Liste des produits</h2>
        <div id="productList" class="row">

        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {

        const interval = setInterval(test, 3000);
        page = 0

        function test() {
            console.log(page++)
            if (page == 10) {
                clearInterval(interval)
            }
        }

        function updateCounter() {
            $.ajax({
                url: "getProducts.php",
                data: {
                    page: page
                },
                type: "POST",
                success: function(response) {
                    console.log(response)
                    $("#productList").append(response)
                },
                error(jqXHR, textStatus, error) {
                    console.error(error)
                }
            })
        }
        updateCounter()
        //clearInterval(interval)

    })
</script>
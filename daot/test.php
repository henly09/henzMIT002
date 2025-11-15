<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan ID</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .scan-custom {
            visibility: hidden;
        }
    </style>
</head>
<body>
    <div class="row d-flex justify-content-center align-items-center clear-input-container camera-custom">
        <div class="d-block">
            <div id="scan-custom" class="d-flex justify-content-center align-items-center scan-custom">
                <span>Please scan the ID</span>
                <div class="spinner-border d-flex justify-content-center m-1" role="status">
                    <span class="sr-only d-flex"></span>
                </div>
            </div>
            <form action="" method="get" class="d-flex justify-content-center align-items-center">
                <div class="d-flex">
                    <input type="number" class="form-control w-50" autofocus placeholder="0000000000" maxlength="10" id="barcode" name="idInput" required class="idInputBox-custom" min="0" oninput="this.value = Math.abs(this.value)" onfocus="showScanCustom()" onblur="hideScanCustom()">
                    <button onclick="barcodeFocus()" class="btn btn-primary input-group-button" type="reset">Scan</button>
                    <button onclick="barcodeFocus()" class="btn btn-success" type="submit">Check</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showScanCustom() {
            document.getElementById('scan-custom').style.display = 'flex';
        }

        function hideScanCustom() {
            document.getElementById('scan-custom').style.display = 'none';
        }

        function barcodeFocus() {
            document.getElementById('barcode').focus();
        }
    </script>
</body>
</html>

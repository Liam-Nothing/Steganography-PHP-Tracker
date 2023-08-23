<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Content-Type" content="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        body {
            background-color: #fcfcfc;
        }

        main {
            margin-top: 50px;
        }

        .card {
            margin: 0 auto;
            float: none;
            margin-bottom: 10px;
            max-width: 90%;
            width: max-content;
        }

        img {
            max-width: 650px;
        }
    </style>
</head>

<body>
    <header>

    </header>
    <main>
        <div class="card">
            <img id="src_image" class="card-img-top" src="img/paysage01.jpg" alt="Paysage image">
            <div class="card-body">
                <div>
                    <h5 class="card-title">Exemple of tracked image.</h5>
                    <p class="card-text">If someone steals your content, you can trace them.<br>You can download the image and decrypt message content with the file input.</p>
                    <a id="href_image" href="img/paysage01.jpg" download class="btn btn-primary">Download</a>
                </div>
                <hr>
                <div>
                    <h5 class="card-title">Change image :</h5>
                    <select class="form-select" id="select_image">
                        <?php
                        $directory = "img_pure";
                        $images = glob($directory . "/*.jpg");

                        foreach ($images as $image) {
                            $imgage_explode = explode('/', $image);
                        ?>
                            <option value="<?= $imgage_explode[array_key_last($imgage_explode)] ?>"><?= $imgage_explode[array_key_last($imgage_explode)] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <hr>
                <div>
                    <div class="mb-3">
                        <h5 class="card-title">Decrypt image :</h5>
                        <input class="form-control" type="file" id="image_with_data">
                        <button id="decrypt_btn" type="button" class="btn btn-primary mt-3">Decryption</button>
                    </div>
                    <div>
                        <h5 class="card-title">Decrypt content :</h5>
                        <textarea class="form-control" id="decrypt_content" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        const selectElement = document.getElementById("select_image");
        const decrypt_btn = document.getElementById("decrypt_btn");

        selectElement.addEventListener('change', (event) => {
            const href_image = document.getElementById("href_image");
            const src_image = document.getElementById("src_image");
            src_image.src = `img/${event.target.value}`;
            href_image.href = `img/${event.target.value}`;
        });

        decrypt_btn.addEventListener('click', (event) => {
            const image_with_data = document.getElementById("image_with_data");
            const formData = new FormData();
            formData.append('image_with_data', image_with_data.files[0]);

            fetch('decrypt.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.type == "error") {
                        alert(data.message);
                    } else {
                        document.getElementById("decrypt_content").value = JSON.stringify(data.content, null, 2);
                    }
                })
                .catch(error => {
                    console.error(error)
                })
        });
    </script>
</body>

</html>
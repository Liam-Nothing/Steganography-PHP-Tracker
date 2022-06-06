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
			max-width: 800px;
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
				<h5 class="card-title">Exemple of tracking image.</h5>
				<p class="card-text">If someone steals your content, you can trace he.<br>You can download the image next to <a href="decrypt.php?file=[filename]">decrypt.php</a>, go on it and change <code>[filename]</code>.</p>
				<a id="href_image" href="img/paysage01.jpg" download class="btn btn-primary">Download</a>
				<hr>
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
		</div>
	</main>
	<footer>

	</footer>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	<script>
		const selectElement = document.getElementById("select_image");

		selectElement.addEventListener('change', (event) => {
			const href_image = document.getElementById("href_image");
			const src_image = document.getElementById("src_image");
			src_image.src = `img/${event.target.value}`;
			href_image.href = `img/${event.target.value}`;
		});
	</script>
</body>

</html>
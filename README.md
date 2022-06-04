# Steganography Tracking PHP

- ## Description :

	This script can be useful on a blog for example or if you are a photographer and you share your pictures on your website. In case of picture leak you will be able to find the source.
	⚠️ Warning this script only work on **JPG/JPEG** because it doesn't support alpha compositing.

- ## Requirements :

  - Apache server

- ## Use encrypt pictures :

  - Add your images in `img_pure`.
  - From your web page like `index.html` target `img` folder. 

  	Exemple : 
	```html 
	<img src="img/paysage01.jpg">
	```

- ## Use decrypt pictures :
  - Download suspicious images next to `decypt.php`.
  - Go on `http://localhost/Steganography-PHP-Tracker/decrypt.php?file=[Filename]`

- ## Edit data in pictures :

	Go in `render_image.php` and you can custom `$user_data`.
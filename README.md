# Steganography Tracking PHP

<p align="center">
    <img src="README_SRC/main_img.png" width="500">
</p>

- ## Description :

    This script can be useful on a blog for example or if you are a photographer and you share your pictures on your website. In case of picture leak you will be able to find the source.
    
    ⚠️ Warning this script only work on **JPG/JPEG** because it doesn't support alpha compositing.

- ## Requirements :

  - Apache server

- ## Use encrypted pictures :

  - Add your images in `img_pure`.
  - From your web page like `index.html` target `img` folder. 

    Exemple : 
    ```html 
    <img src="img/paysage01.jpg">
    ```

- ## Decrypt pictures :
  
  - Use `Decrypt image` form on `index` page.

- ## Edit data in pictures :

    Go in `render_image.php` and you can custom `$user_data`.

- ## Troubleshooting :

    If images are not displayed, check the enable mod_rewrite on your server or check the `extension=gd` in php.ini.
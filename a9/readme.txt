A9 WordPress theme version 1.9.1

Features
A9 built-in functions: Ajax-comments, Anti-spam, Change-header-image, Change-sidebar-position, Comment-embed-images, Comments-distinction, Comment-mail-notify, Gavatar-cache, Http-gzip, Mini-pagenavi, Popular-posts, Related-posts, Recent-comments... all my own codes. also Valid XHTML & CSS.

Installation:
* Extract the a9.zip file, upload the 'a9' folder to '/wp-content/themes/' directory in your web server.
* In your web server root make a directory '/avatar/' (chmod 755) for Gavatar-cache.
* Log in to the WordPress Administration Panels, Select the 'Appearance' menu, Activate the theme.

Notice:
* copy() & mail() of PHP functions are required, otherwise Gavatar-cache & Comment-mail-notify will go wrong.
* Image names start with the letter 'c' must name by category ID. e.g, 'c23.jpg' mean that cat_ID=23 will use. Start with 'header' for change header image by rename it.
* Rename the file 'wp-comments-post.php' at root will stop almost all spam.


/* Chinese */

安裝:
* 將 a9.zip 解壓縮, 上傳 'a9' 目錄到服務器的 '/wp-content/themes/' 路徑.
* 在服務器根目錄建立資料夾: '/avatar/'　權限: 755, 準備 Gravatar 緩存.
* 登錄 WordPress 後台, 進 '外觀' 選項, 啟用主題.

注意:
* PHP 必需有 copy() 和 mail() 功能, 否則 Gavatar-cache 和 Comment-mail-notify 會出錯.
* 'c' 開頭的圖片要依你的分類編號去命名, 例 'c23.jpg' 是 cat_ID=23 時會用到. 'header' 開頭的圖片是首頁圖片, 可自己更名替換.
* 將根目錄 'wp-comments-post.php' 更名可以阻止大部份垃圾評論.
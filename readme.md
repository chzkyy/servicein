# TIDAK UNTUK DIPERJUAL BELIKAN HANYA UNTUK BELAJAR!
# JIKA TEMAN-TEMAN MENEMUKAN ADA YANG MENJUALNYA , HARAP HUBUNGI SAYA !
# TERIMAKASIH
1. Jalankan Composer Install atau composer Update 
2. buat file env dengan cara ketik cp .env.example .env
3. Generate key dengan cara ketik php artisan key:generate
3. Pada .env tambahkan :

        # key api google map
        GOOGLE_MAP_KEY=(google api key)
      
        # google client (untuk register/login with google account)
        GOOGLE_CLIENT_ID=(client id)
        GOOGLE_CLIENT_SECRET=(client secret)
        GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/login/google/callback
        url_GoogleApi=https://maps.googleapis.com/maps/api
        
        # larabug (untuk maintenance bug (optional)) 
        LB_KEY=(larabug key)
        LB_PROJECT_KEY=(register api key disini https://www.larabug.com)
        
        # email validation (untuk email validation saat register)
        emailValidationAPI=(register api key di sini https://emailverification.whoisxmlapi.com)

3. Ketik php artisan migrate
4. Run project laravel dengan mengetik php artisan serve
5. kemudian buka http://127.0.0.1:8000/ pada browser

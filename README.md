# Software
    1. laravel 8x
    2. Authentication: Laravel ui

# Create project using laravel installer
    1. laravel new counselling-systrm-for-students
    2. cd counselling-systrm-for-students
    3. composer require laravel/ui
    4. php artisan ui bootstrap --auth
    5. npm install && npm run dev
# Setup project
    ## Setup database
    1. Name: hotel_management

    ## Edit server url
    1. Hosts File in the computer
       Directory: C:\Windows\System32\drivers\etc
       File: hosts
       Added: 
       /*
            127.0.0.1 counselling-systrm-for-students.test
       */
    2. Xampp File
        Directory: C:\xampp\apache\conf\extra
        File: httpd-vhosts.conf
        Added
        /*
            <VirtualHost *:80>
                DocumentRoot "C:/xampp/htdocs/uog-thesis-projects/counselling-systrm-for-students/public"
                ServerName counselling-systrm-for-students.test
            </VirtualHost>
        */

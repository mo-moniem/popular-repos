
## About Project

#### This Project implement application to discover popular repos on GITHUB 

## To Run Project
- docker build -t my-laravel-app .
- docker run -p 8000:80 my-laravel-app
- goto http://localhost:8000/api/githib
- request params 
  - language => optional
  - order => optional default desc
  - per_page => optional default 10


## To Run Test
- ./vendor/bin/phpunit tests/Unit/GitHubServiceTest.php


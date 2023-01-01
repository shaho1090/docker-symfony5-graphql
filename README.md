## Order Delay Reporting System
### installation:
1. Clone the repository
2. Go to the directory of the repository and make copy of the ".env.example" and save it with ".env" name.   
3. Run:
```
 - docker compose -f docker-compose.dev.yaml up --build -d
```
4. Go to the app directory inside project directory, make a copy from ".env.example file" and name it .env change the app secret key and other settings as you wish.
5. Go to the docker desktop, find the project container and open the app service command-line, then run these commands respectively: 
```
- composer install
- symfony console doctrine:migrations:migrate
```
# Instructions

- run command `cd src && composer update`
- run command `docker-compose up -d`
- try the website using `http://localhost:8080/`
- run tests using phpunit, html unit coverage files located at `src/log/codeCoverage/`

**Known issues**
- Some log files have no permission, kindly run `cd src && chmod -R 777 storage`
- If some .env variables are missing kindly run `cd src && cp .env.example .env`

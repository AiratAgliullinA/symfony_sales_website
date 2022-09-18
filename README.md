# Site for posting advertisements

---

## Install
1. composer install
2. npm install
3. npm run dev
4. Create .env.local at the root of the directory
5. Copy and fill DATABASE_URL from .env to .env.local
6. php bin/console make:migration
7. php bin/console doctrine:migrations:migrate
8. symfony server:start
9. To create a test administrator follow the link: http://127.0.0.1:8000/create/test/admin

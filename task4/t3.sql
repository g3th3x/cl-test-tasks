START TRANSACTION;
INSERT INTO sample.users (name, birthday_at) 
SELECT shop.users.name, shop.users.birthday_at 
FROM shop.users 
WHERE id = 1;
COMMIT;
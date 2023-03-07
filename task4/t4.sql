SELECT u.name
FROM users AS u
INNER JOIN orders AS o ON (o.user_id = u.id)
WHERE ( TIMESTAMPDIFF( YEAR, u.birthday_at, CURDATE() ) ) > 30
AND ( o.created_at < NOW() - INTERVAL 6 MONTH )
GROUP BY u.name
HAVING COUNT(o.id) >= 3
ORDER BY RAND() LIMIT 1;

-- -- For debugging
-- USE shop;
-- 
-- SET @born = 30;
-- SET @month = 6;
-- SET @orders = 3;
-- 
-- SELECT u.name
-- FROM users AS u
-- INNER JOIN orders AS o ON (o.user_id = u.id)
-- WHERE ( TIMESTAMPDIFF( YEAR, u.birthday_at, CURDATE() ) ) > @born
-- AND ( o.created_at < NOW() - INTERVAL @month MONTH )
-- GROUP BY u.name
-- HAVING COUNT(o.id) >= @orders
-- ORDER BY RAND() LIMIT 1;
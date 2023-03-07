SELECT u.name
FROM users AS u
INNER JOIN orders AS o ON o.user_id = u.id
GROUP BY u.name
HAVING COUNT(o.id) > 0;
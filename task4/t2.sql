SELECT p.name, c.name
FROM products AS p
INNER JOIN catalogs AS c ON p.catalog_id = c.id
GROUP BY p.id;
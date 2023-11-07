SELECT
    type,
    DATE(time) AS time,
    ROUND(AVG(value), 2) AS value
FROM metric
WHERE time BETWEEN :from AND :to
AND type IN (:types)
GROUP BY type, DATE(time)
ORDER BY time;
SELECT
    type,
    DATE(time) AS time,
    ROUND(AVG(value), 2) AS value
FROM metric
WHERE time BETWEEN :from AND :to
GROUP BY type, DATE(time)
ORDER BY time;
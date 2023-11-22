SELECT
    type,
    DATE(time) AS time,
    ROUND(--AGGREGATION--(value), 2) AS value
FROM metric
WHERE time BETWEEN :from AND :to
AND type IN (--TYPES--)
GROUP BY type, DATE(time)
ORDER BY time;
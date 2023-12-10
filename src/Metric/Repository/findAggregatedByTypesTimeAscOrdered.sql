SELECT
    type,
    user_id,
    DATE(time) AS time,
    ROUND(--AGGREGATION--(value), 2) AS value
FROM metric
WHERE time BETWEEN :from AND :to
AND type IN (--TYPES--)
    AND user_id = :userId
    GROUP BY type, DATE (time), user_id
ORDER BY time;
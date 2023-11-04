SELECT
    day.id,
    day.date,
    IFNULL(dmp.kcal_sum, 0) + IFNULL(dp.kcal_sum, 0) AS kcal,
    IFNULL(dmp.weight_sum, 0) + IFNULL(dp.weight_sum, 0) AS weight,
    IFNULL(dmp.proteins_sum, 0) + IFNULL(dp.proteins_sum, 0) AS proteins,
    IFNULL(dmp.fats_sum, 0) + IFNULL(dp.fats_sum, 0) AS fats,
    IFNULL(dmp.carbs_sum, 0) + IFNULL(dp.carbs_sum, 0) AS carbs
FROM
    nutrition_log_day day
        LEFT JOIN (
        SELECT
            dm.day_id,
            SUM(IFNULL(dmp.weight, 0)) AS weight_sum,
            SUM(IFNULL(dmp.kcal, 0)) AS kcal_sum,
            SUM(IFNULL(dmp.proteins, 0)) AS proteins_sum,
            SUM(IFNULL(dmp.fats, 0)) AS fats_sum,
            SUM(IFNULL(dmp.carbs, 0)) AS carbs_sum
        FROM
            nutrition_log_day_meal_product dmp
                LEFT JOIN nutrition_log_day_meal dm ON dmp.meal_id = dm.id
        GROUP BY dm.day_id
    ) AS dmp ON dmp.day_id = day.id
    LEFT JOIN (
    SELECT
    dp.day_id,
    SUM(IFNULL(dp.weight, 0)) AS weight_sum,
    SUM(IFNULL(dp.kcal, 0)) AS kcal_sum,
    SUM(IFNULL(dp.proteins, 0)) AS proteins_sum,
    SUM(IFNULL(dp.fats, 0)) AS fats_sum,
    SUM(IFNULL(dp.carbs, 0)) AS carbs_sum
    FROM
    nutrition_log_day_product dp
    GROUP BY dp.day_id
    ) AS dp ON dp.day_id = day.id
WHERE
    day.date >= :from AND day.date <= :to
ORDER BY day.date ASC;

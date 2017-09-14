create table products (title varchar, price integer, data jsonb);

INSERT INTO products VALUES ('Iiyama', 14999, '{
    "diagonal": 24,
    "technology": "LED",
    "connectivity":{
        "VGA":1
    },
    "gsync": false
}');
INSERT INTO products VALUES ('Acer', 45999, '{
    "diagonal": 27,
    "technology": "LED",
    "connectivity":{
        "HDMI":1
    },
    "gsync": true
}');
INSERT INTO products VALUES ('HP', 14404, '{
    "diagonal": 24,
    "technology": "LED",
    "connectivity":{
        "HDMI":1,
        "VGA":1,
        "DVI":1
    },
    "gsync": false
}');
INSERT INTO products VALUES ('Dell', 2400, '{
    "diagonal": 17,
    "technology": "LCD"
}');

SELECT title FROM products WHERE (data->>'diagonal')::int = 24;
SELECT title FROM products WHERE (data->>'diagonal')::int >= 24;
SELECT title FROM products WHERE (data->'connectivity'->>'HDMI')::int >= 1;
UPDATE products SET data = jsonb_set(data, '{connectivity, DVI}', '2') WHERE title = 'HP';
UPDATE products SET data = data - 'gsync' WHERE title = 'Iiyama';

CREATE VIEW keyvalues AS SELECT (jsonb_each(data)).* FROM products;
CREATE VIEW metadata AS SELECT key, value, jsonb_typeof(value) AS type FROM keyvalues;

CREATE OR REPLACE FUNCTION add_value(some_values jsonb, new_value jsonb)
    RETURNS jsonb AS
$$
    SELECT (CASE
        WHEN NOT (some_values ? 'values') THEN
            jsonb_build_object('values', jsonb_build_array(new_value))
        WHEN (array(select * from jsonb_array_elements(some_values->'values')) @> ARRAY[new_value]) THEN
            some_values
        ELSE
            jsonb_build_object('values',
                to_jsonb(
                    array(
                        select * from jsonb_array_elements(some_values->'values')
                    ) || new_value
                )
            )
    END)::jsonb
$$
LANGUAGE 'sql' IMMUTABLE;
-- thibaud=# select add_value('{}'::jsonb, '"bonjour"'::jsonb);
--         add_value
-- -------------------------
--  {"values": ["bonjour"]}
-- (1 ligne)
--
-- thibaud=# select add_value('{"values": ["bonjour"]}'::jsonb, '"bonjour"'::jsonb);
--         add_value
-- -------------------------
--  {"values": ["bonjour"]}
-- (1 ligne)
--
-- thibaud=# select add_value('{"values": ["bonjour"]}'::jsonb, '"bonjour2"'::jsonb);
--               add_value
-- -------------------------------------
--  {"values": ["bonjour", "bonjour2"]}
-- (1 ligne)

CREATE OR REPLACE FUNCTION build_min_max(some_values jsonb, new_value jsonb)
    RETURNS jsonb AS
$$
    SELECT (CASE
        WHEN NOT (some_values ? 'min') OR NOT (some_values ? 'max') THEN
            jsonb_build_object('min', new_value, 'max', new_value)
        WHEN some_values->'min' > new_value THEN
            jsonb_set(some_values, '{min}', new_value)
        WHEN some_values->'max' < new_value THEN
            jsonb_set(some_values, '{max}', new_value)
        ELSE
            some_values
    END)::jsonb
$$
LANGUAGE 'sql' IMMUTABLE;

CREATE OR REPLACE FUNCTION build_sub_object(some_values jsonb, new_value jsonb)
    RETURNS jsonb AS
$$
    select row_to_json(aggregate)::jsonb from (
        select key, type, agg_json (value, type) as data from (
            SELECT key, value, jsonb_typeof(value) AS type FROM (
                SELECT (jsonb_each(new_value)).*
            ) as keyvalues
        ) as metadata group by key, type
    ) as aggregate
$$
LANGUAGE 'sql' IMMUTABLE;


-- SELECT (CASE
--     WHEN NOT (some_values ? 'values') THEN
--         jsonb_build_object('values', jsonb_build_array(new_value))
--     WHEN (array(select * from jsonb_array_elements(some_values->'values')) @> ARRAY[new_value]) THEN
--         some_values
--     ELSE
--         jsonb_build_object('values',
--             to_jsonb(
--                 array(
--                     select * from jsonb_array_elements(some_values->'values')
--                 ) || new_value
--             )
--         )
-- END)::jsonb
-- CREATE VIEW keyvalues AS SELECT (jsonb_each(data)).* FROM products;
-- CREATE VIEW metadata AS SELECT key, value, jsonb_typeof(value) AS type FROM keyvalues;
-- select key, type, agg_json (value, type) as data from metadata group by key, type;
--
--
-- SELECT (CASE
--     WHEN NOT (some_values ? 'min') OR NOT (some_values ? 'max') THEN
--         jsonb_build_object('min', new_value, 'max', new_value)
--     WHEN some_values->'min' > new_value THEN
--         jsonb_set(some_values, '{min}', new_value)
--     WHEN some_values->'max' < new_value THEN
--         jsonb_set(some_values, '{max}', new_value)
--     ELSE
--         some_values
-- END)::jsonb

CREATE OR REPLACE FUNCTION my_aggregate_function(aggregat jsonb, value jsonb, type varchar)
    RETURNS jsonb AS
$$
    SELECT (CASE
        WHEN type = 'boolean' THEN
            '{}'
        WHEN type = 'string' THEN
            add_value(aggregat, value)
        WHEN type = 'number' THEN
            build_min_max(aggregat, value)
        WHEN type = 'object' THEN
            build_sub_object(aggregat, value)
        ELSE
            '{}'
    END)::jsonb
$$
LANGUAGE 'sql' IMMUTABLE;

DROP AGGREGATE agg_json ( jsonb, varchar );
CREATE AGGREGATE agg_json ( jsonb, varchar ) (
    SFUNC = my_aggregate_function,
    STYPE = jsonb,
    INITCOND = '{}'
);

select key, type, agg_json (value, type) as data from metadata group by key, type;

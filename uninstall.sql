-- add table prefix if you have one
DELETE FROM core_config_data WHERE path like 'fixcatalogoptionsort/%';
DELETE FROM core_resource WHERE code = 'fixcatalogoptionsort_setup';
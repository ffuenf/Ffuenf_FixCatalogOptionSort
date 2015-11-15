-- add table prefix if you have one
DELETE FROM core_config_data WHERE path like 'fixcatalogoptionsort/%';
DELETE FROM core_resource WHERE code = 'fixcatalogoptionsort_setup';

-- add table prefix if you have one
DELETE FROM core_config_data WHERE path like 'fixcatalogoptionsort_setup/%';
DELETE FROM core_config_data WHERE path = 'advanced/modules_disable_output/Ffuenf_FixCatalogOptionSort';
DELETE FROM core_resource WHERE code = 'fixcatalogoptionsort_setup_setup';
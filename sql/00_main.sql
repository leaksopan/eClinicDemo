-- SQL Script untuk Database eClinic

-- Membuat Database
CREATE DATABASE IF NOT EXISTS eClinic CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Pilih Database
USE eClinic;

-- Eksekusi file SQL lainnya
SOURCE sql/01_core_tables.sql;
SOURCE sql/02_registration_module.sql;
SOURCE sql/03_clinic_module.sql;
SOURCE sql/04_medical_records.sql;
SOURCE sql/05_pharmacy_module.sql;
SOURCE sql/06_laboratory_radiology.sql;
SOURCE sql/07_finance_module.sql;
SOURCE sql/08_inventory_module.sql;
SOURCE sql/09_letter_module.sql;
SOURCE sql/10_system_settings.sql; 
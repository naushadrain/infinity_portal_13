DROP TABLE IF EXISTS activity_logs;

CREATE TABLE activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    user_name VARCHAR(255) NULL,
    event VARCHAR(100) NOT NULL,
    description VARCHAR(500) NOT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- `public_complaints` is retired as of 2026-07-26: the app no longer reads/writes it.
-- The "Feedback and Complaint" feature (/forms/complaint) now runs entirely on `customer_feedbacks` below.
-- The table itself is left in the live DB (unused) rather than dropped.

CREATE TABLE `customer_feedbacks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref_number` varchar(255) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `wants_interpreter` tinyint(1) NOT NULL DEFAULT 0,
  `interpreter_language` varchar(255) DEFAULT NULL,
  `wants_response` tinyint(1) DEFAULT NULL,
  `preferred_contact_method` varchar(255) DEFAULT NULL,
  `feedback_type` enum('compliment','complaint','comment') DEFAULT NULL,
  `respondent_type` enum('participant','family_member','participants_representative','staff_member','staff_on_behalf_of_participant','other') DEFAULT NULL,
  `respondent_type_other` varchar(255) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `suggestions` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'New',
  `date_closed` date DEFAULT NULL,
  `investigation_undertaken` varchar(255) DEFAULT NULL,
  `investigation_record` text DEFAULT NULL,
  `investigation_findings` text DEFAULT NULL,
  `investigation_actions` text DEFAULT NULL,
  `complainant_feedback` text DEFAULT NULL,
  `improvement_action_required` text DEFAULT NULL,
  `organisational_improvement_actions` text DEFAULT NULL,
  `improvement_implemented` varchar(255) DEFAULT NULL,
  `manager_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_feedbacks_ref_number_unique` (`ref_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;





-- 1) customer_feedbacks table (skipped if it already exists)
CREATE TABLE IF NOT EXISTS `customer_feedbacks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref_number` varchar(255) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `wants_interpreter` tinyint(1) NOT NULL DEFAULT 0,
  `interpreter_language` varchar(255) DEFAULT NULL,
  `wants_response` tinyint(1) DEFAULT NULL,
  `preferred_contact_method` varchar(255) DEFAULT NULL,
  `feedback_type` enum('compliment','complaint','comment') DEFAULT NULL,
  `respondent_type` enum('participant','family_member','participants_representative','staff_member','staff_on_behalf_of_participant','other') DEFAULT NULL,
  `respondent_type_other` varchar(255) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `suggestions` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'New',
  `date_closed` date DEFAULT NULL,
  `investigation_undertaken` varchar(255) DEFAULT NULL,
  `investigation_record` text DEFAULT NULL,
  `investigation_findings` text DEFAULT NULL,
  `investigation_actions` text DEFAULT NULL,
  `complainant_feedback` text DEFAULT NULL,
  `improvement_action_required` text DEFAULT NULL,
  `organisational_improvement_actions` text DEFAULT NULL,
  `improvement_implemented` varchar(255) DEFAULT NULL,
  `manager_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_feedbacks_ref_number_unique` (`ref_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2) medication: manager_note + completed
ALTER TABLE `medication` ADD COLUMN `manager_note` TEXT NULL;
ALTER TABLE `medication` ADD COLUMN `completed` TINYINT(1) NOT NULL DEFAULT 0 AFTER `manager_note`;

-- 3) reporter_details: manager_note
ALTER TABLE `reporter_details` ADD COLUMN `manager_note` TEXT NULL;

-- 4) password_resets: OTP columns for forgot-password
ALTER TABLE `password_resets` ADD COLUMN `otp` VARCHAR(6) NULL AFTER `email`;
ALTER TABLE `password_resets` ADD COLUMN `expires_at` TIMESTAMP NULL AFTER `token`;
ALTER TABLE `password_resets` ADD COLUMN `is_verified` TINYINT(1) NOT NULL DEFAULT 0 AFTER `expires_at`;

-- 5) manager_reports: date_of_issue can be empty
ALTER TABLE `manager_reports` MODIFY `date_of_issue` DATE NULL;


INSERT INTO `migrations` (`migration`, `batch`)
SELECT m.name, (SELECT IFNULL(MAX(batch),0)+1 FROM `migrations`)
FROM (
  SELECT '2026_06_16_000000_create_password_resets_table' AS name UNION ALL
  SELECT '2026_07_25_000000_create_customer_feedbacks_table' UNION ALL
  SELECT '2026_07_26_000000_add_workflow_fields_to_customer_feedbacks_table' UNION ALL
  SELECT '2026_07_26_005000_add_manager_note_to_medication_and_reporter_details_tables' UNION ALL
  SELECT '2026_07_26_010000_add_completed_to_medication_table' UNION ALL
  SELECT '2026_07_26_020000_make_date_of_issue_nullable_on_manager_reports_table'
) m
WHERE m.name NOT IN (SELECT `migration` FROM `migrations`);

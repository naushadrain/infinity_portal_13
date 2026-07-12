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

CREATE TABLE `public_complaints` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `received_from` VARCHAR(150) NOT NULL,
  `email` VARCHAR(255) NULL,
  `contact_number` VARCHAR(30) NULL,
  `complaint` TEXT NOT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'New',
  `submitted_at` DATE NULL,
  `date_closed` DATE NULL,
  `investigation_undertaken` TINYINT(1) NOT NULL DEFAULT 0,
  `investigation_record` TEXT NULL,
  `investigation_findings` TEXT NULL,
  `investigation_actions` TEXT NULL,
  `complainant_feedback` TEXT NULL,
  `improvement_action_required` TEXT NULL,
  `organisational_improvement_actions` TEXT NULL,
  `improvement_implemented` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

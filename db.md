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

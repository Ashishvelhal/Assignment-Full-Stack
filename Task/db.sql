SET NAMES utf8mb4;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  icon_path VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS slides (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  image_path VARCHAR(255) NOT NULL,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_slides_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (name, icon_path) VALUES
  ('Communication', 'files/images/DL-communication.svg'),
  ('Learning', 'files/images/DL-learning.svg'),
  ('Technology', 'files/images/DL-technology.svg');

INSERT INTO slides (category_id, title, description, image_path, sort_order) VALUES
  (1, 'Clear Messaging', 'Craft concise messages that resonate with your audience.', 'files/images/DL-Communication.jpg', 1),
  (1, 'Active Listening', 'Listen first. Respond with empathy and clarity.', 'files/images/DL-Communication.jpg', 2),
  (2, 'Continuous Improvement', 'Adopt a growth mindset and iterate.', 'files/images/DL-Learning-1.jpg', 1),
  (2, 'Share Knowledge', 'Teach others to learn faster together.', 'files/images/DL-Learning-1.jpg', 2),
  (3, 'Practical Innovation', 'Use tech to solve real problems.', 'files/images/DL-Technology.jpg', 1),
  (3, 'Build Robustly', 'Design for reliability and scalability.', 'files/images/DL-Technology.jpg', 2);

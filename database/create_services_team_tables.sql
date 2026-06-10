CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NULL,
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    image VARCHAR(255) NULL,
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Seed services
INSERT INTO services (title, description, image, order_num) VALUES
('Web Development', 'From landing pages to enterprise platforms — we build scalable, secure, and performant web solutions using modern architectures.', 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&h=500&fit=crop&q=80', 1),
('Website Redesign', 'Transform existing digital presence into a modern, high-performance experience without compromising brand identity.', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=500&fit=crop&q=80', 2),
('Network Architecture', 'Design and implementation of resilient, secure, and scalable network infrastructure for organizations of any size.', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop&q=80', 3),
('CMS Development', 'Custom content management platforms engineered for editorial workflows, media management, and publishing at scale.', 'https://images.unsplash.com/photo-1537432376044-ea2f1c5e7f4b?w=800&h=500&fit=crop&q=80', 4);

-- Seed team members
INSERT INTO team_members (name, role, image, order_num) VALUES
('Alexander D.', 'Founder & CEO', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop&q=80', 1),
('Sari R.', 'Lead Developer', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=600&h=400&fit=crop&q=80', 2),
('Budi P.', 'Project Manager', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600&h=400&fit=crop&q=80', 3);

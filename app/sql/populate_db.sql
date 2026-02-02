-- Utilisateurs
INSERT INTO users (firstname, lastname, email, password, role) VALUES
('Admin', 'Ccoworker', 'admin@ccoworker.local',
 '$2y$10$u1D2Q9vYc1MZ5c3w8A5tYeMkp4S7u2pSyyjF1RYwFf6iC7v7E0V2a', 'admin'),

('Alice', 'Martin', 'alice.martin@ccoworker.local',
 '$2y$10$u1D2Q9vYc1MZ5c3w8A5tYeMkp4S7u2pSyyjF1RYwFf6iC7v7E0V2a', 'user'),

('Bob', 'Durand', 'bob.durand@ccoworker.local',
 '$2y$10$u1D2Q9vYc1MZ5c3w8A5tYeMkp4S7u2pSyyjF1RYwFf6iC7v7E0V2a', 'user');

-- Espaces
INSERT INTO spaces (name, capacity, type, equipment) VALUES
('Bureau 101', 2, 'bureau', 'Wifi, Prises électriques'),
('Bureau 102', 1, 'bureau', 'Wifi'),
('Salle Réunion A', 10, 'reunion', 'Projecteur, Tableau blanc, Wifi'),
('Salle Réunion B', 6, 'reunion', 'Écran TV, HDMI, Wifi'),
('Open Space Nord', 20, 'open-space', 'Wifi, Climatisation, Imprimante');

-- Réservations (sans conflit)
-- Réservations pour aujourd'hui
INSERT INTO reservations (space_id, user_id, start_time, end_time) VALUES
(3, 2, '2026-02-02 09:00:00', '2026-02-02 11:00:00'),
(4, 3, '2026-02-02 14:00:00', '2026-02-02 16:00:00');

-- Réservations futures
INSERT INTO reservations (space_id, user_id, start_time, end_time) VALUES
(1, 2, '2026-02-03 10:00:00', '2026-02-03 12:00:00'),
(5, 3, '2026-02-04 09:00:00', '2026-02-04 17:00:00');
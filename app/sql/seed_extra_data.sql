-- 1. On s'assure que les utilisateurs existent (on les insère s'ils n'y sont pas)
INSERT IGNORE INTO users (firstname, lastname, email, password, role, created_at) VALUES 
('Alice', 'Durand', 'alice.durand@example.com', '$2y$12$OXFrAHN8.r2IPfMt0JjYbOPVGmZYZBCi6GbFMC83GLo2Mq.tnc2Tq', 'user', NOW()),
('Bob', 'Martin', 'bob.martin@example.com', '$2y$12$OXFrAHN8.r2IPfMt0JjYbOPVGmZYZBCi6GbFMC83GLo2Mq.tnc2Tq', 'user', NOW());

-- 2. On insère les réservations en cherchant l'ID par l'adresse email
-- Note : On suppose que les espaces ID 1, 2 et 3 existent toujours.
INSERT INTO reservations (space_id, user_id, start_time, end_time, created_at) VALUES 
-- Alice
(1, (SELECT id FROM users WHERE email='alice.durand@example.com'), '2026-02-10 09:00:00', '2026-02-10 12:00:00', NOW()),
(2, (SELECT id FROM users WHERE email='alice.durand@example.com'), '2026-02-12 14:00:00', '2026-02-12 18:00:00', NOW()),
(1, (SELECT id FROM users WHERE email='alice.durand@example.com'), '2026-02-15 09:00:00', '2026-02-17 17:00:00', NOW()),
(3, (SELECT id FROM users WHERE email='alice.durand@example.com'), '2026-03-02 08:30:00', '2026-03-02 12:30:00', NOW()),

-- Bob
(2, (SELECT id FROM users WHERE email='bob.martin@example.com'), '2026-02-11 09:00:00', '2026-02-11 11:00:00', NOW()),
(1, (SELECT id FROM users WHERE email='bob.martin@example.com'), '2026-02-13 13:00:00', '2026-02-13 15:00:00', NOW()),
(3, (SELECT id FROM users WHERE email='bob.martin@example.com'), '2026-02-18 09:00:00', '2026-02-20 18:00:00', NOW()),

-- Jean (l'autre utilisateur de test)
(1, (SELECT id FROM users WHERE email='jean.dupont@example.com'), '2026-02-22 09:00:00', '2026-02-22 13:00:00', NOW()),
(3, (SELECT id FROM users WHERE email='jean.dupont@example.com'), '2026-02-25 10:00:00', '2026-02-25 12:00:00', NOW()),

-- Admin
(3, (SELECT id FROM users WHERE email='admin@coworker.com'), '2026-02-28 09:00:00', '2026-02-28 17:00:00', NOW()),
(1, (SELECT id FROM users WHERE email='admin@coworker.com'), '2026-03-08 09:30:00', '2026-03-08 11:30:00', NOW()),
(2, (SELECT id FROM users WHERE email='admin@coworker.com'), '2026-03-25 14:00:00', '2026-03-25 16:00:00', NOW());
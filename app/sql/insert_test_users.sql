-- Script d'insertion d'un utilisateur administrateur de test
-- Mot de passe : admin123

INSERT INTO users (firstname, lastname, email, password, role, created_at) 
VALUES (
    'Admin', 
    'C\'Coworker', 
    'admin@coworker.com', 
    '$2y$12$fuJHnbYwsWs4b6ZCku8DAOo86py2qfrj3B6D6k4z7QnoS1ff/.09K', 
    'admin', 
    NOW()
);

-- Utilisateur standard de test
-- Mot de passe : user123
INSERT INTO users (firstname, lastname, email, password, role, created_at) 
VALUES (
    'Jean', 
    'Dupont', 
    'jean.dupont@example.com', 
    '$2y$12$OXFrAHN8.r2IPfMt0JjYbOPVGmZYZBCi6GbFMC83GLo2Mq.tnc2Tq', 
    'user', 
    NOW()
);

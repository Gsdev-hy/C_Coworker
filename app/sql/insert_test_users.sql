-- Script d'insertion d'un utilisateur administrateur de test
-- Mot de passe : admin123

INSERT INTO users (firstname, lastname, email, password, role, created_at) 
VALUES (
    'Admin', 
    'C\'Coworker', 
    'admin@coworker.com', 
    '$2y$12$errBPe4.0cEe35dlUFIjfefgaBlzwy/BkyklRRTW9oQY0d53OlLn.u', 
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
    '$2y$12$1JjM3kcvCfgHh1ezQ2lRB.FZRKnh1/pYQ0A1Xp7uBTM7t97eT0rD2', 
    'user', 
    NOW()
);

-- Script d'insertion d'un utilisateur administrateur de test
-- Mot de passe : admin123 (hashé avec password_hash en PHP)

INSERT INTO users (firstname, lastname, email, password, role, created_at) 
VALUES (
    'Admin', 
    'C\'Coworker', 
    'admin@coworker.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
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
    '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 
    'user', 
    NOW()
);

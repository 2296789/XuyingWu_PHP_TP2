CREATE TABLE usager (
    nom VARCHAR(20) PRIMARY KEY,
    mot_passe VARCHAR(255) NOT NULL
);
INSERT INTO usager (nom, mot_passe) VALUES
('AA','$2y$10$0mrwLOoB9dretK0yUk/F5OaTGrldTIZL55zIxtB5IQSODJvkLHI8e'),
('BB','$2y$10$LhWdm7rqlxEyTkOCWOvPnePTJGg425zmmY/v79nuvoIMU/iEAQg1e'),
('CC','$2y$10$Ke71iLEJMW.zf2wXjrGV3.74Q1B6rHWS4hvxxqRL6tcRuE4/SabC6'),
('DD','$2y$10$NCTHVyRlUCee/acc3rsAu.uJT2w6cuPtdaSz.KsUL6q.sKS6WOpqe'),
('EE','$2y$10$B4eyqNhu/i1tYrlN9/W2ROv4vQJMMEmSH0L0dN5kKfMzOOydjkmwq');

CREATE TABLE article (
    id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    texte TEXT NOT NULL,
    auteur VARCHAR(20),
    FOREIGN KEY(auteur) REFERENCES usager(nom)
);
INSERT INTO article (titre, texte, auteur) VALUES
('1','1-----1','AA'),
('2','2-----2','BB'),
('3','3-----3','CC'),
('4','4-----4','DD'),
('5','5-----5','EE');

/*AA:aaaa*/
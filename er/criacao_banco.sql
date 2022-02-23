-- Criando DB e Tabelas
CREATE DATABASE pizzaria;
USE pizzaria;
CREATE TABLE bordas(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tipo VARCHAR(100)
);
SELECT * FROM bordas;

CREATE TABLE massas(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tipo VARCHAR(100)
);
SELECT * FROM massas;

CREATE TABLE sabor(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(100)
);
SELECT * FROM sabor;

CREATE TABLE pizzas(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    bordas_id INT NOT NULL,
    massas_id INT NOT NULL,
    FOREIGN KEY (bordas_id) REFERENCES bordas(id),
    FOREIGN KEY (massas_id) REFERENCES massas(id)
);
SELECT * FROM pizzas;

CREATE TABLE pizza_sabor(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	bordas_id INT NOT NULL,
    sabor_id INT NOT NULL,
    FOREIGN KEY (bordas_id) REFERENCES bordas(id),
    FOREIGN KEY (sabor_id) REFERENCES sabor(id)
);
SELECT * FROM pizza_sabor;

CREATE TABLE status(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	tipo VARCHAR(100)
);
SELECT * FROM status;

CREATE TABLE pedidos(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	pizza_id INT NOT NULL,
    status_id INT NOT NULL,
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id),
    FOREIGN KEY (status_id) REFERENCES status(id)
);
SELECT * FROM pedidos;

-- Inserindo Dados:
-- Status
INSERT INTO status (tipo) VALUES ("Em produção.");
INSERT INTO status (tipo) VALUES ("Em entrega.");
INSERT INTO status (tipo) VALUES ("Concluido.");

-- Massas
INSERT INTO massas (tipo) VALUES ("Massa comum");
INSERT INTO massas (tipo) VALUES ("Massa integral");
INSERT INTO massas (tipo) VALUES ("Massa temperada");

-- Bordas
INSERT INTO bordas (tipo) VALUES ("Cheddar");
INSERT INTO bordas (tipo) VALUES ("Catupiry");

-- Sabores
INSERT INTO sabor (nome) VALUES ("4 Queijos");
INSERT INTO sabor (nome) VALUES ("Frango com Catupiry");
INSERT INTO sabor (nome) VALUES ("Calabresa");
INSERT INTO sabor (nome) VALUES ("Lombinho");
INSERT INTO sabor (nome) VALUES ("Filé com Cheddar");
INSERT INTO sabor (nome) VALUES ("Portuguesa");
INSERT INTO sabor (nome) VALUES ("Margherita");


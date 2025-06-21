CREATE SCHEMA vetlife;

CREATE OR REPLACE FUNCTION vetlife.update_updated_at()
RETURNS TRIGGER AS $$
BEGIN
	NEW.updated_at = CURRENT_TIMESTAMP;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TABLE vetlife.client (
	id SERIAL PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	email VARCHAR(100) UNIQUE NOT NULL,
	phone VARCHAR(20) NOT NULL,
	cpf VARCHAR(11) UNIQUE NOT NULL,
	created_at TIMESTAMP DEFAULT NOW(),
	updated_at TIMESTAMP
);

CREATE TRIGGER update_updated_at_client
BEFORE UPDATE ON vetlife.client
FOR EACH ROW
EXECUTE FUNCTION vetlife.update_updated_at();

CREATE TABLE vetlife.veterinarian (
	id SERIAL PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	email VARCHAR(100) UNIQUE NOT NULL,
	cpf VARCHAR(11) UNIQUE NOT NULL,
	speciality VARCHAR(100) NOT NULL,
	crmv VARCHAR(10) NOT NULL,
	created_at TIMESTAMP DEFAULT NOW(),
	updated_at TIMESTAMP
);

CREATE TRIGGER update_updated_at_veterinarian
BEFORE UPDATE ON vetlife.veterinarian
FOR EACH ROW
EXECUTE FUNCTION vetlife.update_updated_at();

CREATE TABLE vetlife.service (
	id SERIAL PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	description TEXT,
	price NUMERIC(10, 2) NOT NULL,
	duration_minutes INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT NOW(),
	updated_at TIMESTAMP
);

CREATE TRIGGER update_updated_at_service
BEFORE UPDATE ON vetlife.service
FOR EACH ROW
EXECUTE FUNCTION vetlife.update_updated_at();

CREATE TABLE vetlife.scheduling_status (
	id SERIAL PRIMARY KEY,
	name VARCHAR(50)
);

CREATE TABLE vetlife.animal (
	id SERIAL PRIMARY KEY,
	id_client INTEGER NOT NULL,
	name VARCHAR(255) NOT NULL,
	species VARCHAR(255) NOT NULL,
	race VARCHAR(255) NOT NULL,
	sex VARCHAR(100) NOT NULL,
	color VARCHAR(100),
	weight NUMERIC(5, 2) NOT NULL,
	obs TEXT,
	created_at TIMESTAMP DEFAULT NOW(),
	updated_at TIMESTAMP,

	CONSTRAINT fk_animal_client FOREIGN KEY (id_client) REFERENCES vetlife.client(id) ON DELETE CASCADE
);

CREATE TRIGGER update_updated_at_animal
BEFORE UPDATE ON vetlife.animal
FOR EACH ROW
EXECUTE FUNCTION vetlife.update_updated_at();

CREATE TABLE vetlife.scheduling (
	id SERIAL PRIMARY KEY,
	id_animal INTEGER NOT NULL,
	id_vet INTEGER NOT NULL,
	id_service INTEGER NOT NULL,
	id_status INTEGER NOT NULL,
	date date NOT NULL,
	created_at TIMESTAMP DEFAULT NOW(),
	updated_at TIMESTAMP,

	CONSTRAINT fk_scheduling_animal FOREIGN KEY (id_animal) REFERENCES vetlife.animal(id) ON DELETE CASCADE,
	CONSTRAINT fk_scheduling_vet FOREIGN KEY (id_vet) REFERENCES vetlife.veterinarian(id) ON DELETE SET NULL,
	CONSTRAINT fk_scheduling_service FOREIGN KEY (id_service) REFERENCES vetlife.service(id) ON DELETE RESTRICT,
	CONSTRAINT fk_scheduling_status FOREIGN KEY (id_status) REFERENCES vetlife.scheduling_status(id) ON DELETE RESTRICT
);

CREATE TRIGGER update_updated_at_scheduling
BEFORE UPDATE ON vetlife.scheduling
FOR EACH ROW
EXECUTE FUNCTION vetlife.update_updated_at();

CREATE TABLE vetlife.medical_history (
	id SERIAL PRIMARY KEY,
	id_animal INTEGER NOT NULL,
	id_vet INTEGER NOT NULL,
	date TEXT,
	symptoms TEXT,
	diagnosis TEXT,
	treatment TEXT,
	created_at TIMESTAMP DEFAULT NOW(),
	updated_at TIMESTAMP,

	CONSTRAINT fk_medical_history_animal FOREIGN KEY (id_animal) REFERENCES vetlife.animal(id) ON DELETE CASCADE,
	CONSTRAINT fk_medical_history_vet FOREIGN KEY (id_vet) REFERENCES vetlife.veterinarian(id) ON DELETE SET NULL
);

CREATE TRIGGER update_updated_at_medical_history
BEFORE UPDATE ON vetlife.medical_history
FOR EACH ROW
EXECUTE FUNCTION vetlife.update_updated_at();

CREATE TABLE vetlife.user (
	id SERIAL PRIMARY KEY,
	email VARCHAR(100) UNIQUE NOT NULL,
	pwd_hash VARCHAR(255) NOT NULL,
	role VARCHAR(50) NOT NULL,
	created_at TIMESTAMP DEFAULT NOW(),
	updated_at TIMESTAMP
);

CREATE TRIGGER update_updated_at_user
BEFORE UPDATE ON vetlife.user
FOR EACH ROW
EXECUTE FUNCTION vetlife.update_updated_at();


INSERT INTO vetlife.scheduling_status (name) VALUES ('Agendado');
INSERT INTO vetlife.scheduling_status (name) VALUES ('Confirmado');
INSERT INTO vetlife.scheduling_status (name) VALUES ('Cancelado');
INSERT INTO vetlife.scheduling_status (name) VALUES ('Realizado');